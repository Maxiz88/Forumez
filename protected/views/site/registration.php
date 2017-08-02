<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<?php if (Yii::app()->user->hasFlash('registration')): ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('registration'); ?>
    </div>

<?php else: ?>
    <h1>Registration</h1>
    <div class="form">

        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'user-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => true,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'username'); ?>
            <?php echo $form->textField($model, 'username', array('size' => 40, 'maxlength' => 20)); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>


        <div class="row">
            <?php echo $form->labelEx($model, 'email'); ?>
            <?php echo $form->textField($model, 'email', array('size' => 35, 'maxlength' => 35)); ?>
            <?php echo $form->error($model, 'email'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'password'); ?>
            <?php echo $form->passwordField($model, 'password', array('size' => 40, 'maxlength' => 20)); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'icon'); ?>
            <?php echo $model->ava_thumb($model->avatar,'page_avtr','thumbs'); ?>
        </div><br>
        <?php //Поле загрузки файла 
        echo TbHtml::activeFileField($model, 'icon');
        ?> 


        <div class="row">

            <div>
                <?php $this->widget('CCaptcha'); ?>
                <?php echo $form->labelEx($model, 'verifyCode'); ?>
    <?php echo $form->textField($model, 'verifyCode'); ?>
            </div>
            <div class="hint">Please enter the letters as they are shown in the image above.
                <br/>Letters are not case-sensitive.</div>
    <?php echo $form->error($model, 'verifyCode'); ?>
        </div>

        <div class="row buttons">
    <?php echo TbHtml::submitButton($model->isNewRecord ? 'Registration' : 'Save', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->
<?php endif; ?>