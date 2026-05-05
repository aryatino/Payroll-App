<?php

namespace App\Filament\Resources\Schedules\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->components([
                    Section::make()->components([
                      Select::make('user_id')
                        ->label('Nama Pegawai')
                        ->relationship('user', 'name')
                        ->preload()
                        ->searchable()
                        ->required(),
                    Select::make('shift_id')
                        ->relationship('shift', 'name')
                        ->required(),
                    Select::make('office_id')
                        ->relationship('office', 'name')
                        ->required(),
                    Toggle::make('iswfa')
                        ->label('WFA')
                        ->onIcon(Heroicon::Home)
                        ->offIcon(Heroicon::BuildingOffice2),
                    Toggle::make('is_banned')
                        ->label('Dibanned')
                        ->onIcon(Heroicon::ExclamationTriangle)
                        ->offIcon(Heroicon::CheckBadge),
                    ])
                ]),

             
            ]);
    }
}
