<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use SmirlTech\LaravelFullcalendar\Event;

class PresenceInscription extends Pivot implements Event
{
    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

    // get eleve attribute from inscription
    public function getEleveAttribute()
    {
        return $this->inscription->eleve;
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle(): string
    {
        return $this->status->label();
    }

    public function getColor(): string
    {
        return $this->status->color2();
    }

    /**
     * Optional FullCalendar.io settings for this event
     *
     * @return array
     */
    public function getEventOptions()
    {
        return [
            'color' => $this->status->colorNonBootstrap(),
            //etc
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function isAllDay(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getStart(): DateTime
    {
        // set start time to 8:00 from presence date
        return Carbon::parse($this->date)->setTime(8, 0);
    }

    /**
     * {@inheritDoc}
     */
    public function getEnd(): DateTime
    {
        //set start time to 13:00 from presence date
        return Carbon::parse($this->date)->setTime(13, 0);
    }

    /**
     * {@inheritDoc}
     */
    public function getId(): int|string|null
    {
        return $this->id;
    }
}
