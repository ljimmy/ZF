<?php
namespace App\Models;

use SF\Databases\Model;

class User extends  Model
{
    public static function tableName(): string
    {
        return 'user';
    }



}