<?php

namespace SF\Context;

trait ContextTrait
{

    /**
     *
     * @return ApplicationContext
     */
    public function getApplicationContext()
    {
        return ApplicationContext::getContext();
    }

    /**
     *
     * @return RequestContext
     */
    public function getRequestContext()
    {
        return RequestContext::get(CoroutineContext::getStackTopId());
    }

    /**
     *
     * @return ConnectContext
     */
    public function getConnectContext()
    {
        return ConnectContext::get(CoroutineContext::getStackTopId());
    }

}
