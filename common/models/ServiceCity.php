<?php
namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "service_city".
 *
 * @property int          $id
 * @property int          $city_id
 * @property int          $service_id
 * @property string|null  $h1
 * @property string|null  $lead
 * @property string|null  $body
 * @property float|null   $price_from
 * @property string|null  $meta_title
 * @property string|null  $meta_desc
 * @property string|null  $meta_keywords
 * @property bool         $is_active
 * @property string       $created_at
 * @property string       $updated_at
 *
 * @property City          $city
 * @property Service       $service
 * @property PageBlock[]   $blocks
 */

class ServiceCity extends ActiveRecord
{
    use ActiveRecordExtra;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%service_city}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['city_id', 'service_id'], 'required'],
            [['city_id', 'service_id'], 'integer'],
            [['lead', 'body', 'meta_desc', 'meta_keywords'], 'string'],
            [['price_from'], 'number'],
            [['h1', 'meta_title'], 'string', 'max' => 255],
            [['is_active'], 'boolean'],
            [['city_id', 'service_id'], 'unique', 'targetAttribute' => ['city_id', 'service_id']],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCity(): ActiveQuery
    {
        return $this->hasOne(City::class,    ['id' => 'city_id']);
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
    public function getBlocks(): ActiveQuery
    {
        return $this->hasMany(PageBlock::class, ['service_city_id' => 'id'])->orderBy(['sort'=>SORT_ASC]);
    }
}
