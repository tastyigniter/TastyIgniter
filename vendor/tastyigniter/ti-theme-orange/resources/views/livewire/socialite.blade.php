<div>
    @if($confirm)
        @include('igniter-orange::includes.account.socialite-confirm')
    @else
        @foreach($links as $name => $link)
            <a
                class="btn btn-outline-secondary w-100 text-center mb-3"
                href="{{ $link."?success={$successPage}&error={$errorPage}" }}"
            ><i class="fab fa-{{ $name }}"></i>&nbsp;&nbsp;Continue with {{ ucfirst($name) }}</a>
        @endforeach
    @endif
</div>
