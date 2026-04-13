<?php

namespace App\Console\Commands;

use App\Support\MediaLibrary\GmacPathGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RelocateMediaToStructuredPaths extends Command
{
    protected $signature = 'media:relocate-structured-paths {--dry-run : List moves without renaming folders}';

    protected $description = 'Move legacy media folders (numeric id only) into uploads/{model}/{collection}/{id}/ after enabling GmacPathGenerator';

    public function handle(): int
    {
        $generator = new GmacPathGenerator;
        $disk = Storage::disk((string) config('media-library.disk_name', 'public'));
        $dry = (bool) $this->option('dry-run');

        $moved = 0;
        foreach (Media::query()->orderBy('id')->cursor() as $media) {
            $legacyDir = (string) $media->getKey();
            $targetDir = $generator->directoryWithoutTrailingSlash($media);

            if ($legacyDir === $targetDir) {
                continue;
            }

            if (! $disk->exists($legacyDir)) {
                continue;
            }

            if ($disk->exists($targetDir)) {
                $this->warn("Skip media id={$media->id}: target already exists at {$targetDir}");

                continue;
            }

            $parent = dirname($targetDir);
            $this->line(($dry ? '[dry-run] ' : '')."{$legacyDir}/ → {$targetDir}/");
            if (! $dry) {
                $disk->makeDirectory($parent);
                $disk->move($legacyDir, $targetDir);
            }
            $moved++;
        }

        $this->info($dry ? "Dry run: {$moved} folder(s) would be moved." : "Done. Moved {$moved} folder(s).");

        return self::SUCCESS;
    }
}
