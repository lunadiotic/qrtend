<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        // hash password
        $request->merge(['password' => bcrypt($request->get('password'))]);

        $request['role'] = 'employee';

        User::create($request->all());
        
        notify()->flash('Done!', 'success', [
            'timer' => 1500,
            'text' => 'Created Successfully',
        ]);
        
        return redirect()->route('admin.employee.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pages.employee.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.employee.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
        ]);

        $user = User::findOrFail($id);
        
        if ($request->has('password')) {
            $request->merge(['password' => bcrypt($request->get('password'))]);
        } else {
            $request['password'] = $user->password;
        }
        
        $user->update($request->all());
        
        notify()->flash('Done!', 'success', [
            'timer' => 1500,
            'text' => 'Updated Successfully',
        ]);
        
        return redirect()->route('admin.employee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!User::destroy($id)) return redirect()->back();
        notify()->flash('Done!', 'success', [
            'timer' => 1500,
            'text' => 'Deleted Successfully',
        ]);
        return redirect()->route('admin.employee.index');
    }

        public function dataTable()
        {
            $user = User::where('role', 'employee');
            return Datatables::of($user)
                ->addColumn('action', function ($user) {
                    return view('layouts.partials._action', [
                        'model' => $user,
                        'edit_url' => route('admin.employee.edit', $user->id),
                        'show_url' => route('admin.employee.show', $user->id),
                        'form_url' => route('admin.employee.destroy', $user->id),
                    ]);
                })
                ->make(true);
        }
}
