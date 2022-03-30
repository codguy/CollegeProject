<?php
namespace app\models;

use Yii;
use yii\base\Security;
use yii\console\controllers\CacheController;

/**
 * This is the model class for table "{{%tbl_user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property int $roll_id
 * @property int $state_id
 * @property string|null $dob
 * @property string|null $created_on
 * @property int|null $created_by_id
 * @property string $authKey
 * @property string $accessToken
 * @property string $gender
 * @property string|null $profile_picture
 */
class TblUser extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    const ROLE_ADMIN = 1;

    const ROLE_MANAGER = 2;

    const ROLE_STAFF = 3;

    const ROLE_STUDENT = 4;

    const ROLE_PARENT = 5;

    const STATE_ACTIVE = 1;

    const STATE_INACTIVE = 2;

    const STATE_FREEZE = 3;

    const STATE_DELETED = 4;
    
    const STATE_UPCOMING = 5;

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_user}}';
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
                    'email',
                    'password',
                    'roll_id'
                ],
                'required'
            ],
            [
                [
                    'roll_id',
                    'state_id',
                    'created_by_id'
                ],
                'integer'
            ],
            [
                [
                    'dob',
                    'created_on'
                ],
                'safe'
            ],
            [
                [
                    'username',
                    'email',
                    'password'
                ],
                'string',
                'max' => 50
            ],
            [
                [
                    'authKey',
                    'accessToken'
                ],
                'string',
                'max' => 20
            ],
            [
                [
                    'gender'
                ],
                'string',
                'max' => 8
            ],
            [
                [
                    'profile_picture'
                ],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'jpg, png'
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
            'email' => 'Email',
            'password' => 'Password',
            'roll_id' => 'Roll ID',
            'state_id' => 'State ID',
            'dob' => 'Dob',
            'created_on' => 'Created On',
            'created_by_id' => 'Created By ID',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'gender' => 'Gender',
            'profile_picture' => 'Profile Picture'
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     *
     * @inheritdoc
     */
    /* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne([
            'access_token' => $token
        ]);
    }

    /*
     * removed
     * public static function findIdentityByAccessToken($token)
     * {
     * throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
     * }
     */
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($email)
    {
        return static::findOne([
            'email' => $email
        ]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token
     *            password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     *
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     *
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     *
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password
     *            password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return ($this->password == $password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Security::generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authKey = Security::generateRandomKey();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Security::generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * EXTENSION MOVIE *
     */
    public function getImageUrl()
    {
        if (!empty($this->profile_picture)) {
            return Yii::$app->request->baseUrl.'/../uploads/' . $this->profile_picture;
        }else {
            return Yii::$app->request->baseUrl.'/images/user-icon.png';
        }
    }

    public function getImage()
    {
        $img = '<img src=' . $this->getImageUrl() . ' height="60px" width="60px" class="profile_pic">';
        return $img;
    }

//     public function imageName()
//     {
//         return str_replace(" ", "_", $this->profile_picture->baseName) . '.' . $this->profile_picture->extension;
//     }

    public function upload()
    {
        if ($this->validate(false)) {
            if (! empty($this->profile_picture)) {
                $this->profile_picture->saveAs('../uploads/' . str_replace(" ", "_", $this->profile_picture->baseName) . '.' . $this->profile_picture->extension);
                return true;
            }
        } else {
            return false;
        }
    }

    public function getRoleOption()
    {
        $list = array(
            TblUser::ROLE_ADMIN => 'Admin',
            TblUser::ROLE_MANAGER => 'Manager',
            TblUser::ROLE_STAFF => 'Staff',
            TblUser::ROLE_STUDENT => 'Student',
            TblUser::ROLE_PARENT => 'Parent'
        );
        return $list;
    }

    public function getRole($id)
    {
        $list = $this->getRoleOption();
        return $list[$id];
    }
    
    public function getStateOption()
    {
        $list = array(
            TblUser::STATE_ACTIVE => 'Active',
            TblUser::STATE_INACTIVE => 'Inactive',
            TblUser::STATE_FREEZE => 'Freezed',
            TblUser::STATE_DELETED => 'Deleted',
            TblUser::STATE_UPCOMING => 'Upcoming'
        );
        return $list;
    }
    
    public function getState($id)
    {
        $list = $this->getStateOption();
        return $list[$id];
    }
    
    public function getTableProfile($model){
        $profile = $model->getImage()." ".$model->username;
        return $profile;
    }
    
    
}
