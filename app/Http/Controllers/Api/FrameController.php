<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use Illuminate\Http\Request;

class FrameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Frame::with('event');

        // Filter frame berdasarkan event
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        // Menampilkan frame umum
        if ($request->boolean('general')) {
            $query->whereNull('event_id');
        }

        return response()->json([
            'message' => 'Daftar frame berhasil diambil',
            'data' => $query->latest()->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => 'nullable|integer|exists:events,id',
            'name' => 'required|string|max:255',
            'preview_image' => 'nullable|string|max:255',
            'frame_data' => 'required|array',
        ]);

        $frame = Frame::create($data);

        return response()->json([
            'message' => 'Frame berhasil ditambahkan',
            'data' => $frame
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $frame = Frame::with('event')->findOrFail($id);

        return response()->json([
            'message' => 'Detail frame berhasil diambil',
            'data' => $frame
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $frame = Frame::findOrFail($id);

        $data = $request->validate([
            'event_id' => 'sometimes|nullable|integer|exists:events,id',
            'name' => 'sometimes|required|string|max:255',
            'preview_image' => 'sometimes|nullable|string|max:255',
            'frame_data' => 'sometimes|required|array',
        ]);

        $frame->update($data);

        return response()->json([
            'message' => 'Frame berhasil diperbarui',
            'data' => $frame->fresh()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $frame = Frame::findOrFail($id);

        $frame->delete();

        return response()->json([
            'message' => 'Frame berhasil dihapus'
        ], 200);
    }
}
