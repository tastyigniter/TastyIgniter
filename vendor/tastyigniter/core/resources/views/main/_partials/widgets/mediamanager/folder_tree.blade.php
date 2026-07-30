<div
    class="folder-tree px-2"
    data-folders='@json($folderList)'
>
    <ul class="list-group list-group-flush">
        @foreach($folderList as $path)
            <div
                class="list-group-item cursor-pointer p-0 py-1 link-underline link-dark"
                data-media-control="folder-tree-item"
                data-path="{{ $path }}"
            >
                <span class="">{{ $path }}</span>
            </div>
        @endforeach
    </ul>
</div>
