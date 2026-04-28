<?php

namespace App\Filament\Resources\Schedules\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Nama Pegawai')
                    ->options(User::query()->pluck('name', 'id'))
                    ->searchable(),
                Select::make('shift_id')
                    ->relationship('shift', 'name')
                    ->required(),
                Select::make('office_id')
                    ->relationship('office', 'name')
                    ->required(),
            ]);
    }
}
