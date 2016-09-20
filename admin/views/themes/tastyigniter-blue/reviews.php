<?php echo get_header(); ?>
<div class="row content">
    <div class="col-md-12">
        <div class="panel panel-default panel-table">
            <div class="panel-body panel-filter">
                <form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
                    <div class="filter-bar">
                        <div class="form-inline">
                            <div class="row">
                                <div class="col-md-3 pull-right text-right">
                                    <div class="form-group">
                                        <input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="<?php echo lang('text_filter_search'); ?>"/>&nbsp;&nbsp;&nbsp;
                                    </div>
                                    <a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_search'); ?>"><i class="fa fa-search"></i></a>
                                </div>

                                <div class="col-md-8 pull-left">
                                    <?php if (!$user_strict_location) { ?>
                                        <div class="form-group">
                                            <select name="filter_location" class="form-control input-sm">
                                                <option value=""><?php echo lang('text_filter_location'); ?></option>
                                                <?php foreach ($locations as $key => $value) { ?>
                                                    <?php if ($key == $filter_location) { ?>
                                                        <option value="<?php echo $key; ?>" <?php echo set_select('filter_location', $key, TRUE); ?> ><?php echo $value; ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $key; ?>" <?php echo set_select('filter_location', $key); ?> ><?php echo $value; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>&nbsp;
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <select name="filter_status" class="form-control input-sm">
                                            <option value=""><?php echo lang('text_filter_status'); ?></option>
                                            <?php if ($filter_status === '1') { ?>
                                                <option value="1" <?php echo set_select('filter_status', '1', TRUE); ?> >
                                                    <?php echo lang('text_approved'); ?>
                                                </option>
                                                <option value="0" <?php echo set_select('filter_status', '0'); ?> >
                                                    <?php echo lang('text_pending_review'); ?>
                                                </option>
                                            <?php } else if ($filter_status === '0') { ?>
                                                <option value="1" <?php echo set_select('filter_status', '1'); ?> >
                                                    <?php echo lang('text_approved'); ?>
                                                </option>
                                                <option value="0" <?php echo set_select('filter_status', '0', TRUE); ?> >
                                                    <?php echo lang('text_pending_review'); ?>
                                                </option>
                                            <?php } else { ?>
                                                <option value="1" <?php echo set_select('filter_status', '1'); ?> >
                                                    <?php echo lang('text_approved'); ?>
                                                </option>
                                                <option value="0" <?php echo set_select('filter_status', '0'); ?> >
                                                    <?php echo lang('text_pending_review'); ?>
                                                </option>
                                            <?php } ?>
                                        </select>&nbsp;
                                    </div>
                                    <div class="form-group">
                                        <select name="filter_date" class="form-control input-sm">
                                            <option value=""><?php echo lang('text_filter_date'); ?></option>
                                            <?php foreach ($review_dates as $key => $value) { ?>
                                                <?php if ($key == $filter_date) { ?>
                                                    <option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_filter'); ?>"><i class="fa fa-filter"></i></a>&nbsp;
                                    <a class="btn btn-grey" href="<?php echo page_url(); ?>" title="<?php echo lang('text_clear'); ?>"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
                <div class="table-responsive">
                    <table class="table table-striped table-border">
                        <thead>
                        <tr>
                            <th class="action">
                                <div class="checkbox checkbox-primary">
                                    <input type="checkbox" id="checkbox-all" class="styled" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                    <label for="checkbox-all"></label>
                                </div>
                            </th>
                            <?php if (!$user_strict_location) { ?>
                                <th>
                                    <a class="sort" href="<?php echo $sort_location_name; ?>"><?php echo lang('column_location'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'location_name') ? $order_by_active : $order_by; ?>"></i></a>
                                </th>
                            <?php } ?>
                            <th>
                                <a class="sort" href="<?php echo $sort_author; ?>"><?php echo lang('column_author'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'author') ? $order_by_active : $order_by; ?>"></i></a>
                            </th>
                            <th><a class="sort" href="<?php echo $sort_sale_id; ?>"><?php echo lang('column_sale_id'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'sale_id') ? $order_by_active : $order_by; ?>"></i></a>
                            </th>
                            <th><a class="sort" href="<?php echo $sort_sale_type; ?>"><?php echo lang('column_sale_type'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'sale_type') ? $order_by_active : $order_by; ?>"></i></a>
                            </th>
                            <th>
                                <a class="sort" href="<?php echo $sort_review_status; ?>"><?php echo lang('column_status'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'review_status') ? $order_by_active : $order_by; ?>"></i></a>
                            </th>
                            <th class="text-center"><a class="sort" href="<?php echo $sort_date_added; ?>"><?php echo lang('column_date_added'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'date_added') ? $order_by_active : $order_by; ?>"></i></a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($reviews) { ?>
                            <?php foreach ($reviews as $review) { ?>
                                <tr>
                                    <td class="action">
                                        <div class="checkbox checkbox-primary">
                                            <input type="checkbox" class="styled" id="checkbox-<?php echo $review['review_id']; ?>" value="<?php echo $review['review_id']; ?>" name="delete[]"/>
                                            <label for="checkbox-<?php echo $review['review_id']; ?>"></label>
                                        </div>
                                        <a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $review['edit']; ?>"><i class="fa fa-pencil"></i></a>
                                    </td>
                                    <?php if (!$user_strict_location) { ?>
                                        <td><?php echo $review['location_name']; ?></td>
                                    <?php } ?>
                                    <td><?php echo $review['author']; ?></td>
                                    <td><?php echo $review['sale_id']; ?></td>
                                    <td><?php echo ucwords($review['sale_type']); ?></td>
                                    <td>
                                        <?php if ($review['review_status'] === '1') { ?>
                                            <label class="label label-success">Approved</label>
                                        <?php } else { ?>
                                            <label class="label label-danger">Pending Review</label>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center"><?php echo $review['date_added']; ?></td>
                                </tr>

                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="7"><?php echo lang('text_empty'); ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="pagination-bar row">
                <div class="links col-sm-8"><?php echo $pagination['links']; ?></div>
                <div class="info col-sm-4"><?php echo $pagination['info']; ?></div>
            </div>
        </div>
    </div>
</div>
<?php echo get_footer(); ?>