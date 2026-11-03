<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLayoutRequest;
use App\Http\Requests\UpdateLayoutRequest;
use App\Models\Layout;
use Illuminate\Http\JsonResponse;

class LayoutController extends Controller
{
    /**
     * Menampilkan semua layout.
     * Dapat diakses publik — frontend menggunakan ini untuk pilihan layout di editor.
     */
    public function index(): JsonResponse
    {
        $layouts = Layout::orderBy('name')->get();

        return response()->json([
            'data' => $layouts,
        ]);
    }

    /**
     * Melihat detail satu layout.
     */
    public function show(Layout $layout): JsonResponse
    {
        return response()->json([
            'data' => $layout,
        ]);
    }

    /**
     * Menambahkan layout baru — khusus admin.
     */
    public function store(StoreLayoutRequest $request): JsonResponse
    {
        $layout = Layout::create($request->validated());

        return response()->json([
            'message' => 'Layout berhasil dibuat.',
            'data'    => $layout,
        ], 201);
    }

    /**
     * Mengubah data layout — khusus admin.
     */
    public function update(UpdateLayoutRequest $request, Layout $layout): JsonResponse
    {
        $layout->update($request->validated());

        return response()->json([
            'message' => 'Layout berhasil diperbarui.',
            'data'    => $layout->fresh(),
        ]);
    }

    /**
     * Menghapus layout — khusus admin.
     */
    public function destroy(Layout $layout): JsonResponse
    {
        $layout->delete();

        return response()->json([
            'message' => 'Layout berhasil dihapus.',
        ]);
    }
}
