<?php echo get_header(); ?>
    <div class="row content">
        <div class="col-md-12">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo lang('text_list'); ?></h3>

                    <div class="pull-right">
                        <button class="btn btn-filter btn-xs"><i class="fa fa-filter"></i></button>
                    </div>
                </div>
                <div class="panel-body panel-filter">
                    <form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
                        <div class="filter-bar">
                            <div class="form-inline">
                                <div class="row">
                                    <div class="col-md-3 pull-right text-right">
                                        <div class="form-group">
                                            <input type="text" name="filter_search" class="form-control input-sm" value="<?php echo set_value('filter_search', $filter_search); ?>" placeholder="<?php echo lang('text_filter_search'); ?>"/>&nbsp;&nbsp;&nbsp;
                                        </div>
                                        <a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_search'); ?>"><i class="fa fa-search"></i></a>
                                    </div>
                                    <div class="col-md-8 pull-left">
                                        <div class="form-group">
                                            <select name="filter_category" class="form-control input-sm">
                                                <option value=""><?php echo lang('text_filter_category'); ?></option>
                                                <?php foreach ($categories as $category) { ?>
                                                    <?php if ($category['category_id'] == $category_id) { ?>
                                                        <option value="<?php echo $category['category_id']; ?>" <?php echo set_select('filter_category', $category['category_id'], TRUE); ?> ><?php echo $category['category_name']; ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $category['category_id']; ?>" <?php echo set_select('filter_category', $category['category_id']); ?> ><?php echo $category['category_name']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>&nbsp;
                                        </div>
                                        <div class="form-group">
                                            <select name="filter_status" class="form-control input-sm">
                                                <option value=""><?php echo lang('text_filter_status'); ?></option>
                                                <?php if ($filter_status === '1') { ?>
                                                    <option value="1" <?php echo set_select('filter_status', '1', TRUE); ?> ><?php echo lang('text_enabled'); ?></option>
                                                    <option value="0" <?php echo set_select('filter_status', '0'); ?> ><?php echo lang('text_disabled'); ?></option>
                                                <?php } else if ($filter_status === '0') { ?>
                                                    <option value="1" <?php echo set_select('filter_status', '1'); ?> ><?php echo lang('text_enabled'); ?></option>
                                                    <option value="0" <?php echo set_select('filter_status', '0', TRUE); ?> ><?php echo lang('text_disabled'); ?></option>
                                                <?php } else { ?>
                                                    <option value="1" <?php echo set_select('filter_status', '1'); ?> ><?php echo lang('text_enabled'); ?></option>
                                                    <option value="0" <?php echo set_select('filter_status', '0'); ?> ><?php echo lang('text_disabled'); ?></option>
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
                                    <input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
                                </th>
                                <!--<th>Photo</th>-->
                                <th class="name">
                                    <a class="sort" href="<?php echo $sort_name; ?>"><?php echo lang('column_name'); ?>
                                        <i class="fa fa-sort-<?php echo ($sort_by == 'menu_name') ? $order_by_active : $order_by; ?>"></i></a>
                                </th>
                                <th>
                                    <a class="sort" href="<?php echo $sort_price; ?>"><?php echo lang('column_price'); ?>
                                        <i class="fa fa-sort-<?php echo ($sort_by == 'menu_price') ? $order_by_active : $order_by; ?>"></i></a>
                                </th>
                                <th><?php echo lang('column_category'); ?></th>
                                <th>
                                    <a class="sort" href="<?php echo $sort_stock; ?>"><?php echo lang('column_stock_qty'); ?>
                                        <i class="fa fa-sort-<?php echo ($sort_by == 'stock_qty') ? $order_by_active : $order_by; ?>"></i></a>
                                </th>
                                <th class="text-center"><?php echo lang('column_status'); ?></th>
                                <th class="id">
                                    <a class="sort" href="<?php echo $sort_id; ?>"><?php echo lang('column_id'); ?>
                                        <i class="fa fa-sort-<?php echo ($sort_by == 'menus.menu_id') ? $order_by_active : $order_by; ?>"></i></a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($menus) { ?>
                                <?php foreach ($menus as $menu) { ?>
                                    <tr id="<?php echo $menu['menu_id']; ?>">
                                        <td class="action">
                                            <input type="checkbox" value="<?php echo $menu['menu_id']; ?>" name="delete[]"/>&nbsp;&nbsp;&nbsp;
                                            <a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $menu['edit']; ?>"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        <!--<td class="left"><img src="<?php echo $menu['menu_photo']; ?>"></td>-->
                                        <td class="name"><?php echo $menu['menu_name']; ?></td>
                                        <td class="left"><?php echo $menu['menu_price']; ?>&nbsp;&nbsp;
                                            <?php if ($menu['special_status'] === '1' AND $menu['is_special'] === '1') { ?>
                                                <a title="<?php echo lang('text_special_enabled'); ?>"><i class="fa fa-star fa-star-special"></i></a>
                                            <?php } else if ($menu['special_status'] === '1' AND $menu['is_special'] !== '1') { ?>
                                                <a title="<?php echo lang('text_special_expired'); ?>"><i class="fa fa-star fa-star-special disabled"></i></a>
                                            <?php } else if ($menu['is_special'] === '1') { ?>
                                                <a title="<?php echo lang('text_special_disabled'); ?>"><i class="fa fa-star fa-star-special disabled"></i></a>
                                            <?php } ?>
                                        </td>
                                        <td class="left"><?php echo $menu['category_name']; ?></td>
                                        <td class="left"><?php echo ($menu['stock_qty'] < 1) ? '<span class="red">' . $menu['stock_qty'] . '</span>' : $menu['stock_qty']; ?></td>
                                        <td class="text-center"><?php echo $menu['menu_status']; ?></td>
                                        <td class="id"><?php echo $menu['menu_id']; ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="7" class="center"><?php echo lang('text_empty'); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>

                <div class="pagination-bar clearfix">
                    <div class="links"><?php echo $pagination['links']; ?></div>
                    <div class="info"><?php echo $pagination['info']; ?></div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript"><!--
        function filterList() {
            $('#filter-form').submit();
        }
        //--></script>
<?php echo get_footer(); ?>