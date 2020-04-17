<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Contacts extends Model
{

    public static $userId;
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

    public static function setUser( $userId )
    {
        return self::$userId = $userId;
    }

    public static function getUser()
    {
        return self::$userId;
    }

    public static function checkOwnership( $contactId )
    {

        return self::where([
            'id'            => $contactId,
            'owner_user_id' => self::$userId,
        ])->exists();
    }

    public static function getPersonNumbers( $contactId = null )
    {

        $query = DB::table('user_contacts')
            ->select([
                'person_numbers.person_id',
                'person_numbers.number',
                'user_contacts.person_name',
                'user_contacts.person_lastname',
            ])
            ->leftJoin('person_numbers', 'person_numbers.person_id', '=', 'user_contacts.id');
        $query->where([
            'user_contacts.owner_user_id' => self::$userId,
        ]);
        if ($contactId) {
            $query->where([
                'person_numbers.person_id' => $contactId,
            ]);
        }
        $query->whereNotNull('person_numbers.number');
        $query->groupBy(['person_numbers.person_id','person_numbers.number']);
        return $query->get();
    }

    public static function findPersonBy( $findByOption, $findByValue )
    {

        $query = DB::table('person_numbers')
            ->select([
                'person_numbers.number',
                'user_contacts.id as person_id',
                'user_contacts.owner_user_id',
                'user_contacts.person_name',
                'user_contacts.person_lastname',
            ])
            ->leftJoin('user_contacts', 'person_numbers.person_id', '=', 'user_contacts.id');
        $query->where([
            'person_numbers.' . $findByOption => $findByValue,
            'user_contacts.owner_user_id' => self::$userId
        ]);
        $query->whereNotNull('person_numbers.' . $findByOption);

        return $query->get();
    }
}
