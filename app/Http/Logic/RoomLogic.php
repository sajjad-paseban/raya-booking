<?php

namespace App\Http\Logic;

use App\Models\Room;
use Illuminate\Support\Facades\DB;

class RoomLogic extends Logic{
    public static function index(){
        $dtl = Room::with(['booking' => function($q){
            $q->where('is_active', '1');
        }])
        ->withSum(['booking as booking_sum_count' => function($q){
            $q->where('is_active', 1);
        }], 'count')
        ->get()
        ->map(function($m){
            if(is_null($m->booking_sum_count)) $m->booking_sum_count = 0;
            $m->booking_sum_count = intval($m->booking_sum_count);

            $m->available_capacity = $m->capacity - $m->booking_sum_count;
            return $m;
        });
        
        return parent::data($dtl)
            ->message('Data sent successfully.');
    }
}