Enter your password:<br>
<?php
        echo CHtml::form();
        echo CHtml::passwordField('password');
        echo CHtml::submitButton('Submit');
        echo CHtml::endForm();
?>