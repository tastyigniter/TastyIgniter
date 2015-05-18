<?php if (!empty($right_modules)) { ?>
    <div id="module-right" class="col-sm-3">
        <div class="side-bar">
            <?php foreach ($right_modules as $module) { ?>
                <?php echo $module; ?>
            <?php } ?>
        </div>
    </div>
<?php } ?>