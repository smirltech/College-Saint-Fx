<?php

namespace App\Traits;

use App\Enums\MediaType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait CanCrudModel
{
    use WithFileUploads;

    public function saveWithImage(Request $request, Model $entity, MediaType $mediaType): Model
    {

        $entity->fill($request->safe()->except('image'));

        $entity->save();

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $this->upload($file, $entity, $mediaType);

        }

        return $entity;
    }

}
