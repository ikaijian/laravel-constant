<?php
/**
 * @Author: chenkaijian <ikaijian@163.com>,
 * @Date: 2021/12/9 16:46,
 * @LastEditTime: 2021/12/9 16:46,
 * @Copyright: 2020 Kabel Inc. 保留所有权利。
 */

namespace Ikaijian\LaravelConstant;


use Ikaijian\LaravelConstant\Annotation\ReflectionAdapter;
use Ikaijian\LaravelConstant\Contracts\AdapterInterface;
use Ikaijian\LaravelConstant\Exception\EnumException;
use Ikaijian\LaravelConstant\Support\LaravelStr;
use Ikaijian\LaravelConstant\Support\SingletonTrait;

/**
 * Class EnumAbstract
 * @package Ikaijian\LaravelConstant
 * @method getMessage($code)
 * @method getDesc($code)
 */
abstract class EnumAbstract
{
    use SingletonTrait;

    /** @var AdapterInterface */
    public static $enumAdapter;

    private function __construct()
    {
       self::$enumAdapter = new ReflectionAdapter(static::class);
    }

    /**
     *
     *
     * @param $name
     * @param $arguments
     * @return mixed|string
     * @throws EnumException
     * @throws \ReflectionException
     * @Date: 2021/12/9 17:17
     * @Author: ikaijian
     */
    public function __call($name, $arguments)
    {
        if (!LaravelStr::startsWith($name, 'get')) {
            throw new EnumException('The function is not defined!');
        }
        if (!isset($arguments) || empty($arguments)) {
            throw new EnumException('The Code is required');
        }

        $code = $arguments[0];
        $name = strtolower(substr($name, 3));

        if (isset($this->$name)) {
            return isset($this->$name[$code]) ? $this->$name[$code] : '';
        }

        // 获取反射变量
        $ref = new \ReflectionClass(static::class);
        $properties = $ref->getDefaultProperties();
        $arr = self::$enumAdapter->getAnnotationsByName($name, $properties);
        //兼容PHP本版
        if (version_compare(PHP_VERSION, 7, '<')) {
            return isset($arr[$code]) ? $arr[$code] : '';
        }

        $this->$name = $arr;
        return isset($this->$name[$code]) ? $this->$name[$code] : '';
    }

    /**
     * 静态调用
     *
     * @param $method
     * @param $arguments
     * @return mixed
     * @Date: 2021/12/9 17:17
     * @Author: ikaijian
     */
    public static function __callStatic($method, $arguments)
    {
        return static::getInstance()->$method(...$arguments);
    }

    /**
     * 获取枚举数组
     *
     * @return array|mixed
     * @throws \ReflectionException
     * @Date: 2021/12/9 17:17
     * @Author: ikaijian
     */
    public static function toArray()
    {
        $ref = new \ReflectionClass(static::class);
        $properties = $ref->getDefaultProperties();
        return self::$enumAdapter->getAnnotationsByName('Message', $properties);
    }
}