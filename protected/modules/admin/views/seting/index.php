
<h1>Setings</h1>

<?php if (Yii::app()->user->hasFlash('seting')): ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('seting'); ?>
    </div>
<?php endif; ?>


<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'seting-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>


        <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'defaultstatusComment'); ?>
<?php echo $form->checkBox($model, 'defaultstatusComment'); ?>
<?php echo $form->error($model, 'defaultstatusComment'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'defaultstatusUser'); ?>
<?php echo $form->checkBox($model, 'defaultstatusUser'); ?>
<?php echo $form->error($model, 'defaultstatusUser'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton('Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->