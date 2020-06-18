<div class="filter-scope date form-group">
    <input type="hidden" name="<?= $this->getScopeName($scope) ?>" value="<?= $scope->value ?>" data-datepicker-value="">
	<input 
		type="text"
		id="<?= $this->getScopeName($scope) ?>-datepicker"
		class="form-control" 
		autocomplete="off" 
		value="<?= mdate('%d-%m-%Y', strtotime($scope->value)) ?>" 
		data-control="datepicker" 
		data-format="dd-mm-yyyy"
	>
</div>
