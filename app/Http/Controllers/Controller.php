<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function counterPagination($value, $current, $link)
    {
        $from = $current > 4 ? $current - 3 : 1;
        $next = $current > 4 ? $current + 1 : 5;

        // validation dimention 2
        $from = $current == $value ? $from - 1 : $from;
        $next = $current == $value ? $next - 1 : $next;

        // Validasi jika semua 0 data
        if ($from == 0) {
            $from = 1;
        }

        $data = [];
        for ($i = $from; $i <= $next; $i++) {
            $data[] = (object)[
                'lable' => $i,
                'is_active' => $i == $current ? true : false,
                'link' => route($link, ["page[number]" => $i]),
            ];
        }

        return $data;
    }

    public function prevPagination($current, $link)
    {
        $page = $current > 1 ? $current - 1 : 1;
        $data['link'] = route($link, ["page[number]" => $page]);
        return (object) $data;
    }

    public function nextPagination($current, $lasPage, $link)
    {
        $page = $current < $lasPage ? $current + 1 : $lasPage;
        $data['link'] = route($link, ["page[number]" => $page]);
        return (object) $data;
    }
}
