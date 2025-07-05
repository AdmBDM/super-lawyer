<?php
namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "page_block".
 *
 * @property int          $id
 * @property int          $service_city_id
 * @property string       $type
 * @property string|null  $title
 * @property string|null  $content
 * @property int          $sort
 * @property bool         $is_active
 * @property string       $created_at
 * @property string       $updated_at
 *
 * @property ServiceCity  $serviceCity
 */

class PageBlock extends ActiveRecord
{
    use ActiveRecordExtra;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%page_block}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['service_city_id', 'type'], 'required'],
            [['service_city_id', 'sort'], 'integer'],
            [['content'], 'string'],
            [['type'],  'string', 'max' => 32],
            [['title'], 'string', 'max' => 255],
            [['is_active'], 'boolean'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getServiceCity(): ActiveQuery
    {
        return $this->hasOne(ServiceCity::class, ['id' => 'service_city_id']);
    }
}
