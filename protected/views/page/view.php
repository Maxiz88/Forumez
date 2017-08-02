<?php
//    страница статьи
/* @var $this PageController */
/* @var $model Page */
$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links' => array(
        'Category' => '#',
        $model->category->title => array('index', 'id' => $model->category_id),
        $model->title,
    ),
));
?>
<div class="view">
    <!--    выводим аву юзера-->
    <?php echo User::ava_thumb($model->user->avatar, 'page_avtr', ''); ?>
    <!--выводим имя юзера, его имя со ссылкой на его страницу-->
    <br><?php echo CHtml::link(TbHtml::b($model->user->username), array('user/index', 'id' => $model->user->id)); ?><br>
    <!--        выводим дату-->
    <?php echo date('d.m.Y H:i:s', $model->created); ?><br>
    <!--    выводим значок комментов и количество комментов-->
    <?php echo TbHtml::icon(TbHtml::ICON_COMMENT) . $model->commentsCount; ?>
    <hr>
    <!--    выводим превью статьи-->
    <?php echo $model->thumb($model->image, 'page_img', ''); ?>
    <!--    выводим заглавие статьи -->
    <?php echo '<h3>' . $model->title . '</h3>'; ?>
    <!--    выводим содержимое статьи -->
    <?php echo $model->content; ?>
    <div align="right">    
        <!--        если id юзера из модели Page совпадает с d юзера данной сессии, то выдаем кнопки обновить и удалить свои статьи-->
        <?php if ($model->user_id == Yii::app()->user->id) { ?>
            <?php echo TbHtml::button('Update', array('color' => TbHtml::BUTTON_COLOR_SUCCESS, "submit" => array('updatearticle', 'id' => $model->id))); ?>
            <?php echo TbHtml::button('Delete', array('color' => TbHtml::BUTTON_COLOR_DANGER, "submit" => array('delete', 'id' => $model->id),
                'confirm' => 'Do you want to delete your article and all comments?'));
            ?>

<?php } ?>
    </div>

</div>

<br>

<h4><?php echo TbHtml::em('Comments', array('color' => TbHtml::TEXT_COLOR_INFO)); ?></h4>
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => Comments::All($model->id),
    'itemView' => '_viewComments',
));
?>

    <?php if (Yii::app()->user->hasFlash('comment')): ?>

    <div class="flash-success">
    <?php echo Yii::app()->user->getFlash('comment'); ?>
    </div>

<?php else: ?>

    <?php
    echo $this->renderPartial('newComments', array('model' => $newComments));
    ?>
<?php endif; ?>

