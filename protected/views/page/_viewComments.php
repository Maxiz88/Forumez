<?php
/* @var $this CommentsController */
/* @var $data Comments */
?>

<div class="comment">

    <?php
//    если юзер гость
    if ($data->guest) {
        ?>
<!--    выводим lable Гость-->
        <b><?php echo CHtml::encode($data->getAttributeLabel('guest')); ?>:</b>
<!--        выводим имя гостя-->
        <?php echo CHtml::encode($data->guest); ?>


        <?php
//        иначе
    } else {
        ?>
<!--выводим значок юзера, имя со ссылкой на его страницу-->
        <?php echo CHtml::link(TbHtml::icon(TbHtml::ICON_USER) . CHtml::encode($data->user->username), array('user/index', 'id' => $data->user->id));
        ?>

        <?php
    }
    ?>
<!--выводим значок даты и саму дату-->
    <?php echo TbHtml::icon(TbHtml::ICON_CALENDAR) . CHtml::encode(date('d.m.Y H:i', $data->created)); ?>
    <br>
<!--выводим содержимое коммента-->
    <b><?php echo CHtml::encode($data->content); ?></b>




</div>