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
        Contacts::setUser($this->request->userData->id);
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

            $newContactId = Contacts::insertGetId([
                'owner_user_id'   => $this->request->userData->id,
                'person_name'     => $this->request->input('name'),
                'person_lastname' => $this->request->input('lastname'),
            ]);

            return responder()->success(['message' => 'Contact added','person_id' => $newContactId])->respond();
        }
        return responder()->error(400, 'Person with this name and lastname already exists')->respond(400);
    }

    public function deletePerson( int $id )
    {
        if (Contacts::checkOwnership($id)) {

            if(Contacts::where(['id' => $id])->delete()){
                return responder()->success(['message' => 'Person deleted'])->respond();
            }
        }
        return responder()->error(400, 'Person doesn\'t exists in your contact list')->respond(400);
    }

    public function addPersonNumber( string $personId )
    {
        $this->validate($this->request, [
            'number' => 'required|min:9|max:15',
        ]);

        if (Contacts::checkOwnership($personId)) {

            if(!PersonNumbers::checkAndInsert($personId, $this->request->input('number'))){
                responder()->error(400, 'Person\'s number already exists in your contact list')->respond(400);
            }

            return responder()->success(['message' => 'Number added'])->respond();
        }
        return responder()->error(400, 'Person doesn\'t exists in your contact list')->respond(400);
    }

    public function getPersonNumbers( int $personId )
    {

        if (Contacts::checkOwnership($personId)) {
            return Contacts::getPersonNumbers($personId);
        }

        return responder()->error(400, 'Person doesn\'t exists in your contact list')->respond(400);
    }

    public function getList()
    {
        return Contacts::getPersonNumbers(null);
    }

    public function findPersonByNumber( $number )
    {
        return Contacts::findPersonBy('number',$number);
    }

}