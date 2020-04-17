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

    public function getPersonNumbers( $personId = null )
    {
        return PersonNumbers::where(Contacts::$userId, $personId);
    }


    public static function checkAndInsert( $personId, $personNumber )
    {

        if (self::where([
            'owner_user_id' => Contacts::$userId,
            'person_id'     => $personId,
            'number'        => $personNumber
        ])->exists()) {
            return false;
        }

        self::insert([
            'owner_user_id' => Contacts::$userId,
            'person_id'     => $personId,
            'number'        => $personNumber
        ]);

        return true;
    }

}
