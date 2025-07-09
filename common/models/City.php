<?php
namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "city".
 *
 * @property int          $id
 * @property string       $slug
 * @property string       $name
 * @property string|null  $genitive
 * @property string|null  $dative
 * @property string|null  $phone
 * @property bool         $in_location
 * @property bool         $is_active
 * @property string       $created_at
 * @property string       $updated_at
 *
 * @property ServiceCity[] $serviceCities
 */

class City extends ActiveRecord
{
    use ActiveRecordExtra;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%city}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['slug', 'name'], 'required'],
            [['slug'], 'string', 'max' => 32],
            [['name', 'genitive', 'dative'], 'string', 'max' => 64],
            [['phone'], 'string', 'max' => 32],
            [['in_location', 'is_active'], 'boolean'],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getServiceCities(): ActiveQuery
    {
        return $this->hasMany(ServiceCity::class, ['city_id' => 'id']);
    }

    /**
     * @return string|null
     */
    public function getCoatUrl(): ?string
    {
        $path = Yii::getAlias("@webroot/img/cities/{$this->slug}.png");
        if (is_file($path)) {
            return Yii::getAlias("@web/img/cities/{$this->slug}.png");
        }
        return null; // герба нет
    }

}
