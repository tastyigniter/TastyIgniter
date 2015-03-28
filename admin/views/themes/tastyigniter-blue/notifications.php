<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Notifications</h3>
			</div>

			<form role="form" id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
				<?php if ($notifications) { ?>
					<ul class="list-group notifications-list-group">
						<?php foreach ($notifications as $notification) { ?>
							<li class="list-group-item notification-item <?php echo $notification['status']; ?>">
								<div class="row">
									<div class="col-xs-7 col-sm-9">
										<span class="<?php echo $notification['icon']; ?>"></span>&nbsp;&nbsp;
										<span class="message"><?php echo $notification['message']; ?></span>
									</div>
									<div class="col-xs-4 col-sm-2">
										<span class="time text-muted">
											<!--<span class="fa fa-clock-o"></span>&nbsp;&nbsp;--><?php echo $notification['time']; ?>
										</span>
									</div>
									<div class="col-xs-1 col-sm-1 text-right">
										<span class="action">
											<?php if ($notification['status'] === 'unread') { ?>
												<span class="fa fa-square"></span>
											<?php } else { ?>
												<span class="fa fa-square-o"></span>
											<?php } ?>
										</span>
									</div>
								</div>
							</li>
						<?php } ?>
					</ul>
				<?php } else { ?>
					<p><?php echo $text_empty; ?></p>
				<?php } ?>
			</form>

			<div class="pagination-bar clearfix">
				<div class="links"><?php echo $pagination['links']; ?></div>
				<div class="info"><?php echo $pagination['info']; ?></div>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>