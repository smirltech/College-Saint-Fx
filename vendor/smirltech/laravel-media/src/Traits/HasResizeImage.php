<?php

namespace SmirlTech\LaravelMedia\Traits;

use Intervention\Image\Image;

trait HasResizeImage
{
    public function createThumbnail(Image $image, ?string $path): void
    {
        $this->resizeImage($image, 300, null);
        $this->addWatermark($image, $path);
    }

    // add watermark

    public function resizeImage(string|Image $image, int $width, ?int $height): Image
    {
        return \Intervention\Image\Facades\Image::make($image)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });


    }

    // create thumbnail with  default size and preserve aspect ratio and add watermark

    public function addWatermark(Image $image, ?string $path): void
    {
        $watermark = Image::make(public_path('images/logo.png'));

        $image->insert($watermark, 'bottom-right', 10, 10);
        if ($path) {
            $image->save($path);
        }
    }


}
