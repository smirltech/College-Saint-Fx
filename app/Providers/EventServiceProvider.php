<?php

namespace App\Providers;

use App\Listeners\StatusUpdatedListener;
use Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Spatie\ModelStatus\Events\StatusUpdated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        StatusUpdated::class => [
            StatusUpdatedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...
            $event->menu->add([
                    'key' => 'toogle_dark_mode',
                    'text' => '',
                    'icon' => ($this->isDarkModeEnabled()) ? 'fas fa-sun' : 'fas fa-moon',
                    'route' => 'darkmode.toggle',
                    'topnav_right' => true,
                ]
            );
        });
    }

    private function isDarkModeEnabled(): bool
    {
        if (!is_null(session('adminlte_dark_mode', null))) {
            return session('adminlte_dark_mode');
        }

        // Otherwise, fallback to the default package configuration preference.

        return (bool)config('adminlte.layout_dark_mode', false);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
