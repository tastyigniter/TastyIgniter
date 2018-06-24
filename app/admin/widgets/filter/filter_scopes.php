<div class="d-sm-flex w-100 no-gutters">
    <?php foreach ($scopes as $scope) { ?>
        <div class="col col-sm-2 mr-2">
            <?= $this->renderScopeElement($scope) ?>
        </div>
    <?php } ?>
</div>