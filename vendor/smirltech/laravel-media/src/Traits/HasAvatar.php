<?php

namespace SmirlTech\LaravelMedia\Traits;

use Exception;
use Illuminate\Http\UploadedFile;

trait HasAvatar
{
    use HasMainImage;

    /**
     * @throws Exception
     */
    public function setAvatarAttribute(UploadedFile $file): void
    {
        $this->setMainImage($this->addMedia(file: $file, collection_name: 'avatars'));
    }

    /**
     * @throws Exception
     */
    public function getAvatarAttribute(): ?string
    {
        return  $this->getAvatarUrl() ?? $this->fetchAvatar($this->avatarName ?? $this->fullName ?? $this->name ?? $this->nom ?? 'User');
    }

    public function fetchAvatar($name, $width = 50, $height = 50): string
    {
        $name = str_replace(' ', '+', $name);
        return "https://ui-avatars.com/api/?name={$name}&background=random&size={$width}x{$height}&color=random";
    }


    public function getAvatarUrl(): ?string
    {
        return $this->media()->where('collection_name', 'avatars')->first()?->url;
    }

}
