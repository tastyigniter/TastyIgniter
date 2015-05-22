<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Review Details</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-location" class="col-sm-3 control-label">Restaurant:</label>
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
						<label for="input-show-menu-images" class="col-sm-3 control-label">Sale Type:</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($sale_type == 'reservation') { ?>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="sale_type" value="order" <?php echo set_radio('sale_type', 'order'); ?>>Order</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="sale_type" value="reservation" <?php echo set_radio('sale_type', 'reservation', TRUE); ?>>Reservation</label>
								<?php } else { ?>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="sale_type" value="order" <?php echo set_radio('sale_type', 'order', TRUE); ?>>Order</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="sale_type" value="reservation" <?php echo set_radio('sale_type', 'reservation'); ?>>Reservation</label>
								<?php } ?>
							</div>
							<?php echo form_error('sale_type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order" class="col-sm-3 control-label">Sale ID:</label>
						<div class="col-sm-5">
							<input type="text" name="sale_id" id="input-order" class="form-control" value="<?php echo set_value('sale_id', $sale_id); ?>"/>
							<?php echo form_error('sale_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-author" class="col-sm-3 control-label">Author:</label>
						<div class="col-sm-5">
							<input type="text" name="customer_id" id="input-author" class="form-control" value="<?php echo set_value('customer_id', $customer_id); ?>"/>
							<input type="hidden" name="author" value="<?php echo set_value('author', $author); ?>"/>
							<?php echo form_error('customer_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-rating" class="col-sm-3 control-label">Rating:</label>
						<div class="col-sm-5">
							<ul class="list-inline rating-inline">
								<li>Quality<br />
									<div class="rating rating-star" data-score="<?php echo $quality; ?>" data-score-name="rating[quality]"></div>
								</li>
								<li>Delivery<br />
									<div class="rating rating-star" data-score="<?php echo $delivery; ?>" data-score-name="rating[delivery]"></div>
								</li>
								<li>Service<br />
									<div class="rating rating-star" data-score="<?php echo $service; ?>" data-score-name="rating[service]"></div>
								</li>
                                <?php echo form_error('rating[quality]', '<span class="text-danger">', '</span>'); ?>
                                <?php echo form_error('rating[delivery]', '<span class="text-danger">', '</span>'); ?>
                                <?php echo form_error('rating[service]', '<span class="text-danger">', '</span>'); ?>
							</ul>
						</div>
					</div>
					<div class="form-group">
						<label for="input-review-text" class="col-sm-3 control-label">Review Text:</label>
						<div class="col-sm-5">
							<textarea name="review_text" id="input-review-text" class="form-control" rows="7"><?php echo set_value('review_text', $review_text); ?></textarea>
							<?php echo form_error('review_text', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label">Review Status:</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($review_status == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="review_status" value="0" <?php echo set_radio('review_status', '0'); ?>>Pending Review</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="review_status" value="1" <?php echo set_radio('review_status', '1', TRUE); ?>>Approved</label>
								<?php } else { ?>
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="review_status" value="0" <?php echo set_radio('review_status', '0', TRUE); ?>>Pending Review</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="review_status" value="1" <?php echo set_radio('review_status', '1'); ?>>Approved</label>
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