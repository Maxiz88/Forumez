<?php
/* @var $this CommentsController */
/* @var $model Comments */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#comments-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Comments</h1>



<?php 
echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); 
?>
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
    'id' => 'comments-grid',
    'selectableRows' => 2,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id' => array(
            'name' => 'id',
            'headerHtmlOptions' => array('width' => 30),
        ),
        array(
            'class' => 'CCheckBoxColumn',
            'id' => 'Comments_id'
        ),
        'status' => array(
            'name' => 'status',
            'value' => '($data->status==1)?"visible":"hidden"',
            'filter' => array(0 => 'hidden', 1 => 'visible')
        ),
        'content',
        'page.title',
        'created' => array(
            'name' => 'created',
            'value' => 'date("d.m.Y H:i", $data->created)',
            'filter' => FALSE,
        ),
        'user.username',
        'guest',
        array(
            'class' => 'CButtonColumn',
            'updateButtonOptions' => array('style' => 'display:none')
        ),
    ),
));
?>
<?php echo CHtml::endform(); ?>