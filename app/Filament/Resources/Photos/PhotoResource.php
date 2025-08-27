<?php

namespace App\Filament\Resources\Photos;

use App\Filament\Resources\Photos\Pages\CreatePhoto;
use App\Filament\Resources\Photos\Pages\EditPhoto;
use App\Filament\Resources\Photos\Pages\ListPhotos;
use App\Filament\Resources\Photos\Pages\ViewPhoto;
use App\Filament\Resources\Photos\Schemas\PhotoForm;
use App\Filament\Resources\Photos\Schemas\PhotoInfolist;
use App\Filament\Resources\Photos\Tables\PhotosTable;
use App\Models\Photo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

// Débugger par DIEU 

use Filament\Actions\Action;
use Filament\Actions\EditAction;

class PhotoResource extends Resource
{
    protected static ?string $model = Photo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Photo';

    public static function form(Schema $schema): Schema
    {
        return PhotoForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PhotoInfolist::configure($schema);
    }


//   Commander un produit

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Titre'),
                TextColumn::make('prix')->label('Prix'),
                ImageColumn::make('image_path')->label('Image'),
            ])
            ->actions([
                EditAction::make(),
               
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPhotos::route('/'),
            'create' => CreatePhoto::route('/create'),
            'view' => ViewPhoto::route('/{record}'),
            'edit' => EditPhoto::route('/{record}/edit'),
        ];
    }
}



