<?php
/**
 * @Author: chenkaijian <ikaijian@163.com>,
 * @Date: 2021/12/9 16:56,
 * @LastEditTime: 2021/12/9 16:56,
 * @Copyright: 2020 Kabel Inc. 保留所有权利。
 */

namespace Ikaijian\LaravelConstant\Contracts;

/**
 * 定义适配器协议
 *
 * Interface AdapterInterface
 * @package Ikaijian\LaravelConstant\Contracts
 */
interface AdapterInterface
{
    public function __construct($class);

    /**
     * 获取注解名
     *
     * @param $name
     * @param $properties
     * @return mixed
     * @Date: 2021/12/9 16:57
     * @Author: ikaijian
     */
    public function getAnnotationsByName($name, $properties);
}