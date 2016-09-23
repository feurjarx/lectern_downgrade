<?php
/**
 * Created by PhpStorm.
 * Date: 29.05.2016
 * Time: 20:38
 */
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--  vendor styles  -->
    <link href="<?php echo Utils::getHttpHost(); ?>/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo Utils::getHttpHost(); ?>/bower_components/components-font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!--  custom styles  -->
    <link href="/assets/css/about.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/animation-iframe.css" rel="stylesheet" type="text/css">

    <!--  vendor scripts  -->
    <script src="<?php echo Utils::getHttpHost(); ?>/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo Utils::getHttpHost(); ?>/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

</head>

<body class="font-effect-outline" style="overflow: hidden;">

    <div class="pull-left student-fa">
        <i class="fa fa-5x fa-graduation-cap" aria-hidden="true"></i>
    </div>
    <div class="pull-right employer-fa">
        <i class="fa fa-5x fa-briefcase" aria-hidden="true"></i>
    </div>

    <div class="content-effect">
        <div class="visible-effect" style="width: 625px">
            <p class="effect">Теперь найти работу
                <span class="glyphicon glyphicon-hand-right" style="vertical-align: middle"></span>
            </p>
            <ul class="effect" style="padding-left: 420px">
                <li>легко</li>
                <li>просто</li>
                <li>удобно</li>
                <li>быстро</li>
            </ul>
        </div>
    </div>

</body>
</html>


