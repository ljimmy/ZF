<?php

namespace SF\Protocol\Rpc;


use SF\Support\Collection;

/**
 * Class Header
 *
 * @property int id 消息id
 * @property int length 长度
 * @property int version 版本号
 * @property int flavor Authentication
 * @property int credentials 校验凭证
 * @property string action 调用名称
 * @package SF\AbstractProtocol\Rpc
 */
class Header extends Collection
{
    const HEADER_LENGTH = 24;//bytes

    const DELIMITER = "\r\n\r\n";

}