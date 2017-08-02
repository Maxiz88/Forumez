

<h1>My articles</h1>
<!--это страница статей юзера-->
<!--количество статей юзера-->
<h5 align="right"><?php echo 'Total: ' . count($my_articles); ?></h5>

<?php foreach ($my_articles as $pag) { ?>
    <div class="page">
        <!--    выводим превью статьи со ссылкой на саму статью-->
        <?php echo CHtml::link($pag->thumb($pag->image, 'page_img', 'thumbs'), array('page/view', 'id' => $pag->id)); ?>
        <!--    выводим значок комментов и количество комментов-->
        <p align="right"><?php echo TbHtml::icon(TbHtml::ICON_COMMENT) . $pag->commentsCount; ?></p>
        <!--выводим заглавие статей со ссылкой на саму статью-->
        <h3><?php echo CHtml::link($pag->title, array('page/view', 'id' => $pag->id)); ?> </h3><br>
        <!--выводим "читать далее" со ссылкой на статью-->
        <?php echo CHtml::link('Reed more...', array('page/view', 'id' => $pag->id)); ?><br>

        <div align='right'><h5>
                <!--        выводим дату-->
                <?php echo date('d.m.Y H:i', $pag->created); ?>
            </h5></div>
    </div>
<?php } ?>
<!--выводим пагинацию страниц-->
<?php
$this->widget('CLinkPager', array(
    'pages' => $pages,
))
?>



