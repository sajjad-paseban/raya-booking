<?php

namespace App\Jobs;

use App\Http\Logic\BookingLogic;

class CheckExpiredBookingsSchedule
{
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        BookingLogic::__expired_bookings();
    }
}
