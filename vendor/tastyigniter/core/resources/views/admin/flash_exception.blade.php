<div class="card p-4 shadow-sm m-4">
    <div class="text-center my-5 m-auto">
        <i @class(['fa fa-4x text-'.$class, 'mb-4',
            'fa-check' => $class === 'success',
            'fa-circle-exclamation' => $class === 'danger'
        ])></i>
        <h1>{{$title}}</h1>
        <p class="lead mt-3">{{$text}}</p>
    </div>
</div>
