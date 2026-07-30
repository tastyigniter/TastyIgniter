@foreach($scopes as $scope)
    <div class="mb-3">
        {!! $this->renderScopeElement($scope) !!}
    </div>
@endforeach
