<?php

namespace App\Traits;

trait HasAvatar
{
    use \SmirlTech\LaravelMedia\Traits\HasAvatar;

    public function getProfileUrlAttribute(): ?string
    {
        return $this->avatar;
    }


}
