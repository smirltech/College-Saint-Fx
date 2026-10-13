<?php

namespace App\Traits;

use App\Enums\MediaType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

trait WithFileUploads
{
    use \Livewire\WithFileUploads;


    // upload media
    public function upload(UploadedFile $file, Model $entity, MediaType $mediaType)
    {
        $entity->media()->create([
            'mime_type' => $file->getMimeType(),
            'filename' => $file->getClientOriginalName(),
            'location' => $file->store("{$entity->getTable()}/{$entity->id}/{$mediaType->name}", 'public'),
            'custom_property' => $mediaType->value,
            'size' => $file->getSize(),
        ]);
    }
}
