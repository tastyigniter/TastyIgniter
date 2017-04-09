<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>

<?php if ($this->alert->get()) { ?>
	<div id="notification">
		<div class="container top-spacing-20">
			<div class="row">
				<div class="col-md-12">
					<?php echo $this->alert->display(); ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<div id="page-content">
	<div class="container top-spacing-20">
		<div class="row">
			<?php echo get_partial('content_left'); ?>
			<?php
				if (partial_exists('content_left') AND partial_exists('content_right')) {
					$class = "col-sm-6 col-md-6";
				} else if (partial_exists('content_left') OR partial_exists('content_right')) {
					$class = "col-sm-9 col-md-9";
				} else {
					$class = "col-md-12";
				}
			?>

			<div class="content-wrap <?php echo $class; ?>">
				<div class="row">
					<?php if ($addresses) { ?>
						<?php $address_row = 0; ?>
						<div class="list-group">
							<?php foreach ($addresses as $address) { ?>
								<div class="list-group-item border-none border-top border-bottom <?php echo ($address_id == $address['address_id']) ? 'list-group-item-info' : ''; ?>">
									<address class="text-left"><?php echo $address['address']; ?></address>
									<span class="">
										<a class="edit-address" href="<?php echo $address['edit']; ?>"><?php echo lang('text_edit'); ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
										<a class="delete-address text-danger" href="<?php echo $address['delete']; ?>"  onclick="if (confirm('<?php echo lang('alert_warning_confirm'); ?>')) {  return true; } else { return false;}"><?php echo lang('text_delete'); ?></a>
									</span>
								</div>
								<?php $address_row++; ?>
							<?php } ?>
						</div>
					<?php } else { ?>
						<div class="list-group-item"><?php echo lang('text_no_address'); ?></div>
					<?php } ?>

					<div class="col-md-12 page-spacing"></div>

					<div class="col-md-12">
						<div class="row">
							<div class="buttons col-sm-6">
								<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
								<a class="btn btn-primary btn-lg" href="<?php echo $continue_url; ?>"><?php echo lang('button_add'); ?></a>
							</div>

							<div class="col-sm-6">
								<div class="pagination-bar text-right">
									<div class="links"><?php echo $pagination['links']; ?></div>
									<div class="info"><?php echo $pagination['info']; ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#add-address').on('click', function() {
		if($('#new-address').is(':visible')) {
			$('#new-address').fadeOut();
		}else{
			$('#new-address').fadeIn();
		}
	});
});
//--></script>
<?php echo get_footer(); ?>