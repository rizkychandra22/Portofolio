<?php

namespace App\Filament\Resources\CategoryProjects\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Stichoza\GoogleTranslate\GoogleTranslate;

class CategoryProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Manage Category')
                    ->description('Input nama kategori (ID) untuk translate otomatis, dan filter untuk category portofolio.')
                    ->schema([
                        TextInput::make('name_category_id')
                            ->label('Name Category (ID)')
                            ->placeholder('Contoh: Aplikasi Web')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $state, Set $set) {
                                if (blank($state)) return;
                                try {
                                    $tr = new GoogleTranslate();
                                    $translated = $tr->setSource('id')->setTarget('en')->translate($state);
                                    $set('name_category_en', $translated);
                                } catch (\Exception $e) {
                                    // Abaikan jika gagal translate
                                }
                            }),
                        TextInput::make('data_filter_category')
                            ->label('Data Filter Project')
                            ->placeholder('Contoh: web-app')
                            ->required()
                            ->unique(ignoreRecord: true) 
                            ->helperText('Isi untuk data filter content di halaman portofolio (Gunakan huruf kecil dan tanda hubung).'),
                        Hidden::make('name_category_en'),
                    ])->columns(2)->columnSpanFull(),
            ]);
    }
}