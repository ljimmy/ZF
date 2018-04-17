<?php
/**
 * Created by PhpStorm.
 * User: xfb_user
 * Date: 2018/4/17
 * Time: 下午3:21
 */

namespace SF\Contracts\Protocol\Http;


use Psr\Http\Message\RequestInterface;
use SF\Contracts\Protocol\Message;

interface Request extends RequestInterface, Message
{

}