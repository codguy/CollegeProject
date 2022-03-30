<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_notification}}".
 *
 * @property int $id
 * @property string $username
 * @property string $title
 * @property string $type_id
 * @property int $state_id
 * @property int $to_user_id
 * @property string|null $model_id
 * @property string|null $created_on
 * @property int|null $created_by_id
 * @property int $user_id
 * @property string $icon_name
 */
class Notification extends \yii\db\ActiveRecord
{

    const TYPE_NEW_USER = 1;

    const TYPE_USER_DELETED = 2;

    const TYPE_USER_UPDATED = 3;

    const STATE_UNREAD = 1;

    const STATE_READED = 2;

    const STATE_DELETED = 3;

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_notification}}';
    }

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'username',
                    'title',
                    'type_id',
                    'state_id',
                    'to_user_id',
                    'user_id',
                    'icon_name'
                ],
                'required'
            ],
            [
                [
                    'state_id',
                    'to_user_id',
                    'created_by_id',
                    'user_id'
                ],
                'integer'
            ],
            [
                [
                    'created_on'
                ],
                'safe'
            ],
            [
                [
                    'username',
                    'title',
                    'type_id',
                    'model_id'
                ],
                'string',
                'max' => 50
            ],
            [
                [
                    'icon_name'
                ],
                'string',
                'max' => 11
            ]
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'title' => 'Title',
            'type_id' => 'Type ID',
            'state_id' => 'State ID',
            'to_user_id' => 'To User ID',
            'model_id' => 'Model ID',
            'created_on' => 'Created On',
            'created_by_id' => 'Created By ID',
            'user_id' => 'User ID',
            'icon_name' => 'Icon Name'
        ];
    }
}
