<?php
/* @var $this CategoryController */
/* @var $model Category */


$this->menu=array(
	array('label'=>'Create Category', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#category-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Categories</h1>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => TbHtml::GRID_TYPE_HOVER,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		
		
		array(
            'name' => 'id',
            'header' => 'Id',
        ),
            array(
            'name' => 'title',
            'header' => 'Title',
        ),
            
            array(
			'class'=>'CButtonColumn',
                        'viewButtonUrl'=>'CHtml::normalizeUrl(array("/page/index/", "id"=>$data->id))'
		),
	),
)); ?>
