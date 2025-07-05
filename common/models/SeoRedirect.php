<?php
namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "seo_redirect".
 *
 * @property int          $id
 * @property string       $old_path
 * @property string       $new_path
 * @property int          $code
 * @property string|null  $comment
 * @property bool         $is_active
 * @property string       $created_at
 * @property string       $updated_at
 */

class SeoRedirect extends ActiveRecord
{
    use ActiveRecordExtra;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%seo_redirect}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['old_path', 'new_path'], 'required'],
            [['old_path', 'new_path'], 'string', 'max' => 255],
            [['old_path'], 'unique'],
            [['code'], 'integer'],
            [['comment'], 'string', 'max' => 255],
            [['is_active'], 'boolean'],
        ];
    }
}
