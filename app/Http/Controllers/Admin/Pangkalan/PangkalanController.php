<?php

namespace App\Http\Controllers\Admin\Pangkalan;

use App\Http\Controllers\Controller;
use App\Models\PangkalanModel;
use Illuminate\Http\Request;

class PangkalanController extends Controller
{
    public function index()
    {
        $data['pangkalan'] = PangkalanModel::all();
        $data['no'] = 1;

        return view('pangkalan.index', $data);
    }
}
