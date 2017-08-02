<!--форма отправки комментариев-->
<div class="form">
<!--подключаем виджет bootstrap-->
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'comments-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation'=>FALSE,
)); ?>

    
    <?php echo $form->errorSummary($model); ?>

<!--    поле комментария-->
    <div class="row">
        <?php echo $form->labelEx($model,'content'); ?>
        <?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'content'); ?>
    </div>

       <?php 
//       если юзер гость-- выдаем ему поле для ввода имени
       if(Yii::app()->user->isGuest):
       ?>

    <div class="row">
        <?php echo $form->labelEx($model,'guest'); ?>
        <?php echo $form->textField($model,'guest',array('size'=>15,'maxlength'=>15)); ?>
        <?php echo $form->error($model,'guest'); ?>
    </div>
<!--проверяем валидность каптчи-->
        <?php if(CCaptcha::checkRequirements()): ?>

    <div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha', array('captchaAction' => '/page/captcha')); ?><br/>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div><br/>
		<div class="hint">Please enter  the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
		<?php echo $form->error($model,'verifyCode'); ?>
	</div>
        <?php endif; ?>
        <?php endif; ?>
    
    <div class="row buttons">
        <!--        кнопка отправить-->
        <?php echo TbHtml::submitButton('Send', array(
                                        'color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
    </div>

<?php $this->endWidget(); ?>

</div>
