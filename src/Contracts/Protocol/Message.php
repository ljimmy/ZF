<?php

namespace SF\Contracts\Protocol;


interface Message
{
    public function getPackageHeader(): array;

    public function hasPackageHeader(string $name): bool;

    public function withPackageHeader(array $header);

    public function withAddPackageHeader(string $name, $value);

    public function withOutPackageHeader(string $name);

    public function getPackageBody();

    public function withPackageBody(string $body);
}