# model-timestamp

数据表的时间字段使用时间戳格式，支持模型的软删除功能。

# 使用

创建模型时，使用 `XHyperf\ModelTimestamp\Model` 代替 `Hyperf\Database\Model\Model`。

# 软删除模型

模型需要使用 `XHyperf\ModelTimestamp\SoftDeletes` trait。

# 配置

## 时间字段

默认时间字段为 `created_at` 和 `updated_at`。

可以在模型中定义 `CREATED_AT` 和 `UPDATED_AT` 常量来指定时间字段。

## 软删除字段

默认软删除字段为 `deleted_at`。

可以在模型中定义 `DELETED_AT` 常量来指定软删除字段。
