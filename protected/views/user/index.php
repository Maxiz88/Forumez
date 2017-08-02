<div class="view">
    <h3><?php echo $model->username; ?></h3>
    <?php echo User::ava_thumb($model->avatar, 'page_avtr', 'thumbs'); ?>
    <br><br>
    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => TbHtml::GRID_TYPE_HOVER,
        'dataProvider' => $model->search(),
        'filter' => $model,
        'template' => "{items}",
        'columns' => array(
            array(
                'name' => 'username',
                'header' => 'Username',
                'filter' => FALSE,
            ),
            array(
                'name' => 'email',
                'header' => 'E-mail',
                'filter' => FALSE,
            ),
            array(
                'name' => 'ban',
                'header' => 'Status',
                'value' => '($data->ban==1)?"no ban":"ban"',
                'filter' => FALSE,
            ),
            array(
                'name' => 'role',
                'header' => 'Role',
                'value' => '($data->role==1)?"user":"admin"',
                'filter' => FALSE,
            ),
            array(
                'name' => 'created',
                'header' => 'Created',
                'value' => 'date("d.m.Y H:i", $data->created)',
                'filter' => FALSE,
            ),
        ),
    ));
    ?>

    <br> 
    <?php
    if ($model->id == Yii::app()->user->id) {
        echo TbHtml::submitButton('Update', array('color' => TbHtml::BUTTON_COLOR_PRIMARY,
            "submit" => array('update')));
    }
    ?>
</div>



