<?php
/* @var $this CommentsController */
/* @var $model Comments */

$this->menu = array(
    array('label' => 'List Comments', 'url' => array('index')),
    array('label' => 'Delete Comments', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
);
?>

<h1>View Comments #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'content',
        'page_id' => array(
            'name' => 'page_id',
            'value' => $model->page->title,
        ),
        'created' => array(
            'name' => 'created',
            'value' => date("d.m.y H:i", $model->created),
        ),
        'user_id' => array(
            'name' => 'user_id',
            'value' => $model->user->username,
        ),
        'guest',
    ),
));
?>
