@foreach ($scopes as $scope)
    <div class="col col-md-3 pr-md-3">
        {!! $this->renderScopeElement($scope) !!}
    </div>
@endforeach
