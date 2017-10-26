<div class="row-fluid">
    <?php foreach ($settings as $item => $categories) { ?>
        <?php
        if (!count($categories)) continue;
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title"><?= ucwords($item) ?></h4>
            </div>
            <div class="list-group">
                <?php foreach ($categories as $key => $category) { ?>
                    <a
                        class="list-group-item"
                        href="<?= $category->url ?>"
                        role="button"
                    >
                        <h4>
                            <?php if ($category->icon) { ?>
                                <i class="text-muted <?= $category->icon ?> fa-fw"></i>&nbsp;&nbsp;
                            <?php } ?>
                            <?= e(lang($category->label)) ?>
                        </h4>
                        <p><?= $category->description ? e(lang($category->description)) : '' ?></p>
                    </a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>

