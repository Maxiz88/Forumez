<?php

/**
 * This is the model class for table "page".
 *
 * The followings are the available columns in table 'page':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $created
 * @property integer $status
 * @property integer $category_id
 */
class Page extends CActiveRecord {

    public $icon; // атрибут для хранения загружаемой картинки статьи
    public $del_img;

    public function tableName() {
        return 'page';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, content, category_id', 'required'),
            array('del_img', 'boolean'),
            array('created, status, category_id, user_id', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('content', 'length', 'max' => 100000),
            array('image', 'length', 'max' => 255),
            array('icon', 'file',
                'types' => 'jpg, gif, png',
                'maxSize' => 1024 * 1024 * 5, // 5 MB
                'allowEmpty' => 'true',
                'tooLarge' => 'Filesize is more then 5 MB! Please, load a smaller file!',
            ),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, content, created, status, category_id, user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'comments' => array(self::HAS_MANY, 'Comments', 'page_id'),
            'commentsCount' => array(self::STAT, 'Comments', 'page_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'created' => 'Created',
            'status' => 'Status',
            'category_id' => 'Category',
            'user_id' => 'User_id',
            'icon' => 'Image',
            'del_img' => 'Delete image?',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('created', $this->created);
        $criteria->compare('status', $this->status);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('user_id', $this->user_id);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave() {
        if ($this->isNewRecord)
            $this->created = time();
        return parent::beforeSave();
    }

    public static function thumb($image, $class = 'page_img', $size) {
        if (!empty($image)) {
            if ($size == 'thumbs') {
                return
                        CHtml::image(Yii::app()->baseUrl . '/upload/images/thumbs/' . $image, $image, array(
                            'class' => $class)
                );
            } else {
                return
                        CHtml::image(Yii::app()->baseUrl . '/upload/images/' . $image, $image, array(
                            'class' => $class,)
                );
            }
        } else {
            return CHtml::image('/upload/images/noimage.png', 'No image', array(
                        'class' => $class
            ));
        }
    }

    public static function all() {
        return CHtml::listData(self::model()->findAll(), 'id', 'title');
    }

    public static function userarticle() {
        return parent::model()->findAllByAttributes('title', array('user_id' => Yii::app()->user->id));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Page the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
