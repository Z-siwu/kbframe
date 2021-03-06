<?php

namespace App\Common\Enums;

/**
 * Class MessageLevelEnum 消息等级枚举
 * @package common\enums
 * @author jianyan74 <751393839@qq.com>
 */
class MessageLevelEnum extends BaseEnum
{
    const SUCCESS = 'success';
    const INFO = 'info';
    const WARNING = 'warning';
    const ERROR = 'error';

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return [
            self::INFO => '信息',
            self::WARNING => '警告',
            self::ERROR => '错误',
        ];
    }
}
