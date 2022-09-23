<?php

namespace Kaluchii\FilamentSettings\Pages;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Kaluchii\FilamentSettings\FilamentSettings;
use Spatie\Valuestore\Valuestore;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    public array $data;
    protected static string $view = 'filament-settings::pages.settings';

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    protected function getFormSchema(): array
    {
        return FilamentSettings::$fields;
    }

    public function mount(): void
    {
        $this->form->fill(
            Valuestore::make(
                config('filament-settings.path')
            )->all()
        );
    }

    public function submit(): void
    {
        $this->validate();

        foreach ($this->data as $key => $data) {
            Valuestore::make(
                config('filament-settings.path')
            )->put($key, $data);
        }

        $this->notify('success', static::getSavedNotificationMessage());
    }

    protected static function getNavigationSort(): ?int
    {
        return config('filament-settings.navigation-sort');
    }

    protected static function getNavigationGroup(): ?string
    {
        return config('filament-settings.navigation-group');
    }

    protected static function getNavigationLabel(): string
    {
        return config('filament-settings.navigation-label');
    }

    protected function getSavedNotificationMessage(): ?string
    {
        return __('filament::resources/pages/edit-record.messages.saved');
    }

    protected static function getNavigationIcon(): string
    {
        return config('filament-settings.navigation-icon') ?? 'heroicon-o-cog';
    }

    public static function getSlug(): string
    {
        return config('filament-settings.slug') ?? parent::getSlug();
    }

    protected function getTitle(): string
    {
        return config('filament-settings.page-title') ?? parent::getTitle();
    }

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->canManageSettings() ?? true;
    }
}
