<?php foreach ($widgets as $widgetAlias => $widgetInfo) { ?>
    <?= $this->makePartial('widget_item', [
        'widgetAlias' => $widgetAlias,
        'widget'      => $widgetInfo['widget'],
        'priority'    => $widgetInfo['priority'],
    ]) ?>
<?php } ?>