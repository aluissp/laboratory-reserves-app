<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $majors = Major::paginate(6);
        // dd($majors);
        return view('users.major', compact('majors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:majors'
        ], [], [
            'name' => 'nombre'
        ]);

        $major = Major::create([
            'name' => $data['name'],
        ]);

        return redirect()->route('majors.index')->with('alert', [
            'message' => "Carrera $major->name creado correctamente.",
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function show(Major $major)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function edit(Major $major)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Major $major)
    {
        $data = $request->validate([
            'name-update' => 'required|string|max:255|unique:majors,name'
        ], [], [
            'name-update' => 'nombre'
        ]);

        $major->update(['name' => $data['name-update']]);

        return redirect()->route('majors.index')->with('alert', [
            'message' => "Carrera $major->name actualizado correctamente.",
            'type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function destroy(Major $major)
    {
        $major->delete();

        return redirect()->route('majors.index')->with('alert', [
            'message' => "Carrera $major->name eliminada correctamente.",
            'type' => 'success'
        ]);
    }

    public function filter($filter)
    {
        if ($filter == 'all') {
            $data = DB::table('majors')->limit(6)->get();
        } else {
            $data = Major::where('name', 'like', "%$filter%")->limit(5)->get();
        }

        return response()->json([
            'response' => $data,
            'message' => 'Datos obtenidos correctamente.'
        ], 200);
    }
}
