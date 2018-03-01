<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class AttendController extends Controller
{
    public function postScan(Request $request)
    {
        /**
         * Jika sudah absen di bawah jam 12, tidak bisa submit lagi
         * Jika Di atas jam 12, pulang lebih awal,
         * Dan jika sudah ada 2 kali submit, tidak bisa submit lagi
         */

        /**
         * Jika jam pagi tidak ada dan melewati jam 17, dianggap absen,
         * Jika Jam pagi tidak ada dan jam siang ada, masuk setengah hari
         */

        $iplocal = ip2long(getHostByName(getHostName()));
        $gateway = env('IP_ADDRESS');
        $iplow = ip2long($gateway);
        $iphigh = ip2long($gateway) + 253;

        if ($iplocal <= $iphigh && $iplow <= $iplocal) {

            if (User::where('email', $request->email)->exists()) {
                $user = User::where('email', $request->email)->first();
                if (date('H') < 12) {
                    $data = [
                        'user_id' => $user->id,
                        'status' => 'in',
                    ];
    
                    if ( Attend::where('user_id', $user->id)->where('status', 'in')->whereDate('created_at', DB::raw('CURDATE()'))->first() ) {
                        return $data = [
                            'data' => null,
                            'response' => false,
                            'message' => $user->name . ' Has been check in'
                        ];
                    }
                    Attend::create($data);
                    return $response = [
                        'data' => $data,
                        'response' => true,
                        'message' => $user->name . ' Check in successful'
                    ];
                } else {
                    $data = [
                        'user_id' => $user->id,
                        'status' => 'out',
                    ];
    
                    if ( Attend::where('user_id', $user->id)->where('status', 'out')->whereDate('created_at', DB::raw('CURDATE()'))->first() ) {
                        return $data = [
                            'data' => null,
                            'response' => false,
                            'message' => $user->name . ' Has been check out'
                        ];
                    }
    
                    Attend::create($data);
                    return $response = [
                        'data' => $data,
                        'response' => true,
                        'message' => $user->name . ' Check out successful'
                    ];
                }
            }
    
            return $response = [
                'data' => null,
                'response' => false,
                'message' => 'Employee doesnt Exists'
            ];
        }

        return $response = [
            'data' => null,
            'response' => false,
            'message' => 'Out of range IP Address'
        ];
    }
}
