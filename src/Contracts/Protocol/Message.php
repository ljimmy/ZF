<?php

namespace SF\Contracts\Protocol;

interface Message
{

    public function getPackageHeaders(): array;

    public function getPackageHeader(string $name);

    public function hasPackageHeader(string $name): bool;

    public function withPackageHeader(array $header);

    public function withAddPackageHeader(string $name, $value);

    public function withOutPackageHeader(string $name);

    public function getPackageBody();

    public function withPackageBody($body);
}
