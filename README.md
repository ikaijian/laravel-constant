<h1 align="center"> laravel-constant </h1>

<p align="center"> 枚举,错误码,constant,enum,统一管理错误码</p>

## 安装
~~~
composer require ikaijian/laravel-constant
~~~

## 使用
### 定义枚举类,继承ikaijian/laravel-constant的抽象类
~~~
class ErrorCode extends EnumAbstract
{
    /**
     * @Message('TOKEN失效')
     */
    public static INVALID_TOKEN = 1020;
}
~~~
### 获取枚举
~~~
$code = ErrorCode::INVALID_TOKEN;
$message = ErrorCode::getMessage($code);
~~~
### 获取枚举数组
~~~
$message = ErrorCode::toArray();
~~~

## License

MIT