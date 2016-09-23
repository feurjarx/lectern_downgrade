<?php
/**
 * Created by PhpStorm.
 * Date: 02.05.2016
 * Time: 20:37
 */
?>

<div class="alert alert-danger" style="padding: 10px; margin: 10px 0;">
    <strong>
        <span class="glyphicon glyphicon-exclamation-sign"></span>
        <span class="sr-only">Ошибка!</span>

        <?php
            if (isset($errMsg) && $errMsg):
                echo $errMsg;
            endif;
        ?>

    </strong>
</div>