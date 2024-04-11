<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Models\DtKendaraanModel;
use App\Models\QrCodeModel;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public $keyQrCode = 5;

    public function index()
    {
        $qrCode = QrCodeModel::where('key', $this->keyQrCode)->where('is_use', 0)->get();

        $data['qrcode'] = $qrCode;
        $data['kendaraan'] = DtKendaraanModel::all();
        $data['no'] = 1;

        return view('data.kendaraan.index', $data);
    }
}
