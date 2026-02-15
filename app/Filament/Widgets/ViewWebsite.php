<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ViewWebsite extends Widget
{
    protected string $view = 'filament.widgets.view-website';

    protected int | string | array $columnSpan = 1;

    protected static ?int $maxHeight = null;

    public function getWebsiteUrl(): string
    {
        return route('home', ['locale' => app()->getLocale()]);
    }
}