<?php

namespace SF\Context;

trait ContextTrait
{

    /**
     *
     * @return ApplicationContext
     */
    protected function getApplicationContext()
    {
        return ApplicationContext::getContext();
    }

    /**
     *
     * @return RequestContext
     */
    protected function getRequestContext()
    {
        return RequestContext::get(CoroutineContext::getStackTopId());
    }

    /**
     *
     * @return ConnectContext
     */
    protected function getConnectContext()
    {
        return ConnectContext::get(CoroutineContext::getStackTopId());
    }

}
