<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Response;


class MediaController extends Controller
{
    // openPdf
    public function show(Media $media)
    {
        return Response::make(file_get_contents(storage_path('app/public/' . $media->location)), 200, [
            'Content-Type' => $media->mime_type,
            'Content-Disposition' => 'inline; filename="' . $media->filename . '"',
        ]);
    }
}
