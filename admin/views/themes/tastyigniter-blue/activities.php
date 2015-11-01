<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
        <form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
            <?php if ($activities) { ?>
                <ul class="timeline activities-list-group">
                    <?php foreach ($activities as $date_added => $activities) { ?>
                        <li class="time-label">
                            <span><?php echo $date_added; ?></span>
                        </li>
                        <?php foreach ($activities as $activity) { ?>
                            <li class="timeline-item <?php echo $activity['status']; ?>">
                                <time class="timeline-time" datetime="">
                                    <span><?php echo $activity['time']; ?></span>
                                    <span><?php echo $activity['time_elapsed']; ?></span>
                                </time>
                                <div class="timeline-icon bg-primary"><i class="<?php echo $activity['icon']; ?>"></i></div>
                                <div class="timeline-body"><?php echo $activity['message']; ?></div>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p><?php echo lang('text_empty'); ?></p>
            <?php } ?>
        </form>

        <div class="panel">
            <div class="pagination-bar clearfix">
                <div class="links"><?php echo $pagination['links']; ?></div>
                <div class="info"><?php echo $pagination['info']; ?></div>
            </div>
        </div>
	</div>
</div>
<?php echo get_footer(); ?>