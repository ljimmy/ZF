<?php
/**
 * Created by PhpStorm.
 * User: xfb_user
 * Date: 2018/4/20
 * Time: 下午5:48
 */

namespace SF\Events;


use SF\Contracts\Event\Event;

class Start implements Event
{
    public function getType()
    {
        return EventTypes::SERVER_START;
    }

    public function handle()
    {
    }


}