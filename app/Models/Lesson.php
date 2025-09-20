<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Services\CloudflareStreamService;
use App\Services\BunnyStreamService;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'provider',
        'provider_video_id',
        'provider_signed',
        'video_url',
        'video_file',
        'content',
        'file_path',
        'duration_minutes',
        'sort_order',
        'is_free',
        'is_published',
        'quiz_data',
        'course_id',
        // External / curation fields
        'is_external',
        'is_teaser',
        'is_active',
        'source_url',
        'source_channel_title',
        'source_channel_url',
        'source_license_type',
        'thumbnail_url',
        'duration_seconds',
        'last_checked_at',
        'check_status',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'is_published' => 'boolean',
        'quiz_data' => 'array',
        'provider_signed' => 'boolean',
        'is_external' => 'boolean',
        'is_teaser' => 'boolean',
        'is_active' => 'boolean',
        'last_checked_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lesson) {
            if (empty($lesson->slug)) {
                $lesson->slug = Str::slug($lesson->title);
            }
        });

        static::updating(function ($lesson) {
            if ($lesson->isDirty('title') && empty($lesson->slug)) {
                $lesson->slug = Str::slug($lesson->title);
            }
        });
    }

    /**
     * Get the course that owns the lesson.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lesson progress for users.
     */
    public function progress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    /**
     * Scope a query to only include published lessons.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to only include free lessons.
     */
    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    /**
     * Scope a query to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    /**
     * Check if the lesson is a video.
     */
    public function isVideo()
    {
        return $this->type === 'video';
    }

    /**
     * Check if the lesson is text content.
     */
    public function isText()
    {
        return $this->type === 'text';
    }

    /**
     * Check if the lesson is a quiz.
     */
    public function isQuiz()
    {
        return $this->type === 'quiz';
    }

    /**
     * Check if the lesson has a file.
     */
    public function isFile()
    {
        return $this->type === 'file';
    }

    /**
     * Get the video source (URL or file).
     */
    public function getVideoSourceAttribute()
    {
        // Prefer provider-based playback when configured
        if ($this->provider && $this->provider_video_id) {
            try {
                if ($this->provider === 'youtube') {
                    return $this->youtubeEmbedUrl($this->provider_video_id);
                } elseif ($this->provider === 'cloudflare') {
                    $svc = CloudflareStreamService::fromConfig();
                    // Use iframe embed with signed token when enabled
                    return $svc->iframeUrl($this->provider_video_id);
                } elseif ($this->provider === 'bunny') {
                    $svc = BunnyStreamService::fromConfig();
                    return $svc->iframeUrl($this->provider_video_id);
                }
            } catch (\Throwable $e) {
                // silently fallback below
            }
        }

        // Fallbacks (legacy)
        if ($this->video_url) {
            // If a YouTube URL was stored as a direct URL, convert to proper embed at runtime
            $id = $this->extractYouTubeIdFromUrl($this->video_url);
            if ($id) {
                return $this->youtubeEmbedUrl($id);
            }
            return $this->video_url;
        }
        if ($this->video_file) {
            return asset('storage/videos/' . $this->video_file);
        }
        return null;
    }

    /**
     * Get the file download URL.
     */
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/files/' . $this->file_path);
        }

        return null;
    }

    /**
     * Format duration for display.
     */
    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;

        if ($hours > 0) {
            return sprintf('%dh %02dm', $hours, $minutes);
        }

        return sprintf('%dm', $minutes);
    }

    /**
     * Build YouTube embed URL (privacy-enhanced domain).
     */
    protected function youtubeEmbedUrl(string $videoId): string
    {
        // Use youtube-nocookie (privacy) or standard youtube domain based on config
        $useNoCookie = (bool) (config('video.youtube.use_nocookie_domain', true));
        $host = $useNoCookie ? 'https://www.youtube-nocookie.com' : 'https://www.youtube.com';
        $params = http_build_query([
            'rel' => 0,
            'modestbranding' => 1,
            'playsinline' => 1,
        ]);
        return "$host/embed/{$videoId}?{$params}";
    }

    /**
     * Best-effort YouTube ID extractor for various URL formats.
     */
    protected function extractYouTubeIdFromUrl(string $value): ?string
    {
        $value = trim($value);
        // Raw ID
        if (preg_match('~^[a-zA-Z0-9_-]{11}$~', $value)) {
            return $value;
        }
        // Common URL patterns: watch?v=, youtu.be/, embed/, shorts/
        if (preg_match('~(?:v=|youtu\.be/|embed/|shorts/)([a-zA-Z0-9_-]{11})~', $value, $m)) {
            return $m[1];
        }
        return null;
    }

    /**
     * Scope: only external curated lessons.
     */
    public function scopeExternal($query)
    {
        return $query->where('is_external', true);
    }

    /**
     * Scope: active lessons.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
