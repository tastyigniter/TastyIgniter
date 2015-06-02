<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
        <div class="panel panel-default panel-table panel-tabs">
            <div class="panel-heading">
                <ul id="nav-tabs" class="nav nav-tabs">
                    <?php foreach ($types as $key => $value) { ?>
                        <?php if ($key === $filter_type) { ?>
                            <li class="active"><a href="<?php echo $value['url']; ?>"><?php echo ucwords($key); ?> &nbsp;<span class="badge"><?php echo $value['badge']; ?></span></a></li>
                        <?php } else { ?>
                            <li><a href="<?php echo $value['url']; ?>"><?php echo ucwords($key); ?> &nbsp;<span class="badge"><?php echo $value['badge']; ?></span></a></li>
                        <?php } ?>
                    <?php } ?>
                </ul>
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
                                        <input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="Search ip, customer or browser." />&nbsp;&nbsp;&nbsp;
                                    </div>
                                    <a class="btn btn-grey" onclick="filterList();" title="Search"><i class="fa fa-search"></i></a>
                                </div>

                                <div class="col-md-8 pull-left">
                                    <input type="hidden" name="filter_type" value="<?php echo $filter_type; ?>" />
                                    <div class="form-group">
                                        <select name="filter_access" class="form-control input-sm">
                                            <option value="">View all access</option>
                                            <?php if ($filter_access === 'browser') { ?>
                                                <option value="browser" <?php echo set_select('filter_access', 'browser', TRUE); ?> >Browser</option>
                                                <option value="mobile" <?php echo set_select('filter_access', 'mobile'); ?> >Mobile</option>
                                                <option value="robot" <?php echo set_select('filter_access', 'robot'); ?> >Robot</option>
                                            <?php } else if ($filter_access === 'mobile') { ?>
                                                <option value="browser" <?php echo set_select('filter_access', 'browser'); ?> >Browser</option>
                                                <option value="mobile" <?php echo set_select('filter_access', 'mobile', TRUE); ?> >Mobile</option>
                                                <option value="robot" <?php echo set_select('filter_access', 'robot'); ?> >Robot</option>
                                            <?php } else if ($filter_access === 'robot') { ?>
                                                <option value="browser" <?php echo set_select('filter_access', 'browser'); ?> >Browser</option>
                                                <option value="mobile" <?php echo set_select('filter_access', 'mobile'); ?> >Mobile</option>
                                                <option value="robot" <?php echo set_select('filter_access', 'robot', TRUE); ?> >Robot</option>
                                            <?php } else { ?>
                                                <option value="browser" <?php echo set_select('filter_access', 'browser'); ?> >Browser</option>
                                                <option value="mobile" <?php echo set_select('filter_access', 'mobile'); ?> >Mobile</option>
                                                <option value="robot" <?php echo set_select('filter_access', 'robot'); ?> >Robot</option>
                                            <?php } ?>
                                        </select>&nbsp;
                                    </div>
                                    <div class="form-group">
                                        <select name="filter_date" class="form-control input-sm">
                                            <option value="">View by date</option>
                                            <?php foreach ($online_dates as $key => $value) { ?>
                                                <?php if ($key === $filter_date) { ?>
                                                    <option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <a class="btn btn-grey" onclick="filterList();" title="Filter"><i class="fa fa-filter"></i></a>&nbsp;
                                    <a class="btn btn-grey" href="<?php echo page_url(); ?>" title="Clear"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <form role="form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
                <div class="table-responsive">
                    <table border="0" class="table table-striped table-border">
                        <thead>
                        <tr>
                            <!--<th class="action action-one"></th>-->
                            <th>IP</th>
                            <th>Customer</th>
                            <th>Access</th>
                            <th>Browser</th>
<!--                            <th class="text-center">User Agent</th>-->
                            <th style="width:22%;">Last Request URL</th>
                            <th style="width:22%;">Last Referrer URL</th>
                            <th><a class="sort" href="<?php echo $sort_date; ?>">Last Activity<i class="fa fa-sort-<?php echo ($sort_by == 'date_added') ? $order_by_active : $order_by; ?>"></i></a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($customers_online) { ?>
                            <?php foreach ($customers_online as $online) { ?>
                                <tr>
                                    <!--<td class="action action-one"><a class="btn btn-danger" title="Blacklist IP" href="<?php //echo $online['blacklist']; ?>"><i class="fa fa-ban"></i></a></td>-->
                                    <td><?php echo $online['ip_address']; ?>&nbsp;&nbsp;<img class="flag" title="<?php echo $online['country_name']; ?>" width="16" src="<?php echo $online['country_code']; ?>" /></td>
                                    <td><?php echo $online['customer_name']; ?></td>
                                    <td><?php echo $online['access_type']; ?></td>
                                    <td><?php echo $online['browser']; ?></td>
<!--                                    <td class="text-center">--><?php //echo $online['user_agent']; ?><!--</td>-->
                                    <td><a href="<?php echo $online['request_url']; ?>"><?php echo $online['request_uri']; ?></a></td>
                                    <td><a href="<?php echo $online['referrer_url']; ?>"><?php echo $online['referrer_uri']; ?></a></td>
                                    <td><?php echo $online['date_added']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="8"><?php echo $text_empty; ?></td>
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