<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Event;

class UpdateReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'event_id' => ['required', 'exists:events,id'],
            'ticket_amount' => ['required', 'integer', 'min:1'],
            function ($attribute, $value, $fail) {
                // If event_id is provided in the request, use it
                $eventId = $this->event_id ?? $this->route('reservation')->event_id;
                
                // Find the event once
                $event = Event::find($eventId);
    
                // Validate ticket amount
                if ($value > $event->tickets_remaining) {
                    return $fail('The requested number of tickets exceeds the available tickets.');
                }
            }
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'event_id' => $this->eventId,
            'ticket_amount' => $this->ticketAmount
        ]);
    }
}