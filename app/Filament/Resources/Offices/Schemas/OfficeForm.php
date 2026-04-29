<?php

namespace App\Filament\Resources\Offices\Schemas;

use Dotswan\MapPicker\Fields\Map;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OfficeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                    Map::make('location')
                    ->label('Location')
                    ->defaultLocation(latitude: -6.200000, longitude: 106.816666) // Jakarta
                    ->zoom(17)
                    ->showMarker(true)
                    ->draggable(true)
                    ->clickable(true)
                    ->tilesUrl('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}')
                    ->afterStateHydrated(function ($state, callable $set, $record) {
                        if ($record && $record->latitude && $record->longitude) {
                            $set('location', [
                                'lat' => $record->latitude,
                                'lng' => $record->longitude,
                            ]);
                        }
                    })
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('latitude', $state['lat']);
                        $set('longitude', $state['lng']);
                    })
                    ->live()
                    ->reactive(),

                TextInput::make('latitude')
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        if ($get('longitude')) {
                            $set('location', [
                                'lat' => (float) $state,
                                'lng' => (float) $get('longitude'),
                            ]);
                        }
                    }),
                TextInput::make('longitude')
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        if ($get('latitude')) {
                            $set('location', [
                                'lat' => (float) $get('latitude'),
                                'lng' => (float) $state,
                            ]);
                        }
                    }),
                TextInput::make('radius')
                    ->required()
                    ->numeric(),
            ]);
    }
}
