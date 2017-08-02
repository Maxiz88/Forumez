<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha на странице контактов
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionRegistration() {
        $model = new User;
        //задаем сценарий регистрация
        $model->scenario = 'registration';

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        //если отправлена форма
        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $seting = Seting::model()->findByPk(1);
            //если в поле defaultstatusUser таблицы $seting параметр false,то
            if ($seting->defaultstatusUser == 0) {
                // у юзера нет бана
                $model->ban = 1;
            } else {
                //иначе бан
                $model->ban = 0;
            }
            //загружаем в temp аватар
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
                if ($model->icon) {
                    //сохранить файл на сервере в каталог upload/avatars/thumbs под именем
                    $file = Yii::getPathOfAlias('webroot.upload.avatars.thumbs') . '/' . $filename;
                    $model->icon->saveAs($file);

//                       //Используем функции расширения CImageHandler;
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
                if ($seting->defaultstatusUser == 0) {
                    //если поле defaultstatusUser содержит значение 0, то выдаем сообщение об успешной регистрации
                    Yii::app()->user->setFlash('registration', 'Registration has already done successfully! You may login!');
                } else {
                    //иначе сообщение об ожидании подтверждения
                    Yii::app()->user->setFlash('registration', 'Wait confirm from admin!');
                }
            }
        }

        $this->render('registration', array(
            'model' => $model,
        ));
    }

    public function actionJson() {

        echo json_encode(array('time' => time()));


        Yii::app()->end();
    }

    public function actionIndex() {
        //создаем экземпляр класса CDbCriteria() для пагинации и сортировки
        $criteria = new CDbCriteria();
        //берем видимые статьи
        $criteria->compare('status', 1);
        $count = Page::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 5;
        //на странице быдет выводиться 5 статей
        $pages->applyLimit($criteria);
        $sort = new CSort('Page');
        $sort->defaultOrder = array('created' => CSort::SORT_DESC);
        //сортировка по дате по убыванию
        $sort->applyOrder($criteria);
        $models = Page::model()->findAll($criteria);

        $this->render('index', array(
            'models' => $models,
            'pages' => $pages,
        ));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionRules() {
        $this->render('rules');
    }

    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}
