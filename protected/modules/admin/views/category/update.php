<?php
/* @var $this CategoryController */
/* @var $model Category */


$this->menu = array(
    array('label' => 'List Category', 'url' => array('index')),
    array('label' => 'Create Category', 'url' => array('create')),
);
?>

<h1>Update Category <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>