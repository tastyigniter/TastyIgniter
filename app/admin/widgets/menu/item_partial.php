<?= $this->makePartial($item->path ?: $item->itemName, [
    'menuItem' => $item,
    'item'     => $item,
]) ?>