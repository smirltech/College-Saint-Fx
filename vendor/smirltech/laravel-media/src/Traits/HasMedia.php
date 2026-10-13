<?php

namespace SmirlTech\LaravelMedia\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use SmirlTech\LaravelMedia\Models\Media;

trait HasMedia
{

    public function addImage(UploadedFile $file): Media
    {
        return $this->addMedia(file: $file, collection_name: 'images');
    }

    public function addMedia(UploadedFile $file, ?string $collection_name = null): Media
    {
        return $this->upload(file: $file, entity: $this, collection_name: $collection_name ?? 'default');
    }

    public function upload(UploadedFile $file, Model $entity, string $collection_name, string $custom_properties = null): Media
    {
        return $entity->media()->create([
            'mime_type' => $file->getMimeType(),
            'filename' => $file->getClientOriginalName(),
            'location' => $file->store("{$entity->getTable()}/{$entity->id}/{$collection_name}", 'public'),
            'custom_properties' => $custom_properties,
            'collection_name' => $collection_name,
            'size' => $file->getSize(),
        ]);
    }


    // is main image

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }


    public function getImageAttribute(): ?string
    {
        return $this->getImageUrlAttribute();
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->mainImage?->url ?? $this->getFirstMediaUrl();
    }

    public function getFirstMediaUrl(): ?string
    {
        $media = $this->getFirstMedia();

        return $media?->url;
    }

    public function getFirstMedia(): null|Media|MorphMany
    {
        return $this->media()->latest()->first();
    }

    // get first media url

    public function getImageSmallAttribute(): ?string
    {
        return $this->getImageUrlAttribute() . "?width=100&height=100";
    }

    // get first media

    public function getImagesAttribute(): ?Collection
    {
        return $this->media()->images()->get();
    }

    // delete media
    public function deleteMedia(Media|string $media): bool
    {
        if (is_string($media)) {
            $media = $this->media()->find($media);
        }
        return $media->delete();
    }

    public function delete(): bool
    {
        // prepare directory
        $directory = $this->getFirstMedia()?->getDirectory();
        // delete files
        foreach ($this->media as $media) {
            $media->delete();
        }
        // remove folder and delete model
        if ($directory) {
            if (Storage::disk('public')->deleteDirectory($directory)) {
                return parent::delete();
            }
        } else {
            return parent::delete();
        }
        return false;
    }

    public function deleteAllMedia(?string $collection_name = null): void
    {
        if ($collection_name) {
            $this->media()->where('collection_name', $collection_name)->delete();
        } else {
            $this->media->each->delete();
        }
    }
}
