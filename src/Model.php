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
}