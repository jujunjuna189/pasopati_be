<?php

namespace App\Http\Controllers\Api\Pejabat;

use App\Http\Controllers\Controller;
use App\Models\PejabatModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PejabatController extends Controller
{
    /**
     * Function validasi
     */
    private function validation($request, $rule)
    {
        $rule = [
            'store' => $rule['store'] ?? false,
            'update' => $rule['update'] ?? false,
            'delete' => $rule['delete'] ?? false,
        ];

        // Rules
        if ($rule['store'] || $rule['update']) {
            $rules['nama'] = 'required';
            $rules['nrp'] = 'required';
            $rules['satuan'] = 'required';
        }

        if ($rule['update'] || $rule['delete']) {
            $rules['id'] = 'required';
        }
        // Message
        $message['required'] = 'Harus diisi';

        $validate = Validator::make($request->all(), $rules, $message);
        return $validate;
    }

    public function show(Request $request)
    {
        try {
            $satuan = $request->satuan;

            if (empty($satuan)) {
                return response()->json([
                    'status' => 'Bad Request',
                    'message' => 'Satuan pejabat harus diisi',
                    'data' => [],
                ], 400);
            }

            $response = PejabatModel::where('satuan', $satuan)->orderBy('created_at', 'desc')->get();
            foreach ($response as $val) {
                $val['lates'] = !empty($val->created_at) && Carbon::parse($val->created_at)->addDays(2) > Carbon::now() ? 'Baru' : null;
            }

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
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Simpan Pejabat
     */
    public function store(Request $request)
    {
        try {
            $validate = $this->validation($request, ['store' => true]);
            if ($validate->fails()) {
                return response()->json(['status' => 'Bad Request', 'message' => $validate->errors()], 400);
            }

            // Data
            $data['nama'] = $request->nama;
            $data['pangkat'] = $request->pangkat;
            $data['nrp'] = $request->nrp;
            $data['jabatan'] = $request->jabatan;
            $data['satuan'] = $request->satuan;

            $response = PejabatModel::create($data);

            if ($response) {
                return response()->json([
                    'status' => 'Success',
                    'data' => [$response],
                ], 200);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'data' => [],
                ], 300);
            }
        } catch (\Exception $th) {
            return response()->json([
                'status' => 'Server Error',
                'data' => [],
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Update Pejabat
     */
    public function update(Request $request)
    {
        try {
            $validate = $this->validation($request, ['update' => true]);
            if ($validate->fails()) {
                return response()->json(['status' => 'Bad Request', 'message' => $validate->errors()], 400);
            }

            // Initialize
            $pejabat_id = $request->id;
            // Data
            $data['nama'] = $request->nama;
            $data['pangkat'] = $request->pangkat;
            $data['nrp'] = $request->nrp;
            $data['jabatan'] = $request->jabatan;

            $response = PejabatModel::find($pejabat_id);

            if (!empty($response)) {
                $response->update($data);
                return response()->json([
                    'status' => 'Success',
                    'data' => [$response],
                ], 200);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'data' => [],
                    'message' => 'Data tidak ditemukan',
                ], 300);
            }
        } catch (\Exception $th) {
            return response()->json([
                'status' => 'Server Error',
                'data' => [],
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete Pejabat
     */
    public function delete(Request $request)
    {
        try {
            $validate = $this->validation($request, ['delete' => true]);
            if ($validate->fails()) {
                return response()->json(['status' => 'Bad Request', 'message' => $validate->errors()], 400);
            }

            // Initialize
            $pejabat_id = $request->id;
            // Find data
            $response = PejabatModel::find($pejabat_id);

            if (!empty($response)) {
                $response->delete();
                return response()->json([
                    'status' => 'Success',
                    'data' => [$response],
                ], 200);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'data' => [],
                    'message' => 'Data tidak ditemukan',
                ], 300);
            }
        } catch (\Exception $th) {
            return response()->json([
                'status' => 'Server Error',
                'data' => [],
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
