<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user_contacts';

    protected $fillable = [
        'person_name', 'person_lastname', 'owner_user_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public static function exists( $name, $lastname )
    {

        return self::where([
            'person_name'     => $name,
            'person_lastname' => $lastname,
        ])->count();
    }

    public static function checkOwnership( $cotnactId, $userId )
    {

        return self::where([
            'id'            => $cotnactId,
            'owner_user_id' => $userId,
        ])->exists();
    }
}
