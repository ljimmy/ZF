<?php

namespace SF\Support;

use SF\Contracts\Support\Jsonable;

class Json
{

    /**
     * 编码json
     * @param $data
     * @param int $options
     * @param int $depth
     * @return string
     */
    public static function enCode($data,int $options = JSON_UNESCAPED_UNICODE, int $depth = 512)
    {
        if ($data instanceof Jsonable) {
            $data = $data->toJson();
        }
        return json_encode($data, $options, $depth);
    }


    /**
     * 解析json数据
     * @param $data
     * @param bool $assoc
     * @param int $depth
     * @param int $options
     * @return mixed
     */
    public static function deCode($data, $assoc = false, $depth = 512, $options = 0)
    {
        $value = json_decode($data, $assoc, $depth, $options);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Json unPack faild. Error message : ' .  json_last_error_msg());
        }
        return $value;
    }
}
