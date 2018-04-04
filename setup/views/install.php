<div class="panel panel-carte">
    <div class="panel-body">
        <label for="">
            <?= lang('label_site_key'); ?>&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="small" href="//docs.tastyigniter.com/tutorial/site"><?= lang('text_whats_this'); ?></a>
        </label>
        <p><?= lang('help_site_key'); ?></p>
        <input type="text"
               class="form-control"
               name="site_key"
               value=""
               placeholder="Enter your Carté Key... (Optional)">
    </div>
</div>

<div class="install-progress hide">
    <i class="fa fa-spinner fa-3x fa-spin"></i>
    <p class="message">Fetching themes...</p>
</div>

<div
    class="row text-center"
    data-html="install-type"
>
    <div class="col-sm-6">
        <div class="panel panel-install">
            <button
                class="btn btn-default btn-sm"
                data-install-control="install-core"
            ><?= lang('button_clean_install') ?></button>
            <p>Install TastyIgniter without any extensions or themes.</p>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-install">
            <button
                type="button"
                class="btn btn-default btn-sm"
                data-install-control="fetch-theme"
            ><?= lang('button_choose_theme') ?></button>
            <p>Choose a theme that fits and you can customize later.</p>
        </div>
    </div>
</div>
