<?php

namespace XHyperf\ModelTimestamp;

use Hyperf\DbConnection\Model\Model as BaseModel;

class Model extends BaseModel
{
    const string DATE_FORMAT = 'U';

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

    /**
     * 设置创建时间
     * @param mixed $value
     * @return $this
     */
    protected function setCreatedAtAttribute(mixed $value): static
    {
        $this->attributes[static::CREATED_AT] = $this->asDateTime($value)->format(static::DATE_FORMAT);

        return $this;
    }

    /**
     * 设置更新时间
     * @param mixed $value
     * @return $this
     */
    protected function setUpdatedAtAttribute(mixed $value): static
    {
        $this->attributes[static::UPDATED_AT] = $this->asDateTime($value)->format(static::DATE_FORMAT);

        return $this;
    }

    /**
     * 获取更新时间
     * @return string|null
     */
    public function freshTimestampString(): ?string
    {
        return $this->freshTimestamp()->format(static::DATE_FORMAT);
    }
}