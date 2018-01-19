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
        return RequestContext::get(CoroutineContext::getTop());
    }

}
