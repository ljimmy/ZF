<?php

namespace App\Controllers;

use SF\Http\Controller as HTTPController;
use SF\Http\Exceptions\NotFoundHttpException;
use SF\Http\Exceptions\BadRequestHttpException;

class Controller extends HTTPController
{

    public function getData($name = null, $defaultValue = null)
    {
        if ($name === null) {
            return $this->getRequestContext()->getRequest()->getQueryParams();
        } else {
            $value = $this->getRequestContext()->getRequest()->getQueryParam($name);

            return $value === false || $value === null ? $defaultValue : $value;
        }
    }

    public function postData($name = null, $defaultValue = null)
    {
        if ($name === null) {
            return $this->getRequestContext()->getRequest()->getBodyParams();
        } else {
            $value = $this->getRequestContext()->getRequest()->getBodyParam($name);

            return $value === false || $value === null ? $defaultValue : $value;
        }
    }

    public function getFile($name = null)
    {
        if ($name === null) {
            return $this->getRequestContext()->getRequest()->getFiles();
        } else {
            return $this->getRequestContext()->getRequest()->getFile($name);
        }
    }
    public function throw400(string $message = "", int $code = 0)
    {
        throw new BadRequestHttpException($message, $code);
    }


    public function throw404(string $message = "", int $code = 0)
    {
        throw new NotFoundHttpException($message, $code);
    }
}
