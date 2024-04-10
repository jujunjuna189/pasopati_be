<?php

namespace App\Http\Controllers\Api\Data;

use App\Http\Controllers\Controller;
use App\Models\DtRanpurModel;
use Exception;
use Illuminate\Http\Request;

class RanpurController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data['code'] = random_int(3, 10);
            $data['jenis'] = $request->jenis;
            $data['nomor'] = $request->nomor;
            $data['deskripsi'] = $request->deskripsi;

            $kendaraan = DtRanpurModel::create($data);

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
