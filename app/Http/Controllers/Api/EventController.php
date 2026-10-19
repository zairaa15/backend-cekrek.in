<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->get();

        return response()->json([
            'message' => 'Daftar event berhasil diambil',
            'data' => $events
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner_image' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $event = Event::create($data);

        return response()->json([
            'message' => 'Event berhasil ditambahkan',
            'data' => $event
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);

        return response()->json([
            'message' => 'Detail event berhasil diambil',
            'data' => $event
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'banner_image' => 'sometimes|nullable|string|max:255',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date',
        ]);

        $event->fill($data);

        if (
            $event->start_date &&
            $event->end_date &&
            $event->end_date < $event->start_date
        ) {
            return response()->json([
                'message' => 'Tanggal akhir tidak boleh sebelum tanggal mulai'
            ], 422);
        }

        $event->save();

        return response()->json([
            'message' => 'Event berhasil diperbarui',
            'data' => $event
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        $event->delete();

        return response()->json([
            'message' => 'Event berhasil dihapus'
        ], 200);
    }
}
