<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
        <form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
            <?php if ($activities) { ?>
                <ul class="timeline activities-list-group">
                    <?php foreach ($activities as $date_added => $activities) { ?>
                        <li class="time-label">
                            <span class="bg-danger"><?php echo $date_added; ?></span>
                        </li>
                        <?php foreach ($activities as $activity) { ?>
                            <li class="timeline-item <?php echo $activity['status']; ?>">
                                <div class="timeline-badge bg-primary"><i class="<?php echo $activity['icon']; ?>"></i></div>
                                <div class="timeline-body">
                                    <h3 class="timeline-header">
                                        <?php echo $activity['message']; ?>
                                        <span class="time text-muted"><?php echo $activity['time']; ?></span>
                                    </h3>
                                </div>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p><?php echo $text_empty; ?></p>
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