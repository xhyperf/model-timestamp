<?php

namespace XHyperf\ModelTimestamp;

use Psr\EventDispatcher\StoppableEventInterface;

trait SoftDeletes
{
    use \Hyperf\Database\Model\SoftDeletes;

    public static function bootSoftDeletes(): void
    {
        static::addGlobalScope(new SoftDeletingScope());
    }

    /**
     * 恢复一个软删除的模型实例
     * @return null|bool
     */
    public function restore(): ?bool
    {
        // If the restoring event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($event = $this->fireModelEvent('restoring')) {
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                return false;
            }
        }

        $this->{$this->getDeletedAtColumn()} = 0;

        // Once we have saved the model, we will fire the "restored" event so this
        // developer will do anything they need to after a restore operation is
        // totally finished. Then we will return the result of the save call.
        $this->exists = true;

        $result = $this->save();

        $this->fireModelEvent('restored');

        return $result;
    }

    /**
     * 在这个模型实例上执行软删除操作
     */
    protected function runSoftDelete(): void
    {
        $query = $this->newModelQuery()->where($this->getKeyName(), $this->getKey());

        $time = $this->freshTimestamp();

        $columns = [$this->getDeletedAtColumn() => $this->fromDateTime($time)];

        $this->{$this->getDeletedAtColumn()} = $time;

        if ($this->timestamps && ! ! $this->getUpdatedAtColumn()) {
            $this->{$this->getUpdatedAtColumn()} = $time;

            $columns[$this->getUpdatedAtColumn()] = $this->fromDateTime($time);
        }

        $query->update($columns);
    }
}