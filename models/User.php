<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email','status',  'password'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
        	[['email'], 'email'],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['password_reset_token'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 30],
        ];
    }
 public static function findByUsername($username){

	return self::findOne(['username'=>$username]);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Nombre'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Creado'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'password' => Yii::t('app', 'Password'),
        ];
    }
    public static function tableName(){
        return 'user';
    }
    
    public static function findIdentity($id){
	return static::findOne($id);
    }
    
    public static function findIdentityByAccessToken($token, $type = null){
	throw new NotSupportedException();//I don't implement this method because I don't have any access token column in my database
    }
    
    public function getId(){
	return $this->id;
    }
 
    public function getAuthKey(){
	return $this->auth_key;//Here I return a value of my authKey column
    }
 
    public function validateAuthKey($authKey){
	// return $this->auth_key === $auth_key;
    }
    
    public function validatePassword($password){
	return $this->password === $password;
    }
}
