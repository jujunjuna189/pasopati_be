<?php

namespace App\Http\Controllers\Api\Artikel;

use App\Http\Controllers\Controller;
use App\Models\ArtikelModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    /**
     * Validasi input artikel
     */
    private function validation($request)
    {
        // Rules
        $rules['judul'] = 'required';
        $rules['deskripsi'] = 'required';
        $rules['artikel'] = 'required';
        // Message
        $message['required'] = 'Harus diisi';

        $validate = Validator::make($request->all(), $rules, $message);
        return $validate;
    }

    public function show(Request $request)
    {
        try {
            $response = ArtikelModel::orderBy('created_at', 'desc')->get();

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
     * Simpan atau Update Artikel
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $validate = $this->validation($request);
            if ($validate->fails()) {
                return response()->json([
                    'status' => 'Validation Error',
                    'message' => $validate->errors()->first(),
                    'data' => [],
                ], 422);
            }

            $artikel_id = $request->artikel_id;
            
            // Data yang akan disimpan
            $data['judul'] = $request->judul;
            $data['deskripsi'] = $request->deskripsi;
            $data['artikel'] = $request->artikel;

            // Jika artikel_id ada, update. Jika tidak, buat baru
            $artikel = null;
            if (!empty($artikel_id) && $artikel_id != 'null' && $artikel_id != '') {
                $artikel = ArtikelModel::find($artikel_id);
            }
            
            if (empty($artikel)) {
                // Buat artikel baru
                $response = ArtikelModel::create($data);
                $statusMsg = 'Artikel berhasil disimpan';
            } else {
                // Update artikel yang sudah ada
                $artikel->update($data);
                $response = $artikel->fresh(); // Get fresh data from database
                $statusMsg = 'Artikel berhasil diperbarui';
            }

            if ($response) {
                return response()->json([
                    'status' => 'Success',
                    'message' => $statusMsg,
                    'data' => $response,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Gagal menyimpan artikel',
                    'data' => [],
                ], 400);
            }
        } catch (\Exception $th) {
            \Log::error('Artikel Store Error: ' . $th->getMessage());
            
            return response()->json([
                'status' => 'Server Error',
                'message' => 'Terjadi kesalahan: ' . $th->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    /**
     * Hapus Artikel
     */
    public function delete(Request $request)
    {
        try {
            $artikel_id = $request->artikel_id;
            
            // Validasi artikel_id
            if (empty($artikel_id)) {
                return response()->json([
                    'status' => 'Validation Error',
                    'message' => 'ID artikel harus diisi',
                    'data' => [],
                ], 422);
            }
            
            $artikel = ArtikelModel::find($artikel_id);

            if (empty($artikel)) {
                return response()->json([
                    'status' => 'Not Found',
                    'message' => 'Artikel tidak ditemukan',
                    'data' => [],
                ], 404);
            }

            $artikel->delete();

            return response()->json([
                'status' => 'Success',
                'message' => 'Artikel berhasil dihapus',
                'data' => [],
            ], 200);
        } catch (\Exception $th) {
            \Log::error('Artikel Delete Error: ' . $th->getMessage());
            
            return response()->json([
                'status' => 'Server Error',
                'message' => 'Terjadi kesalahan: ' . $th->getMessage(),
                'data' => [],
            ], 500);
        }
    }
}
