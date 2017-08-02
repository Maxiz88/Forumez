<?php
/* @var $this UserController */
/* @var $model User */


$this->menu = array(
    array('label' => 'List User', 'url' => array('index')),
    array('label' => 'Update User', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete User', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<h1>View User #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'username',
        'password',
        'created' => array(
            'name' => 'created',
            'value' => date('d.m.Y H:i', $model->created),
        ),
        'ban' => array(
            'name' => 'ban',
            'value' => ($model->ban == 1) ? " " : "ban",
        ),
        'role' => array(
            'name' => 'role',
            'value' => ($model->role == 1) ? "User" : "Admin",
        ),
        'email',
    ),
));
?>
