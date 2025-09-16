<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    use HasFactory;

    protected $table = 'lesson_progress';

    protected $fillable = [
        'is_completed',
        'watch_time_seconds',
        'started_at',
        'completed_at',
        'last_watched_at',
        'user_id',
        'lesson_id',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'last_watched_at' => 'datetime',
    ];

    /**
     * Get the user that owns the lesson progress.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the lesson that owns the progress.
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Scope a query to only include completed progress.
     */
    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    /**
     * Mark the lesson as started.
     */
    public function markAsStarted()
    {
        if (!$this->started_at) {
            $this->update([
                'started_at' => now(),
                'last_watched_at' => now(),
            ]);
        } else {
            $this->update(['last_watched_at' => now()]);
        }
    }

    /**
     * Mark the lesson as completed.
     */
    public function markAsCompleted()
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now(),
            'last_watched_at' => now(),
        ]);

        // Update course enrollment progress
        $enrollment = Enrollment::where('user_id', $this->user_id)
            ->whereHas('course.lessons', function ($query) {
                $query->where('id', $this->lesson_id);
            })
            ->first();

        if ($enrollment) {
            $enrollment->updateProgress();
        }
    }

    /**
     * Update watch time.
     */
    public function updateWatchTime($seconds)
    {
        $this->update([
            'watch_time_seconds' => max($this->watch_time_seconds, $seconds),
            'last_watched_at' => now(),
        ]);

        // Auto-complete if watched enough (e.g., 90% of video)
        if ($this->lesson->duration_minutes > 0) {
            $lessonDurationSeconds = $this->lesson->duration_minutes * 60;
            $watchPercentage = ($seconds / $lessonDurationSeconds) * 100;

            if ($watchPercentage >= 90 && !$this->is_completed) {
                $this->markAsCompleted();
            }
        }
    }

    /**
     * Get the watch percentage.
     */
    public function getWatchPercentageAttribute()
    {
        if ($this->lesson->duration_minutes === 0) {
            return 0;
        }

        $lessonDurationSeconds = $this->lesson->duration_minutes * 60;
        return min(100, round(($this->watch_time_seconds / $lessonDurationSeconds) * 100));
    }
}
