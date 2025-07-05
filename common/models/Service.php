<?php
namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "service".
 *
 * @property int          $id
 * @property string       $slug
 * @property string       $title
 * @property string|null  $icon
 * @property string|null  $h1
 * @property string|null  $lead
 * @property array        $body          JSON — ['text'=>?, 'list'=>?, 'advantages'=>?]
 * @property bool         $is_fiz
 * @property bool         $is_jur
 * @property float|null   $price_from
 * @property string|null  $meta_title
 * @property string|null  $meta_desc
 * @property string|null  $meta_keywords
 * @property bool         $is_active
 * @property string       $created_at
 * @property string       $updated_at
 *
 * @property ServiceCity[] $serviceCities
 */

class Service extends ActiveRecord
{
    use ActiveRecordExtra;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%service}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['slug', 'title'], 'required'],
            [['slug'], 'string', 'max' => 64],
            [['title'], 'string', 'max' => 128],
            [['icon'],  'string', 'max' => 64],
            [['lead', 'meta_desc', 'meta_keywords'], 'string'],
            [['body'],  'safe'],                    // jsonb
            [['price_from'], 'number'],
            [['meta_title', 'h1'], 'string', 'max' => 255],
            [['is_active', 'is_fiz', 'is_jur'], 'boolean'],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getServiceCities(): ActiveQuery
    {
        return $this->hasMany(ServiceCity::class, ['service_id' => 'id']);
    }
}
