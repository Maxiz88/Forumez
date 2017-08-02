<?php
/* @var $this PageController */
//это страница статей в категориях
$this->widget('bootstrap.widgets.TbBreadcrumb', array(
    'links' => array(
        'Category' => '#',
        $category->title,
    ),
));
?>

<?php foreach ($models as $one) { ?>
    <div class="page">
        <!--    выводим превью статьи со ссылкой на саму статью-->
        <?php echo TbHtml::link($one->thumb($one->image, 'page_img', 'thumbs'), array('page/view', 'id' => $one->id)); ?>
        <!--    выводим значок комментов и количество комментов-->
        <p align="right"><?php echo TbHtml::icon(TbHtml::ICON_COMMENT) . $one->commentsCount; ?></p>    
        <!--выводим заглавие статей со ссылкой на саму статью-->
        <h3><?php echo TbHtml::link($one->title, array('page/view', 'id' => $one->id)); ?> </h3><br>
        <!--выводим "читать далее" со ссылкой на статью-->
        <?php echo TbHtml::link('Reed more...', array('page/view', 'id' => $one->id)); ?><br>
        <!--выводим значок юзера, его имя со ссылкой на его страницу-->
        <p align="right"><?php echo TbHtml::link(TbHtml::icon(TbHtml::ICON_USER) . TbHtml::b($one->user->username), array('user/index', 'id' => $one->user->id));
    ?> 
            <!--        выводим дату-->
            <?php echo ' ' . TbHtml::icon(TbHtml::ICON_CALENDAR) . date('d.m.Y H:i:s', $one->created); ?></p>
    </div>
<?php } ?>
<!--выводим пагинацию страниц-->
<?php
$this->widget('CLinkPager', array(
    'pages' => $pages,
))
?>
<!--если нет статей-->
<?php
if (!$models)
    echo 'This category haven`t articles!';
?>
