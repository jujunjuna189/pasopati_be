<?php

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Models\DtRanpurModel;
use Illuminate\Http\Request;

class RanpurController extends Controller
{
    public function index()
    {
        $data['ranpur'] = DtRanpurModel::all();
        $data['no'] = 1;

        return view('data.ranpur.index', $data);
    }
}
