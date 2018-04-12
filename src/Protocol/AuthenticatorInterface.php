<?php

namespace SF\Protocol;


interface AuthenticatorInterface
{
    /**
     * @param int $flavor 验证
     * @param string $credentials 凭证
     * @return mixed
     */
    public function validate(int $flavor, string $credentials);

    /**
     * 生成凭证
     * @param ReceiverInterface $receiver
     * @return string
     */
    public function generate(ReceiverInterface $receiver): string;
}