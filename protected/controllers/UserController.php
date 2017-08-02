<?php

class UserController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    //выставляем права
    public function accessRules() {
        return array(
            array('allow', // действия для гостей
                'actions' => array('index'),
                'users' => array('*'),
            ),
            array('allow', // действия для зарегистрированных пользователей
                'actions' => array('articles', 'update', 'newarticle', 'delete', 'comments'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate() {
        //загружаем модель 
        $model = $this->loadModel();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            //загружаем аватар
            $model->icon = CUploadedFile::getInstance($model, 'icon');
            if ($model->icon) {
                //получаем имя загруженного файла
                $sourcePath = pathinfo($model->icon->getName());
                //присваиваем $filename имя файла с расширением
                $filename = md5(microtime() . rand(0, 9999)) . '.' . $sourcePath['extension'];
                //присваиваем свойству avatar и сохраняем в базу имя с расширением
                $model->avatar = $filename;
            }
            if ($model->save()) {
                //Если отмечен чекбокс «удалить файл»
                if ($model->del_avatar) {
                    if (!empty($avatar)) {
                        //удаляем картинку и все её thumbs
                        unlink('/upload/avatars/thumbs/' . $filename);
                        unlink('/upload/avatars/thumbs_small/' . $filename);
                        $model->avatar = '';
                    }
                }
                if ($model->icon) {
                    //сохранить файл на сервере в каталог upload/avatars/thumbs/ под именем
                    $file = Yii::getPathOfAlias('webroot.upload.avatars.thumbs') . '/' . $filename;
                    $model->icon->saveAs($file);

                    //Используем функции расширения CImageHandler;
                    $ih = new CImageHandler(); //Инициализация
                    Yii::app()->ih
                            ->load($file)//Загрузка оригинала картинки
                            ->adaptivethumb('100', '100')//Создание превьюшки шириной 100px
                            ->save(Yii::getPathOfAlias('webroot.upload.avatars.thumbs') . '/' . $filename)//Сохранение превьюшки в папку thumbs
                            ->reload()//Перезагрузка оригинала картинки
                            ->adaptivethumb('70', '70')
                            ->save(Yii::getPathOfAlias('webroot.upload.avatars.thumbs_small') . '/' . $filename)
                    ;
                }
                $this->redirect(array('index', 'id' => Yii::app()->user->id));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */

    /**
     * Lists all models.
     */
    public function actionIndex($id) {

        $model = User::model()->findByPk($id);

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel() {
        $id = Yii::app()->user->id;
        $model = User::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
