<?php

namespace App\Traits;

use App;
use Jantinnerezo\LivewireAlert\LivewireAlert;

trait HasLivewireAlert
{
    use LivewireAlert;


    /**
     * @param string $local
     * @param string|null $production
     */
    public function error(string $local, ?string $production = null): void
    {
        $this->alert('error', App::hasDebugModeEnabled() ? $local : $production ?? $local, [
            'toast' => false,
            'timer' => null,
            'duration' => 10000,
        ]);
    }

    /**
     * @param string $message
     * @param array $options
     */
    public function success(string $message, array $options = []): void
    {

        $this->alert('success', $message, $options);
    }

    public function flashSuccess(string $message, string $redirect, array $options = []): void
    {

        $this->flash('success', $message, $options, $redirect);
    }

    public function flashWarning(string $message, string $redirect, array $options = []): void
    {

        $this->flash('warning', $message, $options, $redirect);
    }

    /**
     * @param string $message
     * @param array $options
     * @return void
     */
    public function warning(string $message, array $options = []): void
    {

        $this->alert('warning', $message, $options);
    }
}
