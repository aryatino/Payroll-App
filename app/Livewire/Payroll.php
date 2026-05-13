<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Payroll extends Component
{
    public $start_date;
    public $end_date;
    public $user_id;

    public $pegawai;
    public $total_duration = "00:00:00";

    public function render()
    {
        $users = User::all();
        return view('livewire.payroll', compact('users'))->layout('layouts.main');
    }

    public function calculate()
    {
        $this->validate([
            'user_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $this->pegawai = User::find($this->user_id);

        $start = Carbon::parse($this->start_date)->startOfDay();
        $end = Carbon::parse($this->end_date)->endOfDay();

        //Total Detik
        $attendances = Attendance::where('user_id', $this->user_id)
        ->whereBetween('created_at', [$start, $end])
        ->whereNotNull('duration')
        ->get();  

        $totalSeconds = $attendances->sum(function ($attendance) {
            return strtotime($attendance->duration) - strtotime('00:00:00');
        });

        //Konversi ke jam, menit, dan detik
        $hours = floor($totalSeconds / 3600);
        $minutes = floor($totalSeconds % 3600) / 60;
        $seconds = $totalSeconds % 60;

        $this->total_duration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    public function getFormattedDurationProperty()
    {
        if (!$this->total_duration) {
            return null;
        }

        [$jam, $menit, $detik] = explode(':', $this->total_duration);

        return $jam . ' Jam ' . $menit . ' Menit ' . $detik . ' Detik';
    }
}
