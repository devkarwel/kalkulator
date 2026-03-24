<?php

namespace Database\Seeders\helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

final class UploadFileFromSeeder {
    private const SOURCE_DIR = 'tmp-img-seeder';
    private const TARGET_DIR = 'temp';

    public static function upload(
        Model $model,
        string $filename,
        string $mediaCollection,
        ?string $productSlug = null,
    ): void
    {
        $sourceFilePath = resource_path(self::SOURCE_DIR . DIRECTORY_SEPARATOR . ($productSlug ?? $model->slug) . DIRECTORY_SEPARATOR . $filename);
        $targetFilePath = self::TARGET_DIR . DIRECTORY_SEPARATOR . ($productSlug ?? $model->slug)  . DIRECTORY_SEPARATOR . $filename;

        $targetPath = Storage::disk('public')->path($targetFilePath);

        Storage::disk('public')->makeDirectory(dirname($targetFilePath));

        File::copy($sourceFilePath, $targetPath);

        $model->addMedia($sourceFilePath)
            ->preservingOriginal()
            ->toMediaCollection($mediaCollection);
    }

    public static function clear(): void
    {
        Storage::deleteDirectory(self::TARGET_DIR);
    }
}
