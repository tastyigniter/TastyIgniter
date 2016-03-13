<div class="modal fade" id="mail-variables" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo $this->template->getHeading(); ?></h4>
			</div>
			<div class="modal-body">
				<?php foreach ($variables as $key => $value) { ?>
					<?php $filter_class = !empty($filters[$key]) ? implode($filters[$key], ' ') : ''; ?>
					<div class="panel hide <?php echo $filter_class; ?>">
						<div class="panel-heading border-bottom"><h4 class="panel-title"><?php echo $key; ?></h4></div>
						<div class="list-group supported-var">
							<?php foreach ($value as $variable) { ?>
								<a href="#" class="list-group-item"><span class="text-muted"><?php echo $variable['var']; ?></span> <?php echo $variable['name']; ?></a>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#mail-variables').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var filter = button.data('filter');
			// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

			var modal = $(this);
			modal.find('.modal-body > .panel').addClass('hide');
			modal.find('.modal-body > .panel.' + filter).removeClass('hide')
		})
	});
</script>