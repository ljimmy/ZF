<?php

namespace SF\Event;


class EventTypes
{
    /**
     * server
     */
    const SERVER_START = 'server_start'; //server has started

    const SERVER_STOP = 'server_stop'; // server has stopped

    const SERVER_RELOAD = 'server_reload';

    /**
     * http
     */
    const BEFORE_REQUEST = 'before_request';

    const AFTER_REQUEST = 'after_request';

    /**
     * tcp
     */
    const BEFORE_RECEIVE = 'before_receive';

    const AFTER_RECEIVE = 'after_receive';

    const BEFORE_REPLY = 'before_reply';

    const AFTER_REPLY = 'after_reply';
}