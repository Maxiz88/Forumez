<?php
/* @var $this PageController */
/* @var $model Page */
/* @var $form CActiveForm */
//форма добавления статьи
?>

<h1><?php echo ($article->isNewRecord ? 'Create article' : 'Update article'); ?></h1>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'page-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => FALSE,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($article); ?>
    <!--Поле заглавие-->
    <div class="row">
        <?php echo $form->labelEx($article, 'title'); ?>
        <?php echo $form->textField($article, 'title', array('size' => 255, 'maxlength' => 255)); ?>
        <?php echo $form->error($article, 'title'); ?>
    </div>
    <!--Поле содержимого статьи-->
    <div class="row">
        <?php echo $form->labelEx($article, 'content'); ?>
        <?php echo $form->textArea($article, 'content', array('maxlength' => 100000));?>
        <?php echo $form->error($article, 'content'); ?>
    </div>
    <!--Поле категория-->
    <div class="row">
        <?php echo $form->labelEx($article, 'category_id'); ?>
        <?php echo $form->dropDownList($article, 'category_id', Category::all()); ?>
        <?php echo $form->error($article, 'category_id'); ?>
    </div>

    <!--картинка для статьи-->
    <div class="row">
        <?php echo $form->labelEx($article, 'icon'); ?>
        <?php echo $article->thumb($article->image, 'page_img', 'thumbs'); ?>
    </div><br>
    <?php
    //Если картинка для данной статьи загружена, предложить её удалить, отметив чекбокс 
    if (!empty($article->image)) {
        ?>

        <div class="row">
            <?php echo $form->labelEx($article, 'del_img'); ?> 
        <?php echo $form->checkBox($article, 'del_img'); ?>
        </div>     
    <?php } ?>

    <?php
    //Поле загрузки файла 
    echo TbHtml::activeFileField($article, 'icon');
    ?> 

    <br><br><br>

<?php echo TbHtml::submitButton($article->isNewRecord ? 'Create' : 'Save', array('color' => TbHtml::BUTTON_COLOR_SUCCESS)); ?>
<?php echo TbHtml::button('Cancel', array('color' => TbHtml::BUTTON_COLOR_WARNING, "submit" => array('articles'))); ?>



<?php $this->endWidget(); ?>

</div><!-- form -->