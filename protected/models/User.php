<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $created
 * @property integer $ban
 * @property integer $role
 * @property string $email
 */
class User extends CActiveRecord {

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const ROLE_BANNED = 'banned';

    public $verifyCode;
    public $icon; // атрибут для хранения загружаемой аватарки
    public $del_avatar; // атрибут для удаления загружаемой аватарки

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, email, password', 'required'),
            array('email', 'email'),
            array('email', 'filter', 'filter' => 'trim'),
            array('del_avatar', 'boolean'),
            array('avatar', 'length', 'max' => 255),
            array('icon', 'file',
                'types' => 'jpg, gif, png',
                'maxSize' => 1024 * 1024 * 5, // 5 MB
                'allowEmpty' => 'true',
                'tooLarge' => 'Filesize is more then 5 MB! Please, load a smaller file!',
            ),
            array('username', 'match', 'pattern' => '/^([A-Za-z0-9 ]+)$/u',
                'message' => 'Username is not a valid! You must use A-Za-z0-9'),
            array('username', 'filter', 'filter' => 'strtoupper'),
            array('username, email', 'unique',
                'caseSensitive' => true,
                'allowEmpty' => true,
            ),
            array('created, ban, role', 'numerical', 'integerOnly' => true),
            array('username', 'length', 'min' => 3, 'max' => 20),
            array('password', 'length', 'min' => 6, 'max' => 20),
            array('email', 'length', 'max' => 35),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, password, created, ban, role, email', 'safe', 'on' => 'search'),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on' => 'registration'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'page' => array(self::HAS_MANY, 'Page', 'user_id'),
            'comments' => array(self::HAS_MANY, 'Comments', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'created' => 'Created',
            'ban' => 'Ban',
            'role' => 'Role',
            'email' => 'E-mail',
            'verifyCode' => 'Enter code',
            'avatar' => 'image',
            'icon' => 'Avatar',
            'del_avatar' => 'Delete avatar?',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('created', $this->created);
        $criteria->compare('ban', $this->ban);
        $criteria->compare('role', $this->role);
        $criteria->compare('email', $this->email, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created = time();
            $this->role = 1;
        }

        $this->password = md5('sdfdsf[]\/>' . $this->password);
        return parent::beforeSave();
    }

    public static function find_id() {
        return self::model()->findAllByAttributes(array('id' => Yii::app()->user->id));
    }

    public static function all() {
        return CHtml::listData(self::model()->findAll(), 'id', 'username');
    }

    public static function ava_thumb($avatar, $class = 'page_avtr', $size) {
        if (!empty($avatar)) {
            if ($size == 'thumbs') {
                return
                        CHtml::image(Yii::app()->baseUrl . '/upload/avatars/thumbs/' . $avatar, $avatar, array(
                            'class' => $class)
                        );
            } else {
                return
                        CHtml::image(Yii::app()->baseUrl . '/upload/avatars/thumbs_small/' . $avatar, $avatar, array(
                            'class' => $class)
                        );
            }
        } else {
            return CHtml::image('/upload/avatars/noavatar_small.png', 'No avatar');
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
