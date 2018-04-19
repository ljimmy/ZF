<?php

namespace SF\Events;


class EventTypes
{
    /**
     * 服务器初始化
     */
    const SERVER_INIT = 'server_init';

    /**
     * 服务器启动前
     */
    const BEFORE_START = 'before_start';

    /**
     * 请求开始前
     */
    const BEFORE_REQUEST = 'before_request';

    /**
     * 请求结束后
     */
    const AFTER_REQUEST = 'after_request';

    /**
     * 数据接收前
     */
    const BEFORE_RECEIVE = 'before_receive';

    /**
     * 数据接收后
     */
    const AFTER_RECEIVE = 'after_receive';

    /**
     * 回应前
     */
    const BEFORE_REPLY = 'before_reply';

    /**
     * 回应后
     */
    const AFTER_REPLY = 'after_reply';
}