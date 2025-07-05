<?php
namespace common\models;

use yii\db\ActiveQuery;
use yii\db\Exception;

trait ActiveRecordExtra
{
    /**
     * Только активные записи по‑умолчанию
     *
     * @return ActiveQuery
     */
    public static function find(): ActiveQuery
    {
        return parent::find()->andWhere([static::tableName() . '.is_active' => true]);
    }

    /**
     * Мягкое удаление
     *
     * @return bool
     * @throws Exception
     */
    public function softDelete(): bool
    {
        $this->is_active = false;
        return $this->save(false, ['is_active']);
    }
}
