<?php
/* @var $this PageController */
/* @var $model Page */

$this->menu = array(
    array('label' => 'Articles list', 'url' => array('index'))
);
?>

<h1>Create article</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>