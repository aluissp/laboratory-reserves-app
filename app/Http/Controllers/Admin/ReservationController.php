<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Lab;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reserves = Reservation::get();
        foreach ($reserves as $reserve) {
            $reserve->user;
            $reserve->lab;
        }
        return response()->json([
            'response' => $reserves,
            'message' => 'Datos obtenidos correctamente.'
        ], 200);
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
    public function store(StoreReservationRequest $request)
    {
        $data = $request->validated();
        $lab = Lab::firstWhere('id', $data['lab_id']);
        $reservation = auth()->user()->reservations()->create($data);
        $lab->reservations()->save($reservation);

        $reservation->user;
        $reservation->lab;
        return response()->json([
            'message' => "Reserva $reservation->name creada correctamente.",
            'data' => $reservation,
            'type' => 'success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        $reserve = $reservation;
        return view('reservations.show', compact('reserve'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(StoreReservationRequest $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);
        $data = $request->validated();
        $lab = Lab::firstWhere('id', $data['lab_id']);
        $reservation->update($data);
        $lab->reservations()->save($reservation);

        return response()->json([
            'message' => "Reserva $reservation->name actualizada correctamente.",
            'data' => $reservation,
            'type' => 'success'
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);
        $reservation->delete();

        return response()->json([
            'message' => "Reserva $reservation->name eliminida correctamente.",
            'data' => ['id' => $reservation->id],
            'type' => 'success'
        ], 200);
    }

    public function delete(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);
        $reservation->delete();

        return redirect()->route('reservation.all')->with('alert', [
            'message' => "Reserva $reservation->name eliminida correctamente.",
            'type' => 'success'
        ]);
    }

    public function showAll()
    {
        $this->authorize('viewAny', Reservation::class);

        $reserves = Reservation::get();
        return view('reservations.index', compact('reserves'));
    }

    public function filter($filter)
    {
        if ($filter == 'all') {
            $data = Reservation::get();
        } else {
            $data = Reservation::where('name', 'like', "%$filter%")
                ->orWhere('date', 'like', "$filter")
                ->limit(6)
                ->get();
        }

        foreach ($data as $reserve) {
            $reserve->user;
        }

        return response()->json([
            'response' => $data,
            'message' => 'Datos obtenidos correctamente.'
        ], 200);
    }
}
