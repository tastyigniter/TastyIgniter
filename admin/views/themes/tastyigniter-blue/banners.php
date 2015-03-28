<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Banner List</h3>
			</div>
			<form role="form" id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<div class="table-responsive">
				<table border="0" class="table table-striped table-border">
					<thead>
						<tr>
							<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
							<th>Name</th>
							<th>Type</th>
							<th>Status</th>
							<th class="id">ID</th>
						</tr>
					</thead>
					<tbody>
						<?php if ($banners) { ?>
						<?php foreach ($banners as $banner) { ?>
						<tr>
							<td class="action"><input type="checkbox" value="<?php echo $banner['banner_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
								<a class="btn btn-edit" title="Edit" href="<?php echo $banner['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
							<td><?php echo $banner['name']; ?></td>
							<td>
								<?php if ($banner['type'] === 'carousel') { ?>
									<span class="fa fa-film" title="<?php echo $banner['type']; ?>"></span>
								<?php } else if ($banner['type'] === 'image') { ?>
									<span class="fa fa-image" title="<?php echo $banner['type']; ?>"></span>
								<?php } else if ($banner['type'] === 'custom') { ?>
									<span class="fa fa-file-code-o" title="<?php echo $banner['type']; ?>"></span>
								<?php } ?>
							</td>
							<td><?php echo $banner['status']; ?></td>
							<td class="id"><?php echo $banner['banner_id']; ?></td>
						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td colspan="5"><?php echo $text_empty; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		</form>
	</div>
</div>
<?php echo $footer; ?>