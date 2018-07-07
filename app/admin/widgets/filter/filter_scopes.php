<div class="d-sm-flex flex-sm-wrap w-100 no-gutters">
    <?php foreach ($scopes as $scope) { ?>
        <div class="col col-sm-2 mr-3 mb-3">
            <?= $this->renderScopeElement($scope) ?>
        </div>
    <?php } ?>
</div>