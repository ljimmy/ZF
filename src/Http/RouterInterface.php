<?php
namespace SF\Http;

use SF\Http\Request;
use SF\Http\Action;

interface RouterInterface
{
    public function handleHttpRequest(Request $request): Action;
}
