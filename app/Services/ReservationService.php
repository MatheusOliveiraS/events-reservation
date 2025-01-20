<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    public function reserveTickets(array $data)
    {
        //Started a transaction to ensure that the reservation won't exceed the tickets available
        return DB::transaction(function () use ($data) {
            // Validates ticket availability and decrement tickets
            $updated = Event::where('id', $data['event_id'])
                ->where('tickets_remaining', '>=', $data['ticket_amount'])
                ->decrement('tickets_remaining', $data['ticket_amount']);

            if ($updated === 0) {
                throw new \Exception('Not enough tickets available.');
            }

            // Creates the reservation
            return Reservation::create([
                'event_id' => $data['event_id'],
                'ticket_amount' => $data['ticket_amount'],
            ]);
        });
    }

    public function cancelReservation(Reservation $reservation)
    {
        DB::transaction(function () use ($reservation) {
            // Increments the tickets_remaining back to the event
            Event::where('id', $reservation->event_id)
                ->increment('tickets_remaining', $reservation->ticket_amount);

         // Deletes the reservation
            $reservation->delete();
        });
    }

    public function updateReservation(Reservation $reservation, array $data)
    {
        return DB::transaction(function () use ($reservation, $data) {
            //Checks if the eventId changed
            if ($reservation->event_id != $data['event_id']) {
                $this->handleEventChange($reservation, $data);
            } else {
                $this->handleTicketAmountAdjustment($reservation, $data);
            }
    
            //Updates the reservation with new ticket amount
            $reservation->update(['ticket_amount' => $data['ticket_amount']]);
            
            return $reservation;
        });
    }
    
    private function handleEventChange(Reservation $reservation, array $data)
    {
        //Returns tickets to the old event
        $this->returnTicketsToOldEvent($reservation);
    
        //Decrements tickets for the new event
        $this->decrementTicketsForNewEvent($data);
    
        //Updates the eventId in the reservation
        $this->updateReservationEvent($reservation, $data);
    }
    
    private function returnTicketsToOldEvent(Reservation $reservation)
    {
        Event::where('id', $reservation->event_id)
            ->increment('tickets_remaining', $reservation->ticket_amount);
    }
    
    private function decrementTicketsForNewEvent(array $data)
    {
        $updated = Event::where('id', $data['event_id'])
            ->where('tickets_remaining', '>=', $data['ticket_amount'])
            ->decrement('tickets_remaining', $data['ticket_amount']);
    
        if ($updated === 0) {
            throw new \Exception('Not enough tickets available for the new event.');
        }
    }
    
    private function updateReservationEvent(Reservation $reservation, array $data)
    {
        $reservation->update([
            'event_id' => $data['event_id'],
            'ticket_amount' => $data['ticket_amount'],
        ]);
    }
    
    private function handleTicketAmountAdjustment(Reservation $reservation, array $data)
    {
        //Calculates the difference in ticket amount
        $difference = $data['ticket_amount'] - $reservation->ticket_amount;
    
        if ($difference > 0) {
            $this->increaseTicketAmount($reservation, $difference);
        } elseif ($difference < 0) {
            $this->decreaseTicketAmount($reservation, $difference);
        }
    }
    
    private function increaseTicketAmount(Reservation $reservation, int $difference)
    {
        $updated = Event::where('id', $reservation->event_id)
            ->where('tickets_remaining', '>=', $difference)
            ->decrement('tickets_remaining', $difference);
    
        if ($updated === 0) {
            throw new \Exception('Not enough tickets available.');
        }
    }
    
    private function decreaseTicketAmount(Reservation $reservation, int $difference)
    {
        Event::where('id', $reservation->event_id)
            ->increment('tickets_remaining', abs($difference));
    }
}