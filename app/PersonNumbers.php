<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonNumbers extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'person_numbers';

    protected $fillable = [
        'owner_user_id', 'person_id', 'number'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public static function checkAndInsert($userId, $personId, $personNumber)
    {

        if(self::where([
            'owner_user_id' => $userId,
            'person_id'     => $personId,
            'number'        => $personNumber
        ])->exists()){
            return responder()->error(400, 'Person\'s number already exists in your contact list')->respond(400);
        }

        self::insert([
            'owner_user_id' => $userId,
            'person_id'     => $personId,
            'number'        => $personNumber
        ]);

        return responder()->success(['message' => 'Number added'])->respond();
    }

}
