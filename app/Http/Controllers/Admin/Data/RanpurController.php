<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Models\DtRanpurModel;
use App\Models\QrCodeModel;
use Illuminate\Http\Request;

class RanpurController extends Controller
{
    public $keyQrCode = 4;

    public function index()
    {
        $qrCode = QrCodeModel::where('key', $this->keyQrCode)->where('is_use', 0)->get();

        $data['qrcode'] = $qrCode;
        $data['ranpur'] = DtRanpurModel::all();
        $data['no'] = 1;

        return view('data.ranpur.index', $data);
    }
}
