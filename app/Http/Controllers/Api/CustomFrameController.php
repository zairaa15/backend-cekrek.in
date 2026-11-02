<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomFrameRequest;
use App\Http\Requests\UpdateCustomFrameRequest;
use App\Models\CustomFrame;
use Illuminate\Http\JsonResponse;

class CustomFrameController extends Controller
{
    /**
     * Menampilkan semua custom frame milik pengguna yang sedang login.
     */
    public function index(): JsonResponse
    {
        $customFrames = CustomFrame::where('user_id', auth()->id())
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json([
            'data' => $customFrames,
        ]);
    }

    /**
     * Melihat detail custom frame.
     * Hanya pemilik yang dapat mengaksesnya.
     */
    public function show(CustomFrame $customFrame): JsonResponse
    {
        $this->authorizeOwnership($customFrame);

        return response()->json([
            'data' => $customFrame,
        ]);
    }

    /**
     * Membuat custom frame baru untuk pengguna yang sedang login.
     */
    public function store(StoreCustomFrameRequest $request): JsonResponse
    {
        $customFrame = CustomFrame::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Custom frame berhasil dibuat.',
            'data'    => $customFrame,
        ], 201);
    }

    /**
     * Mengubah custom frame.
     * Hanya pemilik yang dapat mengubahnya.
     */
    public function update(UpdateCustomFrameRequest $request, CustomFrame $customFrame): JsonResponse
    {
        $this->authorizeOwnership($customFrame);

        $customFrame->update($request->validated());

        return response()->json([
            'message' => 'Custom frame berhasil diperbarui.',
            'data'    => $customFrame->fresh(),
        ]);
    }

    /**
     * Menghapus custom frame.
     * Hanya pemilik yang dapat menghapusnya.
     */
    public function destroy(CustomFrame $customFrame): JsonResponse
    {
        $this->authorizeOwnership($customFrame);

        $customFrame->delete();

        return response()->json([
            'message' => 'Custom frame berhasil dihapus.',
        ]);
    }

    /**
     * Memeriksa kepemilikan custom frame.
     * Mengembalikan 403 jika bukan milik pengguna yang sedang login.
     */
    private function authorizeOwnership(CustomFrame $customFrame): void
    {
        if ($customFrame->user_id !== auth()->id()) {
            abort(403, 'Kamu tidak memiliki akses ke custom frame ini.');
        }
    }
}
