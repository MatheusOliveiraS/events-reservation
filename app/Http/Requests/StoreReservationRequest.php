<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Event;

class StoreReservationRequest extends FormRequest
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
            function($attribute, $value, $fail){
                $event = Event::find($this->event_id);

                if(!$event){
                    return $fail('The selected event does not exist.');
                }

                if($value > $event->tickets_remaining){
                    return $fail('The requested number of tickets');
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
