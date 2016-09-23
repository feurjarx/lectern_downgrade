<?php
/**
 * Created by PhpStorm.
 * Date: 18.05.2016
 * Time: 21:23
 */
use Entity\Review;

/** @var BaseController $this */
/** @var Review $review */

$colors = array('danger', 'default', 'warning', 'primary', 'success');
?>

<?php if (isset($review) and $review instanceof Review and $review): ?>

    <div class="panel panel-<?php echo $colors[$review->getRating() - 1] ?> margin-none-xs">
        <div class="flexbox panel-heading">
            <h3 class="panel-title">
                <b><?php echo $review->getUser()->getPerson()->getFullName(); ?></b>
                <span><?php echo $review->getUser()->getPerson()->getGender() === 'man' ? 'оставил' : 'оставила' ?> отзыв <?php echo date('d/m/Y', $review->getPublishedAt()); ?></span>
            </h3>
            <div class="rating" id="jRate-<?php echo $review->getId() ?>"></div>
        </div>
        <div class="flexbox panel-body">
            <div class="col-lg-4 col-md-4 col-xs-4 thumbnail margin-none">
                <img src="<?php echo $review->getUser()->getImgUrl(); ?>" alt="<?php echo $review->getUser()->getPerson()->getFullName(); ?>">
            </div>
            <div class="col-lg-8 col-md-8 col-xs-8 popover popover-review right">
                <div class="arrow"></div>
                <h3 class="popover-title"><b><?php echo $review->getTitle(); ?></b></h3>
                <div class="popover-content dot-ellipsis dot-resize-update"><?php echo $review->getDescription(); ?></div>
            </div>
        </div>

        <textarea placeholder="" class="hidden full-description"><?php echo $review->getDescription(); ?></textarea>
    </div>

    <script>

        $('#jRate-<?php echo $review->getId() ?>').ready(function () {

            $('#jRate-<?php echo $review->getId() ?>').jRate({
                startColor: 'yellow',
                endColor: 'orange',
                readOnly: true,
                rating: <?php echo $review->getRating() ?>,
                min: 0,
                max: 5,
                minSelected: 1,
                strokeWidth: '20px',
                strokeColor: '#34495e'
            });
        });
    </script>
<?php endif; ?>