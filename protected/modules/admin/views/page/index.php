<?php
/* @var $this PageController */
/* @var $model Page */



$this->menu = array(
    array('label' => 'Create Article', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#page-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Articles</h1>



<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
echo CHtml::form();
echo '<br><br>';
echo CHtml::submitButton('visible', array('name' => 'visible'));
echo CHtml::submitButton('hidden', array('name' => 'hidden'));
?>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => TbHtml::GRID_TYPE_HOVER,
    'id' => 'page-grid',
    'selectableRows' => 5,
    'dataProvider' => $model->search(),
    'template' => "{items}",
    'filter' => $model,
    'columns' => array(
        'id' => array(
            'name' => 'id',
            'headerHtmlOptions' => array('width' => 30),
        ),
        'title' => array(
            'name' => 'title',
            'value' => '($data->title)',
            'filter' => FALSE,
        ),
        array(
            'name' => 'image',
            'type' => 'image',
            //если файла картинки нет, 
            // то отображается файл noeventimage.png
            // Значение value обрабатывается функцией eval() поэтому 
            // одинарные ковычки.
            'value' => '(!empty($data->image)) ? 
        Yii::app()->baseUrl."/upload/images/thumbs_small/".$data->image : 
	Yii::app()->baseUrl."/upload/images/noimage_small.png"',
            'filter' => '',
            'headerHtmlOptions' => array('width' => '74px'),
        ),
        'created' => array(
            'name' => 'created',
            'value' => 'date("d.m.Y H:i", $data->created)',
            'filter' => FALSE,
        ),
        array(
            'class' => 'CCheckBoxColumn',
            'id' => 'Page_id'
        ),
        'status' => array(
            'name' => 'status',
            'value' => '($data->status==1)?"visible":"hidden"',
            'filter' => array(0 => 'hidden', 1 => 'visible')
        ),
        'category_id' => array(
            'name' => 'category_id',
            'value' => '$data->category->title',
            'filter' => Category::all(),
        ),
        array(
            'class' => 'CButtonColumn',
            'viewButtonUrl' => 'CHtml::normalizeUrl(array("/page/view", "id"=>$data->id))'
        ),
    ),
));
?>

<?php echo CHtml::endform(); ?>