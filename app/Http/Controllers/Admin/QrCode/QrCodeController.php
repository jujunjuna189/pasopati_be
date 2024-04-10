<?php

namespace App\Http\Controllers\Admin\QrCode;

use App\Http\Controllers\Controller;
use App\Models\QrCodeModel;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    //Code ket
    // 01-01 Izin Keluar
    // 01-02 Izin Masuk
    // 02-01-(A/B/C) Kembalikan Senjata
    // 02-02-(A/B/C) Ambil Senjata

    public $keys = [];

    public function __construct()
    {
        $this->keys = [
            (object)[
                'key' => 1,
                'label' => 'Perizinan',
            ],
            (object)[
                'key' => 4,
                'label' => 'Ranpur',
            ],
            (object)[
                'key' => 5,
                'label' => 'Angkutan',
            ],
        ];
    }

    public function index(Request $request)
    {
        $data['keys'] = $this->keys;
        $data['current_key'] = $this->keys[array_search($request->key, array_column($this->keys, 'key'))];
        $data['qrcode'] = QrCodeModel::where('key', $request->key)->orderBy('key', 'asc')->get();
        $data['no'] = 1;

        return view('generate_qrcode.qrcode', $data);
    }

    /* Generate code
    * @param code string
    */
    public function generate(Request $request)
    {
        $where['code'] = $request->code;
        $data['qrcode'] = QrCodeModel::where($where)->first();
        return view('generate_qrcode.generate', $data);
    }
}
