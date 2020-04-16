<?php

namespace App\Http\Controllers;

use App\Contacts;
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

    public function addPerson()
    {
        $this->request->userData->id;
    }
}