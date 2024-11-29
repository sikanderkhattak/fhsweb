<?php

namespace App\Http\Controllers;

use App\Models\Managingpartners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagingpartnersController extends Controller
{
    public function index()
    {
        $managingpartners = Managingpartners::all();
        return view('admin.managingpartners.index', compact('managingpartners'));
    }
    
    public function create()
    {
        return view('admin.managingpartners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:30',
            'description' => 'required|string|max:1000',
            'heading' => 'required|string|max:20',
            'image' => 'nullable|image|mimes:jpg,png,svg|max:2048',
        ]);

        $partner = new Managingpartners;

        $partner->name = $request->name;
        $partner->description = $request->description;
        $partner->heading = $request->heading;

        if ($request->hasFile('image')) {
            $partner->image = $request->file('image')->store('managingpartners', 'public');
        }

        $partner->save();

        return redirect()->route('managingpartners.index')->with('success', 'Managing Partner created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partner = Managingpartners::findOrFail($id);
        return view('admin.managingpartners.create', compact('partner'));
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
        $request->validate([
            'name' => 'required|string|max:30',
            'description' => 'required|string|max:1000',
            'heading' => 'required|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $partner = Managingpartners::findOrFail($id);

        $partner->name = $request->name;
        $partner->description = $request->description;
        $partner->heading = $request->heading;

        if ($request->hasFile('image')) {
            if ($partner->image) {
                Storage::delete('public/' . $partner->image);
            }

            $partner->image = $request->file('image')->store('managingpartners', 'public');
        }

        $partner->save();

        return redirect()->route('managingpartners.index')->with('success', 'Managing Partner updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ManagingPartner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(ManagingPartner $partner)
    {
        if ($partner->image) {
            Storage::delete('public/' . $partner->image);
        }

        $partner->delete();

        return redirect()->route('managingpartners.index')->with('success', 'Managing Partner deleted successfully!');
    }
}
