<?php

namespace App\Console\Commands;

use App\Mail\ReservationReminder;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReservationReminders extends Command
{
    protected $signature = 'reservations:send-reminders';
    protected $description = 'Send reminder emails to users one day before their check-in date';

    public function handle()
    {
        $this->info('Starting to send reservation reminders...');

        // Get reservations where check-in is tomorrow and status is confirmed
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');

        $reservations = Reservation::with(['user', 'hotel', 'room.roomType', 'payments'])
            ->where('check_in_date', $tomorrow)
            ->where('status', 'confirmed')
            ->get();

        if ($reservations->isEmpty()) {
            $this->info('No reservations found for tomorrow.');
            return 0;
        }

        $count = 0;

        foreach ($reservations as $reservation) {
            try {
                // Send email to user
                Mail::to($reservation->user->email)->send(new ReservationReminder($reservation));
                
                $this->info("✓ Reminder sent to {$reservation->user->name} ({$reservation->user->email})");
                $count++;
            } catch (\Exception $e) {
                $this->error("✗ Failed to send reminder to {$reservation->user->name}: {$e->getMessage()}");
            }
        }

        $this->info("Completed! Sent {$count} reminder(s).");
        return 0;
    }
}