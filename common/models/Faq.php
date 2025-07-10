<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Faq extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%faq}}';
    }

    /**
     * @return ActiveQuery
     */
    public function getService(): ActiveQuery
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCity(): ActiveQuery
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['service_id', 'question', 'answer'], 'required'],
            [['question', 'answer'], 'string'],
            [['is_active'], 'boolean'],
            [['city_id', 'service_id'], 'integer'],
        ];
    }
}
