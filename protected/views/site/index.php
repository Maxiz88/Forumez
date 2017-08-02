<?php
//главная страница со статьями
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>
<br>
<?php foreach ($models as $add) { ?>
    <div class="page">

    <?php echo CHtml::link($add->thumb($add->image, 'page_img', 'thumbs'), array('page/view', 'id' => $add->id)); ?>
        <p align="right"><?php echo TbHtml::icon(TbHtml::ICON_COMMENT) . $add->commentsCount; ?></p>      
        <h3><?php echo CHtml::link($add->title, array('page/view', 'id' => $add->id)); ?> </h3><br>
            <?php echo CHtml::link('Reed more...', array('page/view', 'id' => $add->id)); ?><br>
        <p align="right"><?php
            echo CHtml::link(TbHtml::icon(TbHtml::ICON_USER) . TbHtml::b($add->user->username), array('user/index', 'id' => $add->user->id));
            echo ' ' . TbHtml::icon(TbHtml::ICON_CALENDAR) .
            date('d.m.Y H:i:s', $add->created);
            ?></p> 
    </div>
<?php } ?>
<?php
$this->widget('CLinkPager', array(
    'pages' => $pages,
))
?>
