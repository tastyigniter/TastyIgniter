<?php echo get_header(); ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-9 center-block top-spacing-10">
				<div class="row">
					<div class="col-xs-12">
						<ul class="nav nav-pills nav-justified thumbnail">
							<li class="disabled">
								<a href="#checkout">
									<h4 class="list-group-item-heading"><?php echo lang('text_step_one'); ?></h4>
									<p class="list-group-item-text"><?php echo lang('text_step_one_summary'); ?></p>
								</a>
							</li>
							<li class="disabled">
								<a href="#payment">
									<h4 class="list-group-item-heading"><?php echo lang('text_step_two'); ?></h4>
									<p class="list-group-item-text"><?php echo lang('text_step_two_summary'); ?></p>
								</a>
							</li>
							<li class="active">
								<a href="#confirmation">
									<h4 class="list-group-item-heading"><?php echo lang('text_step_three'); ?></h4>
									<p class="list-group-item-text"><?php echo lang('text_step_three_summary'); ?></p>
								</a>
							</li>
						</ul>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="heading-section">
							<?php echo $text_success_message; ?>
		                    <span class="under-heading"></span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
			    		<div class="panel panel-default">
			    			<div class="panel-heading">
			    				<h3 class="panel-title"><strong><?php echo lang('text_order_details'); ?></strong></h3>
			    			</div>
			    			<div class="panel-body">
			    				<div class="col-sm-6">
			    					<p><?php echo $order_details; ?></p>
			    				</div>
			    				<div class="col-sm-6">
									<?php if ($delivery_address) { ?>
										<strong><?php echo lang('text_delivery_address'); ?>:</strong>
										<address><?php echo $delivery_address; ?></address>
									<?php } ?>
			    				</div>
			    			</div>
			    		</div>
			    	</div>
				</div>

				<div class="row">
					<div class="col-md-12">
			    		<div class="panel panel-default">
			    			<div class="panel-heading">
			    				<h3 class="panel-title"><strong><?php echo lang('text_order_items'); ?></strong></h3>
			    			</div>
			    			<div class="panel-body">
								<?php if ($menus) { ?>
				    				<div class="table-responsive">
				    					<table class="table table-condensed">
				    						<tbody>
												<?php foreach ($menus as $menu) { ?>
													<tr>
														<td>x <?php echo $menu['quantity']; ?></td>
														<td class="text-center"><?php echo $menu['name']; ?><br />
															<?php if (!empty($menu['options'])) { ?>
																<div><small><?php echo $menu['options']; ?></small></div>
															<?php } ?>
														</td>
														<td class="text-right"><?php echo $menu['subtotal']; ?></td>
													 </tr>
												<?php } ?>
				                            </tbody>
				    						<tfoot>
												<tr>
													<td class="thick-line"></td>
													<td class="thick-line"></td>
													<td class="thick-line text-right">
                                                        <?php foreach ($order_totals as $total) { ?>
                                                            <?php if ($total['code'] !== 'order_total') { ?>
                                                                <span class="small text-muted wrap-buttom"><?php echo $total['title']. ': '. $total['value']; ?></span>                                                      <br />
                                                            <?php } ?>
                                                        <?php } ?>
                                                        <?php echo $order_total; ?>
                                                    </td>
                                                </tr>
				    						</tfoot>
				    					</table>
				    				</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<h4><?php echo lang('text_your_local'); ?></h4>
						<strong><?php echo $location_name; ?></strong><br />
						<address><?php echo $location_address; ?></address>
						<p><?php echo lang('text_thank_you'); ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
<?php echo get_footer(); ?>