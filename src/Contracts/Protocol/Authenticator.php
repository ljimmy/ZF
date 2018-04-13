<?php

namespace SF\Contracts\Protocol;


interface Authenticator
{
    /**
     * @param int $flavor 验证
     * @param string $credentials 凭证
     * @return mixed
     */
    public function validate(int $flavor, string $credentials);

    /**
     * 生成凭证
     * @param Replier $replier
     * @return string
     */
    public function generate(Replier $replier): string;
}