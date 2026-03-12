<?php

namespace App\Filament\Resources\CategoryProjects\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Manage Category')
                    ->description('Translate otomatis ke bahasa Inggris saat Save.')
                    ->schema([
                        TextInput::make('name_category_id')
                            ->label('Category')
                            ->placeholder('Contoh: Aplikasi Web')
                            ->required(),
                        TextInput::make('data_filter_category')
                            ->label('Sort Filter')
                            ->placeholder('Contoh: web-app')
                            ->required()
                            ->unique(ignoreRecord: true) 
                            ->helperText('Isi untuk data filter content di halaman portofolio (Gunakan huruf kecil dan tanda hubung).'),
                        Hidden::make('name_category_en')
                            ->dehydrated(),
                    ])->columns(2)->columnSpanFull(),
            ]);
    }
}