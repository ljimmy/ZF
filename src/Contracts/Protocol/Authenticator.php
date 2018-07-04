<?php

namespace SF\Contracts\Protocol;

interface Authenticator
{

    /**
     * @param Message $message
     * @return mixed
     */
    public function validate(Message $message);

    /**
     * 生成校验码
     * @param Message $message
     * @return string
     */
    public function generate(Message $message): string;
}