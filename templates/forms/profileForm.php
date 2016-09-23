<?php
/** @var $this BaseController */
?>
<form class="navbar-form navbar-right" role="form" method="post" action="/logout">
    
    <span><span class="hidden-xs">Вы авторизованы как </span><?php echo ucfirst($this->getCurrentUser()->getPerson()->getFirstName()); ?></span>

    <img src="<?php echo  $this->getCurrentUser()->getImgUrl(); ?>" class="img-circle" style="max-width: 35px; max-height: 34px;">

    <button class="btn btn-sm btn-default">
        <small><b>Выйти</b></small>
        <span class="glyphicon glyphicon-log-out"></span>
    </button>

    <input name="flash" type="hidden" value="<?php echo $this->flash; ?>">

</form>

