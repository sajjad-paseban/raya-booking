<?php

namespace App\Http\Controllers;

use App\Http\Logic\BookingLogic;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BookingLogic::index()->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'room_number' => 'required|integer',
            'count' => 'required|integer',
        ]);

        if($validation->fails()) 
            return BookingLogic::data($validation->errors())
                ->status(403)
                ->message('Validation failed. Please check your input and try again.')
                ->response();



        return BookingLogic::store()->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
