<?php
namespace App\Models;

use SF\Database\Model;

class User extends  Model
{
    public static function tableName(): string
    {
        return 'user';
    }



}