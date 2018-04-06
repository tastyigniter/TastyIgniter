<div
    id="<?= $this->getId() ?>"
    class="calendar-widget"
    data-control="calendar"
    data-alias="<?= $this->alias ?>"
    data-aspect-ratio="<?= $aspectRatio ?>"
    data-editable="<?= $editable ? 'true' : 'false' ?>"
    data-event-limit="<?= $eventLimit ?>"
    data-default-date="<?= $defaultDate ?>"
>

    <?php if ($editable) { ?>
        <script type="text/template" data-calendar-popover-template>
            <?= $this->renderPopoverPartial() ?>
        </script>
    <?php } ?>
</div>
