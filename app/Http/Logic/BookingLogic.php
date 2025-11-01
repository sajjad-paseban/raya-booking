<?php

namespace App\Http\Logic;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingLogic extends Logic
{
    public static function index()
    {
        $dtl = Booking::with('room')
            ->where('is_active', '1')
            ->get();

        return parent::data($dtl)
            ->message('Data sent successfully.');
    }

    public static function store()
    {
        self::__expired_bookings();

        $request = request();

        if (!($request->count > 0)) {
            return parent::status(422)
                ->message('Count must be greater than zero.');
        }

        $room = Room::where('room_number', $request->room_number)->first();

        if (!$room) {
            return parent::status(404)
                ->message('The room number you entered doesn’t exist.');
        }

        try {
            $result = DB::transaction(function () use ($room, $request) {

                $lockedRoom = Room::where('id', $room->id)
                    ->lockForUpdate()
                    ->first();

                $activeCount = Booking::where('room_id', $lockedRoom->id)
                    ->where('is_active', 1)
                    ->sum('count');

                $remaining = $lockedRoom->capacity - $activeCount;

                if ($remaining <= 0) {
                    throw new \Exception('No capacity available for this room.');
                }

                if ($request->count > $remaining) {
                    throw new \Exception("No full capacity available. Only {$remaining} left.");
                }

                $booking = Booking::create([
                    'room_id' => $lockedRoom->id,
                    'count' => $request->count,
                    'is_active' => 1,
                    'expired_at' => now()->addMinutes(2)->toDateTimeString(),
                ]);

                return $booking;
            });

            return parent::data($result)
                ->message('Booking is done.');
        } catch (\Exception $e) {
            return parent::status(409)
                ->message($e->getMessage());
        }
    }

    public static function __expired_bookings()
    {
        Booking::where('is_active', '1')
            ->where('expired_at', '<', now())
            ->update(['is_active' => 0]);
    }
}
