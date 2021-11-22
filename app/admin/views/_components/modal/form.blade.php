@props([
    'label' => null,
    'placeholder' => null,
    'options' => [],
    'size' => null,
    'help' => null,
])

<x-forms.form>
    @isset($title)
        <div class="modal-header">
            <h5 class="modal-title">{{ $title }}</h5>

            <x-modal.close/>
        </div>
    @endisset

    <div class="modal-body">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="modal-footer">
            {{ $footer }}
        </div>
    @endisset
</x-forms.form>
