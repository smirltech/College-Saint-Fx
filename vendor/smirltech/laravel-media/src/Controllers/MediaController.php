<?php

namespace SmirlTech\LaravelMedia\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use SmirlTech\LaravelMedia\Models\Media;

class MediaController extends Controller
{
    public function show(Request $request, string $media)
    {
        $media = Media::findOrFail($media);
        if ($media->isImage()) {
            return $media->getImageResponse(intval($request->width), intval($request->height));
        } else {
            return Response::make(file_get_contents($media->path), 200, [
                'Content-Type' => $media->mime_type,
                'Content-Disposition' => 'inline; filename="' . $media->filename . '"',
            ]);
        }
    }
}
