<?php

namespace App\Http\Controllers\Api\Pengguna;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function show(Request $request)
    {
        try {
            $role = [];
            if (isset($request->role)) {
                $role = json_decode($request->role);
            }

            $response = User::whereIn('role', $role)->orderBy('created_at', 'desc')->get();

            if ($response) {
                return response()->json([
                    'status' => 'Success',
                    'data' => $response,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'data' => [],
                ], 300);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Server Error',
                'data' => [],
            ], 500);
        }
    }

    /**
     * Hapus Pengguna
     */
    public function delete(Request $request)
    {
        try {
            $user_id = $request->user_id;
            
            // Validasi user_id
            if (empty($user_id)) {
                return response()->json([
                    'status' => 'Validation Error',
                    'message' => 'ID pengguna harus diisi',
                    'data' => [],
                ], 422);
            }

            // Cegah admin menghapus dirinya sendiri
            $authUser = auth()->user();
            if ($authUser && $authUser->id == $user_id) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Anda tidak dapat menghapus akun Anda sendiri',
                    'data' => [],
                ], 403);
            }

            $user = User::find($user_id);

            if (empty($user)) {
                return response()->json([
                    'status' => 'Not Found',
                    'message' => 'Pengguna tidak ditemukan',
                    'data' => [],
                ], 404);
            }

            $user->delete();

            return response()->json([
                'status' => 'Success',
                'message' => 'Pengguna berhasil dihapus',
                'data' => [],
            ], 200);
        } catch (\Exception $th) {
            \Log::error('User Delete Error: ' . $th->getMessage());
            
            return response()->json([
                'status' => 'Server Error',
                'message' => 'Terjadi kesalahan: ' . $th->getMessage(),
                'data' => [],
            ], 500);
        }
    }
}
