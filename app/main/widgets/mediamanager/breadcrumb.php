<ol class="breadcrumb">
    <?php foreach ($breadcrumbs as $key => $breadcrumb) { ?>
        <?php if ($key == count($breadcrumbs) - 1) { ?>
            <li class="active"><?= $breadcrumb['name']; ?></li>
        <?php } else { ?>
            <li><?= $breadcrumb['name']; ?></li>
        <?php } ?>
    <?php } ?>
</ol>
