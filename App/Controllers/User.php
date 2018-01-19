<?php

namespace App\Controllers;


class User extends  Controller
{
    public function index()
    {
       $cache = $this->getApplicationContext()->getCache();
       $cache->set('a', 1);

       return $cache->get('a');
    }
}