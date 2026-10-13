<?php

namespace SmirlTech\LaravelMedia;

use Livewire\Livewire;
use SmirlTech\LaravelMedia\Livewire\AvatarComponent;
use SmirlTech\LaravelMedia\Livewire\GalleryComponent;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelMediaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-media')
            //->hasConfigFile()
            ->hasViews()
            ->hasMigration('2023_01_03_100000_create_media_table')
            ->runsMigrations()
            ->hasRoutes('web');

    }

    public function bootingPackage(): void
    {
        Livewire::component('media::gallery-component', GalleryComponent::class);
        Livewire::component('media::avatar-component', AvatarComponent::class);
    }
}
