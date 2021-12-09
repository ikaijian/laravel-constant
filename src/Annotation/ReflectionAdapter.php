<?php
/**
 * @Author: chenkaijian <ikaijian@163.com>,
 * @Date: 2021/12/9 16:59,
 * @LastEditTime: 2021/12/9 16:59,
 * @Copyright: 2020 Kabel Inc. 保留所有权利。
 */

namespace Ikaijian\LaravelConstant\Annotation;


use Ikaijian\LaravelConstant\Contracts\AdapterInterface;
use Ikaijian\LaravelConstant\Support\LaravelStr;

/**
 * 实现反射类适配器
 *
 * Class ReflectionAdapter
 * @package Ikaijian\LaravelConstant\Annotation
 */
class ReflectionAdapter implements AdapterInterface
{
    protected $class;

    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * 获取注解名
     *
     * @param $name
     * @param $properties
     * @return array|mixed
     * @throws \ReflectionException
     * @Date: 2021/12/9 17:10
     * @Author: ikaijian
     */
    public function getAnnotationsByName($name, $properties)
    {
        $result = [];
        foreach ($properties as $key => $val) {
            if (LaravelStr::startsWith($key, 'ENUM_')) {
                // 获取对应注释
                $ret = new \ReflectionProperty($this->class, $key);
                $result[$val] = $this->getCommentByName($ret->getDocComment(), $name);
            }
        }

        return $result;
    }

    /**
     * 根据name解析doc获取对应注释
     *
     * @param $doc //注释
     * @param $name //字段名
     * @return mixed|null
     * @Date: 2021/12/9 17:11
     * @Author: ikaijian
     */
    protected function getCommentByName($doc, $name)
    {
        $name = LaravelStr::studly($name);
        $pattern = "/\@{$name}\(\'(.*)\'\)/U";
        if (preg_match($pattern, $doc, $result)) {
            if (isset($result[1])) {
                return $result[1];
            }
        }
        return null;
    }

}