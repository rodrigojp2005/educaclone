<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'price_paid',
        'status',
        'enrolled_at',
        'completed_at',
        'progress_percentage',
        'last_accessed_at',
        'user_id',
        'course_id',
    ];

    protected $casts = [
        'price_paid' => 'decimal:2',
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'last_accessed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the enrollment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course that owns the enrollment.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Scope a query to only include active enrollments.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include completed enrollments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Check if the enrollment is active.
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if the enrollment is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Mark the enrollment as completed.
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress_percentage' => 100,
        ]);
    }

    /**
     * Update the last accessed time.
     */
    public function updateLastAccessed()
    {
        $this->update(['last_accessed_at' => now()]);
    }

    /**
     * Calculate and update progress percentage.
     */
    public function updateProgress()
    {
        $totalLessons = $this->course->lessons()->published()->count();
        
        if ($totalLessons === 0) {
            return;
        }

        $completedLessons = LessonProgress::where('user_id', $this->user_id)
            ->whereHas('lesson', function ($query) {
                $query->where('course_id', $this->course_id);
            })
            ->where('is_completed', true)
            ->count();

        $progressPercentage = round(($completedLessons / $totalLessons) * 100);

        $this->update(['progress_percentage' => $progressPercentage]);

        // Mark as completed if 100% progress
        if ($progressPercentage >= 100 && $this->status !== 'completed') {
            $this->markAsCompleted();
        }
    }
}
