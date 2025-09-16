<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'comment',
        'is_approved',
        'reviewed_at',
        'user_id',
        'course_id',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course that owns the review.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Scope a query to only include approved reviews.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope a query to order by most recent.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('reviewed_at', 'desc');
    }

    /**
     * Scope a query to filter by rating.
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Get the star rating as a formatted string.
     */
    public function getStarsAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    /**
     * Check if the review is positive (4-5 stars).
     */
    public function isPositive()
    {
        return $this->rating >= 4;
    }

    /**
     * Check if the review is negative (1-2 stars).
     */
    public function isNegative()
    {
        return $this->rating <= 2;
    }

    /**
     * Check if the review is neutral (3 stars).
     */
    public function isNeutral()
    {
        return $this->rating === 3;
    }

    /**
     * Get the review sentiment.
     */
    public function getSentimentAttribute()
    {
        if ($this->isPositive()) {
            return 'positive';
        } elseif ($this->isNegative()) {
            return 'negative';
        } else {
            return 'neutral';
        }
    }
}
