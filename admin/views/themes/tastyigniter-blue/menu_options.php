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
                                            <select name="filter_display_type" class="form-control input-sm">
                                                <option value=""><?php echo lang('text_filter_display_type'); ?> </option>
                                                <?php if ($filter_display_type == 'radio') { ?>
                                                    <option value="radio" selected="selected" <?php echo set_select('filter_display_type', 'radio'); ?> ><?php echo lang('text_radio'); ?></option>
                                                <?php } else { ?>
                                                    <option value="radio" <?php echo set_select('filter_display_type', 'radio'); ?> ><?php echo lang('text_radio'); ?></option>
                                                <?php } ?>
                                                <?php if ($filter_display_type == 'checkbox') { ?>
                                                    <option value="checkbox" selected="selected" <?php echo set_select('filter_display_type', 'checkbox'); ?> ><?php echo lang('text_checkbox'); ?></option>
                                                <?php } else { ?>
                                                    <option value="checkbox" <?php echo set_select('filter_display_type', 'checkbox'); ?> ><?php echo lang('text_checkbox'); ?></option>
                                                <?php } ?>
                                                <?php if ($filter_display_type == 'select') { ?>
                                                    <option value="select" selected="selected" <?php echo set_select('filter_display_type', 'select'); ?> ><?php echo lang('text_select'); ?></option>
                                                <?php } else { ?>
                                                    <option value="select" <?php echo set_select('filter_display_type', 'select'); ?> ><?php echo lang('text_select'); ?></option>
                                                <?php } ?>
                                            </select>&nbsp;
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
                                <th><a class="sort" href="<?php echo $sort_name; ?>"><?php echo lang('column_name'); ?>
                                        <i class="fa fa-sort-<?php echo ($sort_by == 'option_name') ? $order_by_active : $order_by; ?>"></i></a>
                                </th>
                                <th class="text-center">
                                    <a class="sort" href="<?php echo $sort_priority; ?>"><?php echo lang('column_priority'); ?>
                                        <i class="fa fa-sort-<?php echo ($sort_by == 'priority') ? $order_by_active : $order_by; ?>"></i></a>
                                </th>
                                <th class="text-center">
                                    <a class="sort" href="<?php echo $sort_display_type; ?>"><?php echo lang('column_display_type'); ?>
                                        <i class="fa fa-sort-<?php echo ($sort_by == 'display_type') ? $order_by_active : $order_by; ?>"></i></a>
                                </th>
                                <th class="id">
                                    <a class="sort" href="<?php echo $sort_id; ?>"><?php echo lang('column_id'); ?>
                                        <i class="fa fa-sort-<?php echo ($sort_by == 'option_id') ? $order_by_active : $order_by; ?>"></i></a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if ($menu_options) { ?>
                                <?php foreach ($menu_options as $menu_option) { ?>
                                    <tr>
                                        <td class="action">
                                            <input type="checkbox" value="<?php echo $menu_option['option_id']; ?>" name="delete[]"/>&nbsp;&nbsp;&nbsp;
                                            <a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $menu_option['edit']; ?>"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        <td><?php echo $menu_option['option_name']; ?></td>
                                        <td class="text-center"><?php echo $menu_option['priority']; ?></td>
                                        <td class="text-center"><?php echo $menu_option['display_type']; ?></td>
                                        <td class="id"><?php echo $menu_option['option_id']; ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="4"><?php echo lang('text_empty'); ?></td>
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