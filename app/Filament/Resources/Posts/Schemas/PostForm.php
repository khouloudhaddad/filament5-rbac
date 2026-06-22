<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextInput::make('user_id')
                //     ->required()
                //     ->numeric(),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->label('Published')
                    ->visible(fn() => Auth::user()->can('Publish:Post')),
            ]);
    }
}
