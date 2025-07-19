<?php

namespace XHyperf\ModelTimestamp;

use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Model;

class SoftDeletingScope extends \Hyperf\Database\Model\SoftDeletingScope
{
    /**
     * Apply the scope to a given Model query builder.
     * @param Builder $builder
     * @param Model   $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getQualifiedDeletedAtColumn(), 0);
    }

    /**
     * Add the restore extension to the builder.
     * @param Builder $builder
     */
    protected function addRestore(Builder $builder)
    {
        $builder->macro('restore', function (Builder $builder) {
            $builder->withTrashed();

            return $builder->update([$builder->getModel()->getDeletedAtColumn() => 0]);
        });
    }

    /**
     * Add the with-trashed extension to the builder.
     * @param Builder $builder
     */
    protected function addWithTrashed(Builder $builder)
    {
        $builder->macro('withTrashed', function (Builder $builder, $withTrashed = true) {
            if (!$withTrashed) {
                return $builder->withoutTrashed();
            }

            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * 添加构建器扩展：非软删除数据
     * @param Builder $builder
     */
    protected function addWithoutTrashed(Builder $builder)
    {
        $builder->macro('withoutTrashed', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->where(
                $model->getQualifiedDeletedAtColumn(),
                0
            );

            return $builder;
        });
    }

    /**
     * 添加构建器扩展：仅软删除数据
     * @param Builder $builder
     */
    protected function addOnlyTrashed(Builder $builder)
    {
        $builder->macro('onlyTrashed', function (Builder $builder) {
            $model = $builder->getModel();

            $builder->withoutGlobalScope($this)->where(
                $model->getQualifiedDeletedAtColumn(),
                '<>',
                0
            );

            return $builder;
        });
    }
}