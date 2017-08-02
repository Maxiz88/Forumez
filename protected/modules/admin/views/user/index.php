<?php
/* @var $this UserController */
/* @var $model User */



$this->menu = array(
    array('label' => 'Create User', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Users</h1>



<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<br><br>
<?php
echo CHtml::form();
echo CHtml::submitButton('Ban off', array('name' => 'noban'));
echo CHtml::submitButton('Ban', array('name' => 'ban'));
echo '<br><br>';
echo CHtml::submitButton('Admin', array('name' => 'admin'));
echo CHtml::submitButton('Not admin', array('name' => 'notadmin'));
?>
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => TbHtml::GRID_TYPE_HOVER,
    'id' => 'user-grid',
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
            'id' => 'User_id'
        ),
        'username',
        'password',
        'email',
        array(
            'name' => 'avatar',
            'type' => 'image',
            //если файла картинки нет, 
            // то отображается файл noeventimage.png
            // Значение value обрабатывается функцией eval() поэтому 
            // одинарные ковычки.
            'value' => '(!empty($data->avatar)) ? 
                Yii::app()->baseUrl."/upload/avatars/thumbs_small/".$data->avatar : 
                Yii::app()->baseUrl."/upload/avatars/noavatar_small.png"',
            'filter' => '',
            'headerHtmlOptions' => array('width' => '75 px'),
        ),
        'created' => array(
            'name' => 'created',
            'value' => 'date("d.m.Y H:i", $data->created)',
            'filter' => FALSE,
        ),
        'ban' => array(
            'name' => 'ban',
            'value' => '($data->ban==1)?" ":"ban"',
            'filter' => array(0 => 'yes', 1 => 'no'),
        ),
        'role' => array(
            'name' => 'role',
            'value' => '($data->role==1)?"User":"Admin"',
            'filter' => array(2 => 'Admin', 1 => 'User'),
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
<?php echo CHtml::endform(); ?>