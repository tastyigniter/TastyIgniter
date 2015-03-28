<?php echo $header; ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-9 center-block">
				<div class="row">
					<div class="col-md-12">
						<div class="heading-section">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12">
						<ul class="nav nav-pills nav-justified thumbnail">
							<li class="disabled">
								<a href="#checkout">
									<h4 class="list-group-item-heading">Step 1</h4>
									<p class="list-group-item-text">Your Details</p>
								</a>
							</li>
							<li class="disabled">
								<a href="#payment">
									<h4 class="list-group-item-heading">Step 2</h4>
									<p class="list-group-item-text">Payment</p>
								</a>
							</li>
							<li class="active">
								<a href="#confirmation">
									<h4 class="list-group-item-heading">Step 3</h4>
									<p class="list-group-item-text">Confirmation</p>
								</a>
							</li>
						</ul>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="heading-section">
							<?php echo $message; ?>
		                    <span class="under-heading"></span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
			    		<div class="panel panel-default">
			    			<div class="panel-heading">
			    				<h3 class="panel-title"><strong><?php echo $text_order_details; ?></strong></h3>
			    			</div>
			    			<div class="panel-body">
			    				<div class="col-sm-6">
			    					<p><?php echo $order_details; ?></p>
			    				</div>
			    				<div class="col-sm-6">
									<?php if ($delivery_address) { ?>
										<strong><?php echo $text_delivery_address; ?>:</strong>
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
			    				<h3 class="panel-title"><strong><?php echo $text_order_items; ?></strong></h3>
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
																<div><font size="1">+ <?php echo $menu['options']; ?></font></div>
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
													<td class="thick-line text-right"><span class="small text-muted wrap-buttom"><?php echo $order_coupon; ?></span><br /><?php echo $order_total; ?></td>
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
						<h4><?php echo $text_local; ?></h4>
						<strong><?php echo $location_name; ?></strong><br />
						<address><?php echo $location_address; ?></address>
						<p><?php echo $text_thank_you; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
<?php echo $footer; ?>