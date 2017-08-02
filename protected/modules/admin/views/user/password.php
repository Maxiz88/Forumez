<?php
$this->menu = array(
    array('label' => 'List User', 'url' => array('index')),
    array('label' => 'Create User', 'url' => array('create')),
    array('label' => 'View User', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Change User', 'url' => array('update', 'id' => $model->id)),
);
?>
Enter your password:<br>
<?php
echo CHtml::form();
echo CHtml::passwordField('password');
echo CHtml::submitButton('Submit');
echo CHtml::endForm();
?>
