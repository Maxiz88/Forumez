<?php

class SetingController extends Controller
{
    
        public function filters()
	{
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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'roles'=>array('2'),
			),
			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
        public function actionIndex()
	{
		$model=  Seting::model()->findByPk(1);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Seting']))
		{
			$model->attributes=$_POST['Seting'];
			if($model->save())
                        {
                        Yii::app()->user->setFlash('seting','Save was successful!');

                        }
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
}