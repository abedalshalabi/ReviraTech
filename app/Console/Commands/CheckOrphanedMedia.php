<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CheckOrphanedMedia extends Command
{
    protected $signature = 'media:check-orphaned';
    protected $description = 'Check for orphaned media files in database';

    public function handle()
    {
        $this->info('Checking for orphaned media files...');
        
        $orphanedCount = 0;
        
        Media::all()->each(function ($media) use (&$orphanedCount) {
            if (!file_exists($media->getPath())) {
                $this->error("Missing file: {$media->file_name} (ID: {$media->id})");
                $orphanedCount++;
            }
        });
        
        if ($orphanedCount === 0) {
            $this->info('No orphaned media files found.');
        } else {
            $this->warn("Found {$orphanedCount} orphaned media records.");
        }
        
        return 0;
    }
}