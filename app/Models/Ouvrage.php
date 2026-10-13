<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;
use SmirlTech\LaravelMedia\Traits\HasMainImage;
use Spatie\Tags\HasTags;

class Ouvrage extends Model
{
    use HasFactory, HasMainImage, HasUlids, HasTags;

    public $guarded = [];

    public function lectures(): HasMany
    {
        return $this->hasMany(Lecture::class)->with('user')->orderBy('created_at', 'desc');
    }

    public function getLecturesCountAttribute(): int
    {
        return $this->lectures->count();
    }

    public function getUniqueLecturesCountAttribute(): int
    {
        return $this->uniqueLectures()->count();
    }

    public function uniqueLectures(): Collection
    {
        return collect($this->lectures)->unique('user_id');
    }

    public function getLatestVisitAttribute()
    {
        return $this->lectures->first();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Rayon::class, 'rayon_id');
    }

    public function getCategoryNomAttribute()
    {
        return $this->category?->nom;
    }

    public function deleteAllMedia(?string $collection_name = null): void
    {
        if ($collection_name) {
            $this->media()->where('collection_name', $collection_name)->delete();
        } else {
            $this->media->each->delete();
        }
    }

    public function setAuteursAttribute(?array $auteurs): void
    {
        $this->ouvrageAuteurs()->delete();
        if ($auteurs) {
            foreach ($auteurs as $auteur) {
                $this->ouvrageAuteurs()->create([
                    'auteur_id' => $auteur,
                    //    'ouvrage_id' => $this->id,
                ]);
            }
        }
    }

    public function ouvrageAuteurs(): HasMany|null
    {
        return $this->hasMany(
            related: OuvrageAuteur::class,
        );
    }

    public function auteurs(): HasManyThrough
    {
        return $this->hasManyThrough(
            related: Auteur::class,
            through: OuvrageAuteur::class,
            firstKey: 'ouvrage_id',
            secondKey: 'id',
            localKey: 'id',
            secondLocalKey: 'auteur_id',
        );
    }

    public function setTagsAttribute(?array $tags): void
    {
        if ($tags) {
            $this->tags()->sync($tags);
        }
    }

    // hasPdf()
    public function hasPdf(): bool
    {
        foreach ($this->media as $media) {
            if ($media->mime_type === 'application/pdf') {
                return true;
            }
        }

        return false;
    }

    public function getPdfUrlAttribute(): string
    {

        return $this->getPdf()?->url ?? '';
    }

    public function getPdf()
    {
        foreach ($this->media as $media) {
            if ($media->mime_type === 'application/pdf') {
                return $media;
            }
        }

        return null;
    }

    public function getImageUrlAttribute(): string
    {

        return $this->getImage()?->url ?? '';
    }

    public function getImage()
    {
        foreach ($this->media as $media) {
            if (str_starts_with($media->mime_type, 'image/')) {
                return $media;
            }
        }

        return null;
    }

    public function deleteWithDependencies(): void
    {
        $this->ouvrageAuteurs()->delete();
        $this->lectures()->delete();
        $this->deleteAllMedia();
        $this->tags()->detach();
        $this->delete();
    }

}
