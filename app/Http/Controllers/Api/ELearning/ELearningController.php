<?php

namespace App\Http\Controllers\Api\ELearning;

use App\Http\Controllers\Controller;
use App\Models\ELearningModel;
use Exception;
use Illuminate\Http\Request;

class ELearningController extends Controller
{

    public function show()
    {
        try {
            $response = ELearningModel::orderBy('created_at', 'desc')->get();

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

    public function store(Request $request)
    {
        try {
            $data['judul'] = $request->judul;
            $data['deskripsi'] = $request->deskripsi;
            $data['path'] = $request->path;

            $e_learning = ELearningModel::create($data);

            if ($e_learning) {
                return response()->json([
                    'status' => 'Success',
                    'data' => [$e_learning],
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

    public function delete(Request $request)
    {
        try {
            $e_learning = ELearningModel::find($request->id);

            if (!$e_learning) {
                return response()->json([
                    'status' => 'Failed',
                    'data' => [],
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $e_learning->delete();

            return response()->json([
                'status' => 'Success',
                'data' => [],
                'message' => 'Berhasil menghapus data'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'Server Error',
                'data' => [],
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
