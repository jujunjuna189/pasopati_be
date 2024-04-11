<?php

namespace App\Http\Controllers\Admin\Saran;

use App\Http\Controllers\Controller;
use App\Models\AbsensiModel;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class SaranController extends Controller
{
    public function index(Request $request)
    {
        $data['saran'] = QueryBuilder::for(AbsensiModel::class)->orderBy('id', 'desc')
            ->jsonPaginate(10)->appends($request->input());
        $data['no'] = 1;

        return view('saran.index', $data);
    }
}
