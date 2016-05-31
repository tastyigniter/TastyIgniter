<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-location" class="col-sm-3 control-label"><?php echo lang('label_location'); ?></label>
						<div class="col-sm-5">
							<select name="location_id" id="input-location" class="form-control">
								<?php foreach ($locations as $location) { ?>
								<?php if ($location['location_id'] === $location_id) { ?>
									<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location_id', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location_id', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('location_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-sale-type" class="col-sm-3 control-label"><?php echo lang('label_sale_type'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($sale_type == 'reservation') { ?>
									<label class="btn btn-success"><input type="radio" name="sale_type" value="order" <?php echo set_radio('sale_type', 'order'); ?>><?php echo lang('text_order'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="sale_type" value="reservation" <?php echo set_radio('sale_type', 'reservation', TRUE); ?>><?php echo lang('text_reservation'); ?></label>
								<?php } else { ?>
									<label class="btn btn-success active"><input type="radio" name="sale_type" value="order" <?php echo set_radio('sale_type', 'order', TRUE); ?>><?php echo lang('text_order'); ?></label>
									<label class="btn btn-success"><input type="radio" name="sale_type" value="reservation" <?php echo set_radio('sale_type', 'reservation'); ?>><?php echo lang('text_reservation'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('sale_type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order" class="col-sm-3 control-label"><?php echo lang('label_sale_id'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="sale_id" id="input-order" class="form-control" value="<?php echo set_value('sale_id', $sale_id); ?>"/>
							<?php echo form_error('sale_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-author" class="col-sm-3 control-label"><?php echo lang('label_author'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="customer_id" id="input-author" class="form-control" value="<?php echo set_value('customer_id', $customer_id); ?>"/>
							<input type="hidden" name="author" value="<?php echo set_value('author', $author); ?>"/>
							<?php echo form_error('customer_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-rating" class="col-sm-3 control-label"><?php echo lang('label_rating'); ?></label>
						<div class="col-sm-5">
							<ul class="list-inline rating-inline">
								<li><?php echo lang('label_quality'); ?><br />
									<div class="rating rating-star" data-score="<?php echo $quality; ?>" data-score-name="rating[quality]"></div>
								</li>
								<li><?php echo lang('label_delivery'); ?><br />
									<div class="rating rating-star" data-score="<?php echo $delivery; ?>" data-score-name="rating[delivery]"></div>
								</li>
								<li><?php echo lang('label_service'); ?><br />
									<div class="rating rating-star" data-score="<?php echo $service; ?>" data-score-name="rating[service]"></div>
								</li>
								<?php echo form_error('rating[quality]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('rating[delivery]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('rating[service]', '<span class="text-danger">', '</span>'); ?>
							</ul>
						</div>
					</div>
					<div class="form-group">
						<label for="input-review-text" class="col-sm-3 control-label"><?php echo lang('label_text'); ?></label>
						<div class="col-sm-5">
							<textarea name="review_text" id="input-review-text" class="form-control" rows="7"><?php echo set_value('review_text', $review_text); ?></textarea>
							<?php echo form_error('review_text', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($review_status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="review_status" value="0" <?php echo set_radio('review_status', '0'); ?>><?php echo lang('text_pending_review'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="review_status" value="1" <?php echo set_radio('review_status', '1', TRUE); ?>><?php echo lang('text_approved'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="review_status" value="0" <?php echo set_radio('review_status', '0', TRUE); ?>><?php echo lang('text_pending_review'); ?></label>
									<label class="btn btn-success"><input type="radio" name="review_status" value="1" <?php echo set_radio('review_status', '1'); ?>><?php echo lang('text_approved'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('review_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	var ratings = <?php echo json_encode(array_values($ratings)); ?>;
	displayRatings(ratings);
});

$('input[name=\'customer_id\']').select2({
	placeholder: 'Start typing...',
	minimumInputLength: 2,
	ajax: {
		url: '<?php echo site_url("/customers/autocomplete"); ?>',
		dataType: 'json',
		quietMillis: 100,
		data: function (term, page) {
			return {
				term: term, //search term
				page_limit: 10 // page size
			};
		},
		results: function (data, page, query) {
			return { results: data.results };
		}
	},
	initSelection: function(element, callback) {
		return $.getJSON('<?php echo site_url("/customers/autocomplete?customer_id="); ?>' + (element.val()), null, function(json) {
			var data = {id: json.results[0].id, text: json.results[0].text};
			return callback(data);
		});
	}
});

$('input[name=\'customer_id\']').on('select2-selecting', function(e) {
	$('input[name=\'author\']').val(e.choice.text);
	$('input[name=\'customer_id\']').val(e.choice.id);
});
//--></script>
<?php echo get_footer(); ?>