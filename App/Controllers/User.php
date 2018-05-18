<?php

namespace App\Controllers;


class User extends  Controller
{
    public function index()
    {
        var_dump(3);
       $cache = $this->getApplicationContext()->getCache();
       $cache->set('a', 1);

       return $cache->get('a');
    }

    public function detail()
    {
        return \App\Models\User::execute('find_one', [1])->getResult();
    }
}