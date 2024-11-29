<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Schedule;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index() {
       
        $schedules = Schedule::all();
        return view('schedules.index', compact('schedules'));
    }
    
    public function create() {
        return view('schedules.create');
    }
     
    public function store(Request $request) {
       $data= Schedule::create($request->all());
        // dd($data);
        return redirect()->route('schedules.index')->with('success', 'Schedule added successfully');
    }
    
    public function edit($id) {
        $schedule = Schedule::findOrFail($id);
        return view('schedules.edit', compact('schedule'));
    }
    
    public function update(Request $request, $id) {
        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());
        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully');
    }
    
    public function destroy($id) {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully');
    }
    
}
