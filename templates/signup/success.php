<?php
/**
 * Created by PhpStorm.
 * Date: 02.05.2016
 * Time: 20:37
 */
?>

<div class="alert alert-success" style="padding: 10px; margin: 10px 0;">
    <strong>
        <span class="glyphicon glyphicon-ok"></span>
        <span class="sr-only">Успешно!</span>

        <?php
        if (isset($doneMsg) && $doneMsg):
            echo $doneMsg;
        endif;
        ?>

    </strong>
</div>
