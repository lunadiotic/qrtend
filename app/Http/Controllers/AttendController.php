<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use DB;

class AttendController extends Controller
{

    public function index()
    {
        return view('pages.attend.index-table');
    }

    public function create()
    {
        $employee = User::where('role', 'employee')->pluck('name', 'id');
        return view('pages.attend.create', compact('employee'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
            'user_id' => 'required',
            'created_at' => 'required'  
        ]);

        if (Attend::where('created_at', $request->get('created_at'))->where('user_id', $request->get('user_id'))->first()) {
            notify()->flash('Done!', 'error', [
                'timer' => 1500,
                'text' => 'Attendance on that date already exists.',
            ]);
            return redirect()->back()->withInput($request->input());
        }

        Attend::create($request->all());
        
        notify()->flash('Done!', 'success', [
            'timer' => 1500,
            'text' => 'Created Successfully',
        ]);
        
        return redirect()->route('admin.attend.index');
    }

    public function edit($id)
    {
        $attend = Attend::findOrFail($id);
        $employee = User::where('role', 'employee')->pluck('name', 'id');
        return view('pages.attend.edit', compact('employee', 'attend'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required',
            'user_id' => 'required',
            'created_at' => 'required'  
        ]);

        if (Attend::where('user_id', '=', $request->get('user_id'))->where('created_at', $request->get('created_at'))->where('id', '!=', $id)->first()) {
            notify()->flash('Done!', 'error', [
                'timer' => 1500,
                'text' => 'Attendance on that date already exists.',
            ]);
            return redirect()->back()->withInput($request->input());
        }

        $attend = Attend::findOrFail($id);
        $attend->update($request->all());
        
        notify()->flash('Done!', 'success', [
            'timer' => 1500,
            'text' => 'Updated Successfully',
        ]);
        
        return redirect()->route('admin.attend.index');
    }

    public function destroy($id)
    {
        if (!Attend::destroy($id)) return redirect()->back();
        notify()->flash('Done!', 'success', [
            'timer' => 1500,
            'text' => 'Deleted Successfully',
        ]);
        return redirect()->route('admin.attend.index');
    }

    public function dataTable()
    {
        
        $attend = Attend::where('status', 'absent')->orWhere('status', 'permit');
        return Datatables::of($attend)
            ->addColumn('user', function ($attend) {
                return $attend->user->name;
            })
            ->addColumn('status', function ($attend) {
                return $attend->status == 'absent' ? 'Tidak Hadir' : 'Izin';
            })
            ->addColumn('action', function ($attend) {
                return view('layouts.partials._action', [
                    'model' => $attend,
                    'edit_url' => route('admin.attend.edit', $attend->id),
                    'form_url' => route('admin.attend.destroy', $attend->id),
                ]);
            })
            ->make(true);
    }

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

        // $iplocal = ip2long(getHostByName(getHostName()));
        // $gateway = env('IP_ADDRESS');
        // $iplow = ip2long($gateway);
        // $iphigh = ip2long($gateway) + 253;

        // if ($iplocal <= $iphigh && $iplow <= $iplocal) {

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
        // }

        // return $response = [
        //     'data' => null,
        //     'response' => false,
        //     'message' => 'Out of range IP Address'
        // ];
    }
}
