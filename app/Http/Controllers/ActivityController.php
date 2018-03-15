<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;
use Auth;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.activity.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.activity.create');
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
            'log' => 'required|string|min:5',
            'date' => 'required',
            'user_id' => 'required'
        ]);

        if (Activity::where('date', $request->get('date'))->where('user_id', Auth::id())->first()) {
            notify()->flash('Done!', 'error', [
                'timer' => 1500,
                'text' => 'log on that date already exists.',
            ]);
            return redirect()->back()->withInput($request->input());
        }

        Activity::create($request->all());
        
        notify()->flash('Done!', 'success', [
            'timer' => 1500,
            'text' => 'Created Successfully',
        ]);
        
        return redirect()->route('admin.activity.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        return view('pages.activity.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        return view('pages.activity.edit', compact('activity'));
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
            'log' => 'required|string|min:5',
            'date' => 'required',
            'user_id' => 'required'
        ]);

        if (Activity::where('user_id', '=', Auth::id())->where('date', $request->get('date'))->where('id', '!=', $id)->first()) {
            notify()->flash('Done!', 'error', [
                'timer' => 1500,
                'text' => 'log on that date already exists.',
            ]);
            return redirect()->back()->withInput($request->input());
        }

        $activity = Activity::findOrFail($id);
        $activity->update($request->all());
        
        notify()->flash('Done!', 'success', [
            'timer' => 1500,
            'text' => 'Updated Successfully',
        ]);
        
        return redirect()->route('admin.activity.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Activity::destroy($id)) return redirect()->back();
        notify()->flash('Done!', 'success', [
            'timer' => 1500,
            'text' => 'Deleted Successfully',
        ]);
        return redirect()->route('admin.activity.index');
    }

    public function dataTable()
    {
        
        if (Auth::user()->role == 'admin') {
            $activity = Activity::query();
        } else {
            $activity = Activity::where('user_id', Auth::id());
        }
        return Datatables::of($activity)
            ->addColumn('user', function ($activity) {
                return $activity->user->name;
            })
            ->addColumn('action', function ($activity) {
                return view('layouts.partials._action', [
                    'model' => $activity,
                    'edit_url' => route('admin.activity.edit', $activity->id),
                    'show_url' => route('admin.activity.show', $activity->id),
                    'form_url' => route('admin.activity.destroy', $activity->id),
                ]);
            })
            ->make(true);
    }
}
