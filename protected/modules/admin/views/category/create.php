<?php
/* @var $this CategoryController */
/* @var $model Category */



$this->menu = array(
    array('label' => 'Categories list', 'url' => array('index')),
);
?>

<h1>Create Category</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>