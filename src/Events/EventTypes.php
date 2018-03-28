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
}