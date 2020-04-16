<?php

namespace App\Http\Controllers;

use App\Contacts;
use App\PersonNumbers;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    private $request;

    function __construct( Request $request )
    {
        $this->request = $request;
    }

    /**
     * Add person feature
     *
     * @return void
     */

    public function addPerson()
    {
        $this->validate($this->request, [
            'name'     => 'required|min:2|max:30',
            'lastname' => 'required|min:2|max:30'
        ]);

        if (Contacts::exists($this->request->input('name'), $this->request->input('lastname')) == 0) {
            Contacts::insert([
                'owner_user_id'   => $this->request->userData->id,
                'person_name'     => $this->request->input('name'),
                'person_lastname' => $this->request->input('lastname'),
            ]);

            return responder()->success(['message' => 'Contact added'])->respond();
        }
        return responder()->error(400, 'Person with this name and lastname already exists')->respond(400);
    }

    public function deletePerson( int $id )
    {
        if (Contacts::checkOwnership($id, $this->request->userData->id)) {

            Contacts::where(['id' => $id])->delete();
            return responder()->success(['message' => 'Person deleted'])->respond();
        }
        return responder()->error(400, 'Person doesn\'t exists in your contact list')->respond(400);
    }

    public function addPersonNumber( string $personId )
    {
        $this->validate($this->request, [
            'number' => 'required|min:9|max:15',
        ]);

        if (Contacts::checkOwnership($personId, $this->request->userData->id)) {
            return PersonNumbers::checkAndInsert($this->request->userData->id, $personId, $this->request->input('number'));
        }

        return responder()->error(400, 'Person doesn\'t exists in your contact list')->respond(400);
    }
}