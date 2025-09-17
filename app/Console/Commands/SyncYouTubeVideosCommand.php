<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\YouTubeVideoService;
use App\Models\Course;

class SyncYouTubeVideosCommand extends Command
{
    protected $signature = 'videos:sync 
        {course_id : ID do curso destino} 
        {videos? : Lista de IDs separados por vírgula (opcional se usar --file)} 
        {--file= : Caminho para arquivo texto com um videoId por linha} 
        {--publish : Publicar as aulas após criação} 
        {--offset=0 : Sort order inicial}';

    protected $description = 'Sincroniza (upsert) vídeos do YouTube em um curso como lições externas.';

    public function handle(): int
    {
        $courseId = (int) $this->argument('course_id');
        $course = Course::find($courseId);
        if (!$course) {
            $this->error('Curso não encontrado');
            return self::FAILURE;
        }

        $videoList = [];
        if ($file = $this->option('file')) {
            if (!file_exists($file)) {
                $this->error('Arquivo não encontrado: ' . $file);
                return self::FAILURE;
            }
            $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $videoList = array_filter(array_map('trim', $lines));
        } elseif ($videosArg = $this->argument('videos')) {
            $videoList = array_filter(array_map('trim', explode(',', $videosArg)));
        } else {
            $this->error('Informe {videos} ou --file');
            return self::FAILURE;
        }

        if (empty($videoList)) {
            $this->warn('Nenhum videoId fornecido.');
            return self::SUCCESS;
        }

        $service = YouTubeVideoService::make();
        $publish = (bool)$this->option('publish');
        $sortOrder = (int)$this->option('offset');

        $bar = $this->output->createProgressBar(count($videoList));
        $bar->start();

        $created = 0; $updated = 0; $failed = 0;

        foreach ($videoList as $idx => $videoId) {
            $lesson = $service->syncVideo($videoId, $courseId, $sortOrder + $idx, $publish);
            if ($lesson) {
                if ($lesson->wasRecentlyCreated) {
                    $created++;
                } else {
                    $updated++;
                }
            } else {
                $failed++;
            }
            $bar->advance();
        }
        $bar->finish();
        $this->newLine();

        $this->info("Concluído. Criados: {$created}, Atualizados: {$updated}, Falhas: {$failed}");
        return self::SUCCESS;
    }
}
