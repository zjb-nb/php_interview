<?php

/**
 * 2020/6/18
 * 雪花算法在日常业务中十分常见，比如当我们需要生成全局唯一id时
 * 何时需要全局ID，当业务需要幂等性的操作，
 * 比如mysql的update就是幂等性操作，不论执行几次同样的代码结果都一样，mysql值
 * 业务联想:创建订单
 * 在创建订单时，当出现网络波动或者客户端因设计的不够恰当导致用户进行了两次创建订单行为时
 * 那么不当的设计就会导致一份订单生成两个订单号
 * 避免方法就是用幂等操作，我们知道数据库根据主键id新增值时，当id存在会执行失败
 * 那么在创建订单前我们生成的一个全局唯一的ID先返回给客户端，
 * 客户端在发起创建订单请求时携带该ID即可(至于怎么生成订单号随你业务)
 * 同时为了避免跳过客户端访问创建订单，我们还需要将该ID存入redis，并在业务处理时进行对比
 * 注意:（为了增加体验）若因为生成订单号时唯一id重复导致错误 我们应该返回给客户端成功消息或者重复创建订单提示，而不是拒绝提示
 */


class IdCreate{
    const EPOCH = 1479533469598;    //开始时间,固定一个小于当前时间的毫秒数
    const max12bit = 4095;    
    const max41bit = 1099511627775;    
    static $machineId = null;      // 机器id

    public static function machineId($mId = 0)
    {
        self::$machineId = $mId;
    }    public static function createOnlyId()
    {
        // 时间戳 42字节
        $time = floor(microtime(true) * 1000);        // 当前时间 与 开始时间 差值
        $time -= self::EPOCH;        // 二进制的 毫秒级时间戳
        $base = decbin(self::max41bit + $time);        // 机器id  10 字节
        if(!self::$machineId)
        {            $machineid = self::$machineId;
        }        else
        {            $machineid = str_pad(decbin(self::$machineId), 10, "0", STR_PAD_LEFT);
        }        // 序列数 12字节
        $random = str_pad(decbin(mt_rand(0, self::max12bit)), 12, "0", STR_PAD_LEFT);        // 拼接
        $base = $base.$machineid.$random;        // 转化为 十进制 返回
        return bindec($base);
    }
}
$obj = new IdCreate();
$obj::machineID(12);
echo $obj::createOnlyId().PHP_EOL;
echo $obj::createOnlyId().PHP_EOL;
echo $obj::createOnlyId().PHP_EOL;

// echo $obj::create();
// echo $obj::create();
