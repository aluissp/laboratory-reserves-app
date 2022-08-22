<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLabRequest;
use App\Models\Lab;
use App\Models\User;
use Illuminate\Http\Request;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labs = Lab::paginate(6);
        return view('labs.index', compact('labs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staffs = User::get();
        return view('labs.create', compact('staffs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLabRequest $request)
    {
        $data = $request->validated();
        $lab = Lab::create($data);
        $staff = User::firstWhere('email', $request->staff);
        $staff->labs()->save($lab);

        return redirect()->route('labs.index')->with('alert', [
            'message' => "Laboratorio $lab->name creado correctamente.",
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function show(Lab $lab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function edit(Lab $lab)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lab $lab)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lab $lab)
    {
        //
    }

    public function filter($filter)
    {
        if ($filter == 'all') {
            $data = Lab::get();
        } else {
            $data = Lab::where('name', 'like', "%$filter%")
                ->limit(6)
                ->get();
        }

        foreach ($data as $lab) {
            $lab->staffInCharge;
        }

        return response()->json([
            'response' => $data,
            'message' => 'Datos obtenidos correctamente.'
        ], 200);
    }
}
