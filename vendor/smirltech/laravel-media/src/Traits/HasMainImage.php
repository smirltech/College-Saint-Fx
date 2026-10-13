<?php

namespace SmirlTech\LaravelMedia\Traits;


use Exception;
use Illuminate\Support\Facades\Schema;
use SmirlTech\LaravelMedia\Models\Media;

trait HasMainImage
{
    use HasMedia;

    /**
     * Set the primary media for the model.
     * @return mixed
     * @throws Exception
     */
    public function setMainImage(Media $media): mixed
    {
        $this->checkColumn();
        $this->media_id = $media->id;
        return $this->save();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function checkColumn(): void
    {
        if (!$this->hasMainImageColumn()) {
            throw new Exception('The table ' . $this->getTable() . ' does not have a media_id column');
        }
    }

    private function hasMainImageColumn(): bool
    {
        return Schema::hasColumn($this->getTable(), 'media_id');
    }

    /**
     * Clear the primary media for the model.
     * @return mixed
     * @throws Exception
     */
    public function clearMainImages(): mixed
    {
        $this->checkColumn();
        $this->media_id = null;
        return $this->save();
    }

    /**
     * Get the primary media url for the model.
     * @return string|null
     * @throws Exception
     */
    public function getMainImageUrl(): ?string
    {
        return $this->getMainImageAttribute()?->getUrl();
    }

    /**
     * @throws Exception
     */
    public function getMainImageAttribute(): ?Media
    {
        return $this->media()->find($this->media_id);
    }


}
