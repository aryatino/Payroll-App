<?php

namespace App\Http\Middleware;

use App\Models\Leave;
use Closure;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isLeave
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $hasLeave = Leave::where('user_id', $user->id)
                    ->where('start_date', '<=', $today)
                    ->where('end_date', '>=', $today)
                    ->whereIn('status', ['pending', 'approved'])
                    ->exists();

        if ($hasLeave) {   
            Notification::make()
            ->title('Akses Ditolak!!!')
            ->danger()
            ->body('Anda sedang cuti, akses ditolak.')
            ->send();

            return redirect('admin/attendances');
        }

        return $next($request);
    }
}
