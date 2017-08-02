
/*создали панель навигации для авторизированного юзера*/
<ul>
    <li><?php echo CHtml::link('My account', array('user/index')); ?></li>
    <li><?php echo CHtml::link('My articles', array('page/articles')); ?></li>
    <li><?php echo CHtml::link('Add new article', array('page/newarticle')); ?></li>
    <li><?php echo CHtml::link('Logout', array('site/logout')); ?></li>
</ul>
