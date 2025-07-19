<?php

namespace XHyperf\ModelTimestamp;

use Hyperf\DbConnection\Model\Model as BaseModel;

class Model extends BaseModel
{
    /**
     * 时间字段格式
     * @var string|null
     */
    protected ?string $dateFormat = 'U';

    /**
     * 软删除字段名
     */
    public const string DELETED_AT = 'deleted_at';

    /**
     * 日期字段
     * @var array
     */
    protected array $dates = [
        self::DELETED_AT,
    ];
}