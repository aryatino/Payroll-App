<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Payroll extends Component
{
    public $start_date;
    public $end_date;
    public $user_id;

    public $pegawai;
    public $total_duration;
    public $total_hour = 0;
    public $total_sallary = 0;
    public $rate_per_hour = 35000;
    public $leave_pay = 0;

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

        /*
        TOTAL DETIK ATTENDANCE
        */
        $attendances = Attendance::where('user_id', $this->user_id)
        ->whereBetween('created_at', [$start, $end])
        ->whereNotNull('duration')
        ->get();  

        $attendanceSeconds = $attendances->sum(function ($attendance) {
            return strtotime($attendance->duration) - strtotime('00:00:00');
        });

        /*
        =================================================
        TOTAL DETIK CUTI
        =================================================  
        */ 
        $schedule = Schedule::where('user_id', $this->user_id)->first();

        $scheduleStart = Carbon::parse($schedule->shift->start_time);
        $scheduleEnd = Carbon::parse($schedule->shift->end_time);

        $scheduleSeconds = $scheduleStart->diffInSeconds($scheduleEnd);

        $leaves = Leave::where('user_id', $this->user_id)
        ->whereBetween('created_at', [$start, $end])
        ->whereIn('status', ['pending', 'approved'])
        ->get();

        $totalLeaveDays =$leaves->count();

        //Hitung total detik cuti
        $leaveSeconds = $totalLeaveDays * $scheduleSeconds;

        //Total jam cuti
        $leaveHours = $leaveSeconds / 3600;

        //Total gaji cuti
        $this->leave_pay = $leaveHours * $this->rate_per_hour;

        /*================================================
        TOTAL GAJI BERSIH
        =================================================*/
        $totalSeconds = $attendanceSeconds + $leaveSeconds;



        //Konversi ke jam, menit, dan detik
        $hours = floor($totalSeconds / 3600);
        $minutes = floor($totalSeconds % 3600) / 60;
        $seconds = $totalSeconds % 60;

        $this->total_duration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        //Hitung jam dalam bentuk desimal
        $this->total_hour  = $totalSeconds / 3600;

        //Hitung total gaji
        $this->total_sallary = $this->total_hour * $this->rate_per_hour;
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


