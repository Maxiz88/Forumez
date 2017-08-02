<?php

class PageController extends Controller {

    public function actions() {
        return array(
            // инициализируем каптчу для страницы регистрации
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function actionIndex($id) {
        $criteria = new CDbCriteria();
        //создаем экземпляр класса CDbCriteria() для пагинации и сортировки статей в каждой категории
        $criteria->condition = 'category_id=:category_id';
        $criteria->params = array(':category_id' => $id);
        //учитываться будут статьи со статусом "видимые" со значением true
        $criteria->compare('status', 1);
        $count = Page::model()->count($criteria);
        //создаем экземпляр класса для пагинации страниц
        $pages = new CPagination($count);
        //на странице будет выводиться по 5 статей
        $pages->pageSize = 5;
        $pages->applyLimit($criteria);
        //создаем экземпляр класса для сортировки статей
        $sort = new CSort('Page');
        //сортировка статей по дате создания
        $sort->defaultOrder = array('created' => CSort::SORT_DESC);
        $sort->applyOrder($criteria);
        $models = Page:: model()->findAll($criteria);
        $category = Category:: model()->findByPk($id);

        $this->render('index', array('models' => $models, 'category' => $category, 'pages' => $pages));
    }

    public function actionArticles() {
        //создаем экземпляр класса CDbCriteria() для пагинации и сортировки статей юзера
        $criteria = new CDbCriteria();
        $criteria->condition = 'user_id=:user_id';
        $criteria->params = array(':user_id' => Yii::app()->user->id);
        //учитываться будут статьи со статусом "видимые" со значением true
        $criteria->compare('status', 1);
        $count = Page::model()->count($criteria);
        //создаем экземпляр класса для пагинации страниц
        $pages = new CPagination($count);
        //на странице будет выводиться по 5 статей
        $pages->pageSize = 5;
        $pages->applyLimit($criteria);
        //создаем экземпляр класса для сортировки статей
        $sort = new CSort('Page');
        //сортировка статей по дате создания
        $sort->defaultOrder = array('created' => CSort::SORT_DESC);
        $sort->applyOrder($criteria);
        $my_articles = Page:: model()->findAll($criteria);

        $this->render('articles', array('my_articles' => $my_articles, 'pages' => $pages));
    }

    public function actionNewArticle() {
        $article = new Page;
        //создаем экземпляр модели статьи
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Page'])) {

            $article->attributes = $_POST['Page'];
            //user_id из таблицы Page соответствует id юзера в данной сессии
            $article->user_id = Yii::app()->user->id;
            //загружаем файл
            $article->icon = CUploadedFile::getInstance($article, 'icon');
            if ($article->icon) {
                //получаем имя загруженного файла из папки temp
                $sourcePath = pathinfo($article->icon->getName());
                //даем имя файлу
                $filename = md5(microtime() . rand(0, 9999)) . '.' . $sourcePath['extension'];
                //присваиваем это имя свойству image
                $article->image = $filename;
            }
            $seting = Seting::model()->findByPk(1);
            //если в таблице Seting поле defaultstatusUser по умолчанию false,то статья со статусом true (видимая)
            if ($seting->defaultstatusUser == 0) {
                $article->status = 1;
            } else {
                //иначе невидимая
                $article->status = 0;
            }
            //сохраняем все поля статьи
            if ($article->save()) {
                //если поле загрузки файла не было пустым, то
                if ($article->icon) {
                    //сохранить файл на сервере в каталог upload/images под именем
                    $file = Yii::getPathOfAlias('webroot.upload.images') . '/' . $filename;
                    //сохраняем файл в атрибут icon, а в базу в поле image запишется имя с расширением  
                    $article->icon->saveAs($file);

//                       //Используем функции расширения CImageHandler;
                    $ih = new CImageHandler(); //Инициализация
                    Yii::app()->ih
                            ->load($file)//Загрузка оригинала картинки
                            ->adaptivethumb('150', '150')//создание превьюшки шириной 150px
                            ->save(Yii::getPathOfAlias('webroot.upload.images.thumbs') . '/' . $filename)//Сохранение превьюшки в папку thumbs
                            ->reload()//Перезагрузка оригинала картинки
                            ->adaptivethumb('70', '70')
                            ->save(Yii::getPathOfAlias('webroot.upload.images.thumbs_small') . '/' . $filename)
                            ->reload()
                            ->adaptivethumb('200', '200')
                            ->save(Yii::getPathOfAlias('webroot.upload.images') . '/' . $filename)
                    ;
                }
                $this->redirect(array('articles'));
            }
        }

        $this->render('newarticle', array(
            'article' => $article,
        ));
    }

    public function actionUpdateArticle($id) {
        $article = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['Page'])) {

            $article->attributes = $_POST['Page'];
            $article->user_id = Yii::app()->user->id;
            $article->icon = CUploadedFile::getInstance($article, 'icon');
            if ($article->icon) {
                $sourcePath = pathinfo($article->icon->getName());
                $filename = $article->id . '.' . $sourcePath['extension'];
                $article->image = $filename;
            }
            if ($article->save()) {
                //Если отмечен чекбокс «удалить файл»
                if ($article->del_img) {
                    if (!empty($image)) {
                        //если картинка не пустая, то удаляем ее и все её thumbs
                        unlink('/upload/images/thumbs/' . $filename);
                        unlink('/upload/images/thumbs_small/' . $filename);
                        unlink('/upload/images/' . $filename);
                        $article->image = '';
                    }
                }
                //Если поле загрузки файла не было пустым, то
                if ($article->icon) {
                    //сохранить файл на сервере в каталог upload/images под именем
                    $file = Yii::getPathOfAlias('webroot.upload.images') . '/' . $filename;
                    $article->icon->saveAs($file);

                    //Используем функции расширения CImageHandler;
                    $ih = new CImageHandler(); //Инициализация
                    Yii::app()->ih
                            ->load($file)//Загрузка оригинала картинки
                            ->adaptivethumb('150', '150')//Создание превьюшки шириной 150px
                            ->save(Yii::getPathOfAlias('webroot.upload.images.thumbs') . '/' . $filename)//Сохранение превьюшки в папку thumbs
                            ->reload()//Перезагрузка оригинала картинки
                            ->adaptivethumb('70', '70')
                            ->save(Yii::getPathOfAlias('webroot.upload.images.thumbs_small') . '/' . $filename)
                            ->reload()
                            ->adaptivethumb('200', '200')
                            ->save(Yii::getPathOfAlias('webroot.upload.images') . '/' . $filename)
                    ;
                }
                $this->redirect(array('articles'));
            }
        }

