<?php
/**
 * @Author: chenkaijian <ikaijian@163.com>,
 * @Date: 2021/12/9 16:38,
 * @LastEditTime: 2021/12/9 16:38,
 * @Copyright: 2020 Kabel Inc. 保留所有权利。
 */

namespace Ikaijian\LaravelConstant\Support;


trait SingletonTrait
{
    /**
     * @var array
     */
    protected static $instances = [];

    /**
     * @var
     */
    protected $instanceKey;

    /**
     * 获取单例
     *
     * @param null $key
     * @param false $refresh
     * @return mixed|static
     * @Date: 2021/12/9 16:41
     * @Author: ikaijian
     */
    public static function getInstance($key = null, $refresh = false)
    {
        if (!isset($key)) {
            $key = get_called_class();
        }

        if (!$refresh && isset(static::$instances[$key]) && static::$instances[$key] instanceof static) {
            return static::$instances[$key];
        }

        $client = new static();
        $client->instanceKey = $key;
        return static::$instances[$key] = $client;
    }

    /**
     * 销毁单例
     *
     * @Date: 2021/12/9 16:42
     * @Author: ikaijian
     */
    public function destroyInstance()
    {
        unset(static::$instances[$this->instanceKey]);
    }
}