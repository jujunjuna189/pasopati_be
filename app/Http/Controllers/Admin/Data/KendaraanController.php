<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Models\DtKendaraanModel;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $data['kendaraan'] = DtKendaraanModel::all();
        $data['no'] = 1;

        return view('data.kendaraan.index', $data);
    }
}
