<?php

namespace Kaluchii\FilamentSettings;

use Filament\PluginServiceProvider;
use Livewire\Livewire;
use Kaluchii\FilamentSettings\Components\RenderValues;
use Kaluchii\FilamentSettings\Pages\Settings;
use Spatie\LaravelPackageTools\Package;

class FilamentSettingsProvider extends PluginServiceProvider
{
    public static string $name = 'filament-settings';

    protected function getPages(): array
    {
        return [
            Settings::class,
        ];
    }
}