        $this->render('updatearticle', array(
            'article' => $article,
        ));
    }

    public function actionView($id) {
        //выводим на станицу статью, на которую был осуществлен переход
        $model = Page:: model()->findByPk($id);

        //выводим комменты
        $newComments = new Comments;
        if (Yii::app()->user->isGuest) {
            //если юзер гость, то включаем сценарий "Гость"
            $newComments->scenario = 'Guest';
        }
        if (isset($_POST['Comments'])) {
            $seting = Seting::model()->findByPk(1);
            $newComments->attributes = $_POST['Comments'];
            //id статьи равняется полю page_id из табл Comments
            $newComments->page_id = $model->id;
            //если поле defaultstatusComment из табл Seting равно false, то комментарий  будет невидимый
            if ($seting->defaultstatusComment == 0) {
                $newComments->status = 0;
            } else {
                //иначе видимый
                $newComments->status = 1;
            }
            //сохраняем коммент
            if ($newComments->save()) {
                //если поле defaultstatusComment из табл Seting равно false, то 
                if ($seting->defaultstatusComment == 0) {
                    //выводим сообщение с просьбой ожидать активации
                    Yii::app()->user->setFlash('comment', 'Wait confirmimation of your comment from admin!');
                } else {
                    //иначе сообщение о удачной публикации
                    Yii::app()->user->setFlash('comment', 'Your comment has been published!');
                }
                $this->refresh();
            }
        }



        $this->render('view', array('model' => $model, 'newComments' => $newComments));
    }

    public function actionDelete($id) {
        //если отправлен запрос на удаление данной статьи
        if (Yii::app()->request->isPostRequest) {
            //удаляем
            $this->loadModel($id)->delete();
            //перенаправляем на "Мои статьи"
            $this->redirect(array('articles'));
        } else
            throw new CHttpException(400, 'Плохой запрос какой-то…');
    }

    public function loadModel($id) {

        //загрузка статьи по id
        $model = Page::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
