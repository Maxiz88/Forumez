<?php /* @var $this Controller */ ?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="language" content="en">

        <!-- blueprint CSS framework -->
        <?php Yii::app()->bootstrap->register(); ?>
        <script type="text/javascript" src="/js/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>

        <div class="container" id="page">

            <div id="header">
                <?php echo CHtml::image('/upload/header.jpg'); ?>
            </div><!-- header -->

            <div>
                <?php
                $this->widget('bootstrap.widgets.TbNavbar', array(
                    'color' => TbHtml::NAVBAR_COLOR_INVERSE,
                    'brandLabel' => TbHtml::i(TbHtml::b('ForumeZ')),
                    'collapse' => true,
                    'display' => null,
                    'items' => array(
                        array(
                            'class' => 'bootstrap.widgets.TbNav',
                            'type' => TbHtml::NAV_TYPE_TABS,
                            'htmlOptions' => array('class' => 'pull-right'),
                            'items' => array(
                                array('label' => 'Administration', 'url' => array('/admin/page'), 'visible' => Yii::app()->user->checkAccess('2')),
                                array('label' => 'Home', 'url' => array('/site/index')),
                                array('label' => 'Rules', 'url' => array('/site/rules')),
                                array('label' => 'Contacts', 'url' => array('/site/contact')),
                                array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                                array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest,),
                                array('label' => 'Registration', 'url' => array('/site/registration'), 'visible' => Yii::app()->user->isGuest)
                            )))
                ));
                ?>

            </div><!-- mainmenu -->
            <div align="center">
                <?php
                foreach (Category::model()->findAll('id', 'title') as $one) {
                    echo TbHtml::submitButton($one->title, array('color' => TbHtml::BUTTON_COLOR_SUCCESS,
                        "submit" => array('/page/index/' . $one->id)));
                }
                
                ?>
            </div>
            <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                ));
                ?><!-- breadcrumbs -->
            <?php endif ?>


            <?php echo $content; ?>

            <div class="clear"></div>

            <div id="footer">
                Copyright &copy; <?php echo date('Y'); ?> by Maxis.<br/>
                All Rights Reserved.<br/>
                <?php echo Yii::powered(); ?>

                <div class="contentbg counter">
                    <div class="block-title"> </div>
                </div>
            </div><!-- footer -->

        </div><!-- page -->

    </body>
</html>
