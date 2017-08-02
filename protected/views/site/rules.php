<div class="view">
    <h3 align="center"><u><?php echo TbHtml::em('The rules of the ForumeZ', array('color' => TbHtml::TEXT_COLOR_INFO)); ?></u></h3>

    <?php echo TbHtml::b('If you are guest'); ?>

    <li>
        You can reed the articles of all users and all categories, see theirs profiles, also can write comments for all articles 
        only as a guest with entering captcha;
    </li>
    <li>
        You can`t create the articles, upload photos or other content. You can get right for all after registration;
    </li>
    <br>
    <?php echo TbHtml::b('If you are user'); ?>

    <li>
        You may login. If you are authorized user, you can reed the articles of all users and all categories, see theirs profiles, 
        also can write comments for all articles as a user. You can create the articles and delete them, upload photos for your 
        articles, also you can update your own information of your account and upload avatar, can see your own articles and 
        comments, can get and send massages;
    </li>
    <li>
        You can`t update, delete the articles of the other users, can`t delete the categories and also can`t update, delete own 
        information of the other users. Any try to do it follow the ban to your account!;
    </li>

    <br>
    <?php echo TbHtml::b('If you are admin'); ?>

    <li>
        You may login. You can all rights that simple user has. Also you have administration functions: create categories, users,
        assign the roles for users, assign the status for articles, comments. For security of this site or other users you can 
        assign ban for users or delete users, if for their cause security of this site was threatened.
    </li>
</div>