<?php
/* @var $this PageController */
/* @var $model Page */


$this->menu = array(
    array('label' => 'List Page', 'url' => array('index')),
    array('label' => 'Create Page', 'url' => array('create')),
    array('label' => 'View Page', 'url' => array('/page/view', 'id' => $model->id)),
);
?>

<h1>Update Page <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>