<div class="mr-4">
    <span
        class="extension-icon rounded"
    ><i class="fa fa-child"></i></span>
</div>
<div class="mr-4">
    {!! $this->makePartial('lists/list_buttons', ['theme' => $theme]) !!}
</div>
<div class="">
    <span class="h5">{{ $theme->name }}</span>&nbsp;&nbsp;
    <span class="small text-muted">{{ $theme->code }}</span>
</div>
