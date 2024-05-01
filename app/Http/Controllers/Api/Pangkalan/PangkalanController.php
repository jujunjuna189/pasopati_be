<?php

namespace App\Http\Controllers\Api\Pangkalan;

use App\Http\Controllers\Controller;
use App\Models\GlobalModel;
use App\Models\PangkalanModel;
use Exception;
use Illuminate\Http\Request;

class PangkalanController extends Controller
{
    public function show()
    {
        try {
            $response = PangkalanModel::orderBy('created_at', 'desc')->get();

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
            $path = GlobalModel::upload_image($request, 'pangkalan');

            // $data['judul'] = $request->judul;
            $data['deskripsi'] = $request->deskripsi;
            $data['path'] = $path;

            $pangkalan = PangkalanModel::create($data);

            if ($pangkalan) {
                return response()->json([
                    'status' => 'Success',
                    'data' => [$pangkalan],
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
