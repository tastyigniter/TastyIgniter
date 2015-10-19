<div class="col-md-12 reviews-list">
    <?php if ($reviews) { ?>
        <?php foreach ($reviews as $review) { ?>
            <div class="review-item">
                <blockquote>
                    <p class="review-text"><?php echo $review['text']; ?></p>
                    <div class="rating-row row">
                        <div class="col-sm-3">
                            <b>Quality:</b><div class="rating rating-star" data-score="<?php echo $review['quality']; ?>" data-readonly="true"></div>
                        </div>
                        <div class="col-sm-3">
                            <b>Delivery:</b><div class="rating rating-star" data-score="<?php echo $review['delivery']; ?>" data-readonly="true"></div>
                        </div>
                        <div class="col-sm-3">
                            <b>Service:</b><div class="rating rating-star" data-score="<?php echo $review['service']; ?>" data-readonly="true"></div>
                        </div>
                    </div>
                    <small>
                        <?php echo $review['author']; ?><?php echo lang('text_from'); ?>
                        <cite title="<?php echo lang('text_source'); ?>"><?php echo $review['city']; ?></cite><?php echo lang('text_on'); ?>
                        <?php echo $review['date']; ?>
                    </small>
                </blockquote>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p><?php echo lang('text_no_review'); ?></p>
    <?php } ?>
</div>

<div class="col-md-12 wrap-horizontal">
    <div class="pagination-bar text-right clearfix">
        <div class="links"><?php echo $pagination['links']; ?></div>
        <div class="info"><?php echo $pagination['info']; ?></div>
    </div>
</div>