<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\ReservationCollection;
use App\Services\ReservationService;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function index()
    {
        return new ReservationCollection(Reservation::all());
    }

    public function store(StoreReservationRequest $request)
    {
        $reservation = $this->reservationService->reserveTickets($request->validated());
        return new ReservationResource($reservation);
    }

    public function show(Reservation $reservation)
    {
        return new ReservationResource($reservation);
    }

    //This method allows you to change the number of tickets, the event or both
    public function update(StoreReservationRequest $request, Reservation $reservation)
    {
        $updatedReservation = $this->reservationService->updateReservation($reservation, $request->validated());
    
        return new ReservationResource($updatedReservation);
    }

    public function destroy(Reservation $reservation)
    {
        $this->reservationService->cancelReservation($reservation);

        return response()->json(['message' => 'Reservation canceled successfully.'], 200);
    }
}
