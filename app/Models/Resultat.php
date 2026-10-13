<?php

namespace App\Models;

use App\Enums\Conduite;
use App\Enums\MediaType;
use App\Enums\ResultatType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use SmirlTech\LaravelMedia\Traits\HasMedia;

class Resultat extends Model
{
    use HasFactory, HasUlids, HasMedia;

    public $guarded = [];

    protected $casts = [
        'custom_property' => ResultatType::class,
        'conduite' => Conduite::class,
    ];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }

    public function getBulletinAttribute(): ?Media
    {
        return $this->getBulletin();
    }

    public function getBulletin(): ?Media
    {
        return $this->getFirstMedia();
    }

    // get bulletin attribute
    public function getBulletinUrlAttribute(): string
    {
        return $this->getFirstMediaUrl();
    }

    public function setBulletinUrlAttribute(UploadedFile $file): void
    {
        $this->upload(file: $file, entity: $this, collection_name: MediaType::bulletin);
    }
}
