<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_fails_if_count_is_zero_or_less()
    {
        $response = $this->postJson('/api/booking', [
            'room_number' => '101',
            'count' => 0
        ]);

        $response->assertStatus(422)
                 ->assertJson(['message' => 'Count must be greater than zero.']);
    }

    /** @test */
    public function it_fails_if_room_does_not_exist()
    {
        $response = $this->postJson('/api/booking', [
            'room_number' => '999', // اتاق فرضی
            'count' => 1
        ]);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'The room number you entered doesn’t exist.']);
    }

    /** @test */
    public function it_fails_if_room_capacity_is_full()
    {
        $room = Room::factory()->create(['name' => 'test', 'room_number' => '101', 'capacity' => 2]);
        Booking::factory()->create([
            'room_id' => $room->id,
            'count' => 2,
            'is_active' => 1
        ]);

        $response = $this->postJson('/api/booking', [
            'room_number' => '101',
            'count' => 1
        ]);

        $response->assertStatus(409)
                 ->assertJson(['message' => 'No capacity available for this room.']);
    }

    /** @test */
    public function it_fails_if_requested_count_exceeds_remaining_capacity()
    {
        $room = Room::factory()->create(['name' => 'test', 'room_number' => '101', 'capacity' => 5]);
        Booking::factory()->create([
            'room_id' => $room->id,
            'count' => 3,
            'is_active' => 1
        ]);

        $response = $this->postJson('/api/booking', [
            'room_number' => '101',
            'count' => 3
        ]);

        $response->assertStatus(409)
                 ->assertJson(['message' => 'No full capacity available. Only 2 left.']);
    }
}
