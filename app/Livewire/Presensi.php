<?php

namespace App\Livewire;

use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Presensi extends Component
{
    public $latitude;
    public $longitude;
    public $insideRadius = false;
    

    public function render()
    {
        $schedule = Schedule::where('user_id', Auth::user()->id)->first();
        $insideRadius = $this->insideRadius;

        return view('livewire.presensi', compact('schedule', 'insideRadius'))->layout('layouts.main');
    }
}
