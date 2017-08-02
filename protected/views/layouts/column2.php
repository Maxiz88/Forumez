<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="span-5 last">
    <div id="sidebar">

        <?php if (Yii::app()->user->isGuest) { ?>
            <h5 align="right">Please, follow the <i><?php echo CHtml::link('Registration', array('site/registration'));
            ?> or
                    <?php echo CHtml::link('Login', array('site/login'));
                    ?> <br>
                    to see more!
                </i></h5>
        <?php } ?>

        <?php if (!Yii::app()->user->isGuest) { ?> 

            <div align="center"><h3><?php echo TbHtml::b(Yii::app()->user->name); ?></h3></div>
            <hr>

            <?php
            $this->widget('bootstrap.widgets.TbNav', array(
                'type' => TbHtml::NAV_TYPE_PILLS,
                'stacked' => true,
                'items' => array(
                    array('label' => 'My account', 'url' => array('user/index', 'id' => Yii::app()->user->id)),
                    array('label' => 'My articles', 'url' => array('page/articles')),
                    array('label' => 'Add new article', 'url' => array('page/newarticle')),
                    array('label' => 'Logout', 'url' => array('site/logout')),
            )));
        }
        ?>
        <br><br><br><br>



    </div><!-- sidebar -->
    <br>


</div>
<div class="span-19">
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
</div>
<?php $this->endContent(); ?>