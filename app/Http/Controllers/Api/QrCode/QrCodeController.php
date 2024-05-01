<?php

namespace App\Http\Controllers\Api\QrCode;

use App\Http\Controllers\Controller;
use App\Models\QrCodeModel;
use Exception;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data['title'] = $request->title;
            $data['key'] = $request->key;
            $data['code'] = $request->code;

            $qrCode = QrCodeModel::where('code', $request->code)->first();
            if (isset($qrCode)) {
                return response()->json([
                    'status' => 'Kode sudah tersedia',
                    'data' => [],
                ], 300);
            }

            $qrCode = QrCodeModel::create($data);

            if ($qrCode) {
                return response()->json([
                    'status' => 'Success',
                    'data' => [$qrCode],
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
            $qrCode = QrCodeModel::find($request->id);
            $qrCode->delete();

            if ($qrCode) {
                return response()->json([
                    'status' => 'Success',
                    'data' => [$qrCode],
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
