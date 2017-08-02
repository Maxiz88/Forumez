<?php

Yii::import('zii.widgets.CPortlet');

class UserMenu extends CPortlet {

    public function init() {
    //инициализируем пользователя
        $this->title = CHtml::encode(Yii::app()->user->name);
        parent::init();
    }

    protected function renderContent() {
    //подвязываем меню юзера в components/views
        $this->render('userMenu');
    }

}
