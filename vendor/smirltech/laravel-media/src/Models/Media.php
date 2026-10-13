<?php

namespace SmirlTech\LaravelMedia\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Image;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use SmirlTech\LaravelMedia\Traits\HasResizeImage;
use Str;


/**
 * @property string $location
 * @property array $custom_properties
 * @property string $filename
 * @property string $mime_type
 */
class Media extends Model
{
    use HasUlids, HasResizeImage;

    protected $guarded = [];

    protected $hidden = ['model_type', 'model_id'];

    protected $casts = [
        'custom_properties' => 'array',
    ];


    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /** get media where mime type is image */
    public function scopeImages($query)
    {
        return $query->where('mime_type', 'like', 'image/%');
    }

    /**
     * Set custom_property attribute for backward compatibility
     * @param $value
     * @return void
     * @throws JsonException
     */
    public function setCustomPropertyAttribute($value): void
    {
        $this->attributes['custom_properties'] = Json::encode($value);
    }


    public function getPathAttribute(): string
    {
        return Storage::disk('public')->path($this->location);
    }

    /**
     * Get fontawesome icon name from mime type
     * @return string
     */
    public function getIconAttribute(): string
    {
        return match ($this->mime_type) {
            'application/pdf' => 'file-pdf',
            'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'file-word',
            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'file-excel',
            'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'file-powerpoint',
            'application/zip', 'application/x-7z-compressed', 'application/x-rar-compressed' => 'file-archive',
            'text/plain' => 'file-alt',
            'image/jpg', 'image/jpeg' => 'image',
            default => 'file',
        };
    }

    public function getImageResponse(?int $width, ?int $height): mixed
    {
        $image = Image::make($this->path);
        if ($width or $height) {
            $image = $this->resizeImage($this->path, $width, $height);
        }
        return $image->response();
    }

    public function delete(): bool
    {
        $bool = Storage::disk('public')->delete($this->location);

        if ($bool) {
            return parent::delete();
        }
        return false;

    }

    public function getUrl(): string
    {
        return Storage::disk('public')->url($this->location);
    }

    public function url(): string
    {
        return $this->getUrl();
    }

    public function getUrlAttribute(): string
    {
        return $this->getMediaUrl();
    }

    public function getMediaUrl(): string
    {
        return route('media.show', $this->id);
    }

    public function isMainImage(): bool
    {
        return !($this->model->media->count() > 1) || $this->id == $this->model->media_id;
    }

    // set main image
    public function makeMainImage(): bool
    {
        return $this->model->setMainImage($this);
    }

    public function canBeMainImage(): bool
    {
        // if the model has a media_id column
        return Schema::hasColumn($this->model->getTable(), 'media_id');
    }

    // get directory

    public function getDirectory(): string
    {
        // extract the file location from the media location
        $location = $this->location;
        $parts = explode('/', $location);

        // build string and ignore last part
        $directory = '';
        foreach ($parts as $key => $part) {
            $directory .= $part;
            if ($key === count($parts) - 2) {
                break;
            } else {
                $directory .= '/';
            }
        }

        return $directory;
    }

    /** Files exists  */
    public function hasFile(): bool
    {
        return Storage::disk('public')->exists($this->location);
    }

    public function isImage(): bool
    {
        return Str::contains($this->mime_type, 'image');
    }

}
