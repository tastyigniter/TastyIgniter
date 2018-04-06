<div
    class="field-rating"
    data-control="star-rating"
    data-score="<?= e($value) ?>"
    data-hints="<?= e(json_encode($hints)); ?>"
    data-score-name="<?= $field->getName() ?>"
    <?= $field->getAttributes() ?>>

    <div class="rating rating-star"></div>
</div>
