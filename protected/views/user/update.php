

<h1>Update account <?php echo Yii::app()->user->name; ?></h1>
<h4>Fill in the fields:</h4>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'user-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>


    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username', array('size' => 40, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password', array('size' => 40, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email', array('size' => 40, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'icon'); ?>
        <?php echo $model->ava_thumb($model->avatar, 'page_avtr', 'thumbs'); ?>
    </div><br>
    <?php
    //Если картинка для данного товара загружена, предложить её удалить, отметив чекбокс 
    if (!empty($model->avatar)) {
        ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'del_avatar'); ?> 
        <?php echo $form->checkBox($model, 'del_avatar'); ?>
        </div>     
    <?php } ?>
    <?php
    //Поле загрузки файла 
    echo TbHtml::activeFileField($model, 'icon');
    ?> 

    <br>

<?php echo TbHtml::submitButton('Save', array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
    <?php echo TbHtml::button('Cancel', array('color' => TbHtml::BUTTON_COLOR_WARNING, "submit" => array('index'))); ?>


<?php $this->endWidget(); ?>

</div><!-- form -->

