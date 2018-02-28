<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttendController extends Controller
{
    public function postScan(Request $request)
    {
        $data = [
            'data' => $request->data,
            'response' => true
        ];

        return $data;
    }
}
