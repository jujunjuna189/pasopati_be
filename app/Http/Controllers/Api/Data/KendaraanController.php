<?php

namespace App\Http\Controllers\Api\Data;

use App\Http\Controllers\Controller;
use App\Models\DtKendaraanModel;
use App\Models\QrCodeModel;
use Exception;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{

    public $keyQrCode = 5;

    public function store(Request $request)
    {
        try {
            $qrCode = QrCodeModel::where('key', $this->keyQrCode)->where('is_use', 0)->first();
            if (!isset($qrCode)) {
                return response()->json([
                    'status' => 'Qr Code Tidak tersedia, silahkan tambah qr code',
                    'data' => [],
                ], 404);
            }

            $qrCode->is_use = 1;
            $qrCode->save();

            $data['code'] = $qrCode->code;
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
