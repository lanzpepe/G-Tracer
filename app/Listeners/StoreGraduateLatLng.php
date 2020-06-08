<?php

namespace App\Listeners;

use App\Models\Contact;
use App\Traits\StaticTrait;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreGraduateLatLng implements ShouldQueue
{
    use StaticTrait;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $contacts = Contact::where('graduate_id', $event->graduate->graduate_id)->get();

        if ($contacts) {
            foreach ($contacts as $contact) {
                $contact->update([
                    'latitude' => $this->getLatLng($contact->address)['lat'],
                    'longitude' => $this->getLatLng($contact->address)['lng']
                ]);
            }
        }
    }
}
