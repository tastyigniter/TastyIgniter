<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
        <form role="form" id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
            <?php if ($notifications) { ?>
                <ul class="timeline notifications-list-group">
                    <?php foreach ($notifications as $date_added => $notification_list) { ?>
                        <li class="time-label">
                            <span class="bg-danger"><?php echo mdate('%d %M %Y', strtotime($date_added)); ?></span>
                        </li>
                        <?php foreach ($notification_list as $notification) { ?>
                            <li class="notification-item <?php echo $notification['status']; ?>">
                                <div class="timeline-badge bg-primary"><i class="<?php echo $notification['icon']; ?>"></i></div>
                                <div class="timeline-item">
                                    <h3 class="timeline-header"><?php echo $notification['message']; ?></h3>
                                    <span class="time text-muted"><?php echo $notification['time']; ?>&nbsp;&nbsp;<i class="fa fa-clock-o"></i></span>
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