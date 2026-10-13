<?php

namespace App\Models;

use App\Enums\DevoirReponseStatus;
use App\Enums\MediaType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\UploadedFile;
use SmirlTech\LaravelMedia\Models\Media;
use SmirlTech\LaravelMedia\Traits\HasMedia;

/**
 * @property mixed $devoir_id
 * @property mixed $eleve_id
 */
class DevoirReponse extends Model
{
    use HasFactory, HasUlids, HasMedia;

    public $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'status' => DevoirReponseStatus::class,
    ];

    public function getDocumentAttribute(): ?Media
    {
        return $this->getDocument();
    }

    public function getDocument(): ?Media
    {
        return $this->getFirstMedia();
    }

    // get Document attribute
    public function getDocumentUrlAttribute(): string
    {
        return $this->getFirstMediaUrl();
    }

    public function setDocumentUrlAttribute(UploadedFile $file): void
    {
        $this->upload(file: $file, entity: $this, collection_name: MediaType::document->value);
    }

    // eleve
    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    // devoir
    public function devoir(): BelongsTo
    {
        return $this->belongsTo(Devoir::class);
    }

    // created_at display
    public function getCreatedAtDisplayAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}
