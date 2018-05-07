<ol class="breadcrumb">
    <?php foreach ($breadcrumbs as $key => $breadcrumb) { ?>
        <?php if ($key == count($breadcrumbs) - 1) { ?>
            <li class="breadcrumb-item active"><?= $breadcrumb['name']; ?></li>
        <?php } else { ?>
            <li class="breadcrumb-item"><?= $breadcrumb['name']; ?></li>
        <?php } ?>
    <?php } ?>
</ol>
