<?php

namespace App\Http\Controllers\Api\Data;

use App\Http\Controllers\Controller;
use App\Models\DtKendaraanModel;
use Exception;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data['code'] = random_int(3, 10);
            $data['jenis'] = $request->jenis;
            $data['nomor'] = $request->nomor;
            $data['deskripsi'] = $request->deskripsi;

            $kendaraan = DtKendaraanModel::create($data);

            if ($kendaraan) {
                return response()->json([
                    'status' => 'Success',
                    'data' => [$kendaraan],
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
}
