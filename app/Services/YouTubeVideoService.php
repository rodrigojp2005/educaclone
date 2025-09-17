<?php

namespace App\Services;

use App\Models\Lesson;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Serviço para interação básica com vídeos do YouTube (curadoria / metadados).
 * Nota: Para produção, adicionar caching, tratamento de quota, retries exponenciais e logs estruturados.
 */
class YouTubeVideoService
{
    protected string $apiKey;

    public function __construct(?string $apiKey = null)
    {
        $this->apiKey = $apiKey ?? config('services.youtube.key');
    }

    public static function make(): self
    {
        return new self();
    }

    /**
     * Monta URL de embed (mesma lógica centralizada para reuso futuro).
     */
    public function buildEmbedUrl(string $videoId): string
    {
        $params = http_build_query([
            'rel' => 0,
            'modestbranding' => 1,
            'playsinline' => 1,
        ]);
        return "https://www.youtube-nocookie.com/embed/{$videoId}?{$params}";
    }

    /**
     * Busca metadados do vídeo via YouTube Data API v3.
     * Retorna array normalizado ou null se não encontrado/erro.
     */
    public function getMetadata(string $videoId): ?array
    {
        if (!$this->apiKey) {
            // Sem API key: fallback mínimo (somente ID) - pode ser expandido com scraping ético se for aplicável
            return [
                'video_id' => $videoId,
                'title' => $videoId,
                'description' => null,
                'channel_title' => null,
                'channel_url' => null,
                'thumbnail_url' => null,
                'duration_seconds' => null,
                'license' => 'unknown',
            ];
        }

        try {
            $response = Http::get('https://www.googleapis.com/youtube/v3/videos', [
                'id' => $videoId,
                'part' => 'snippet,contentDetails,status',
                'key' => $this->apiKey,
            ]);

            if (!$response->ok()) {
                return null;
            }

            $json = $response->json();
            $item = $json['items'][0] ?? null;
            if (!$item) {
                return null;
            }

            $snippet = $item['snippet'];
            $content = $item['contentDetails'];
            $license = ($snippet['license'] ?? 'youtube') === 'creativeCommon' ? 'creative_commons' : 'standard';

            return [
                'video_id' => $videoId,
                'title' => $snippet['title'] ?? $videoId,
                'description' => $snippet['description'] ?? null,
                'channel_title' => $snippet['channelTitle'] ?? null,
                'channel_url' => isset($snippet['channelId']) ? 'https://www.youtube.com/channel/' . $snippet['channelId'] : null,
                'thumbnail_url' => $snippet['thumbnails']['high']['url'] ?? ($snippet['thumbnails']['default']['url'] ?? null),
                'duration_seconds' => isset($content['duration']) ? $this->parseISODuration($content['duration']) : null,
                'license' => $license,
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Sincroniza (upsert) a lição externa baseada em um videoId e course alvo.
     */
    public function syncVideo(string $videoId, int $courseId, int $sortOrder = 0, bool $publish = false): ?Lesson
    {
        $meta = $this->getMetadata($videoId);
        if (!$meta) {
            return null;
        }

        $slug = Str::slug($meta['title']);

        $lesson = Lesson::updateOrCreate([
            'course_id' => $courseId,
            'provider' => 'youtube',
            'provider_video_id' => $videoId,
        ], [
            'title' => $meta['title'],
            'slug' => $slug,
            'description' => $meta['description'],
            'type' => 'video',
            'provider_signed' => false,
            'is_external' => true,
            'is_published' => $publish,
            'is_active' => true,
            'sort_order' => $sortOrder,
            'source_url' => 'https://www.youtube.com/watch?v=' . $videoId,
            'source_channel_title' => $meta['channel_title'],
            'source_channel_url' => $meta['channel_url'],
            'source_license_type' => $meta['license'] ?? 'unknown',
            'thumbnail_url' => $meta['thumbnail_url'],
            'duration_seconds' => $meta['duration_seconds'],
            'last_checked_at' => now(),
            'check_status' => 'ok',
        ]);

        return $lesson;
    }

    /**
     * Converte duraçao ISO8601 (PT#H#M#S) em segundos.
     */
    protected function parseISODuration(string $iso): int
    {
        $interval = new \DateInterval($iso);
        return ($interval->h * 3600) + ($interval->i * 60) + $interval->s + ($interval->d * 86400);
    }
}
