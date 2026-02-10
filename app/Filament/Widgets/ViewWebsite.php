<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class ViewWebsite extends Widget
{
    protected string $view = 'filament.widgets.view-website';

    protected int | string | array $columnSpan = 1;

    protected static ?int $maxHeight = null;

    public function getWebsiteUrl(): string
    {
        return Cache::get('website_url', 'http://127.0.0.1:8000');
    }
}