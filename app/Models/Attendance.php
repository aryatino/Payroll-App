<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
     protected $guarded = ['id'];
     protected $with = ['user'];

     public function user(): BelongsTo
     {
         return $this->belongsTo(User::class);
     }

     public function isLate()
     {
         $scheduleStartTime = Carbon::parse($this->schedule_start_time);
         $startTime = Carbon::parse($this->start_time);

         return $startTime->greaterThan($scheduleStartTime);
     }

     public function workDuration() 
     {
        $startTime = Carbon::parse($this->start_time);
        $endTime = Carbon::parse($this->end_time);

        $duration = $startTime->diff($endTime);

        $hours =  $duration->h;
        $minutes = $duration->i;
        
        return $hours . ' jam ' . $minutes . ' menit ';
     }
}
