<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LessonPlaybackController extends Controller
{
    /**
     * Retorna dados de playback para uma lição (YouTube / provedor interno).
     * MVP: apenas YouTube e iframe providers existentes.
     */
    public function show(Request $request, Lesson $lesson)
    {
        if (!$lesson->is_published || !$lesson->is_active) {
            return response()->json(['message' => 'Lesson inactive'], Response::HTTP_GONE);
        }

        // Futuro: validar matrícula quando não for free / teaser / external curated
        // if (!$lesson->is_free && !$lesson->is_external) { ... }

        $source = $lesson->video_source; // accessor getVideoSourceAttribute
        if (!$source) {
            return response()->json(['message' => 'Playback source unavailable'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'id' => $lesson->id,
            'title' => $lesson->title,
            'provider' => $lesson->provider,
            'is_external' => $lesson->is_external,
            'is_teaser' => $lesson->is_teaser,
            'embed_url' => $source,
            'thumbnail_url' => $lesson->thumbnail_url,
            'duration_seconds' => $lesson->duration_seconds,
            'source_channel_title' => $lesson->source_channel_title,
            'source_channel_url' => $lesson->source_channel_url,
        ]);
    }
}
