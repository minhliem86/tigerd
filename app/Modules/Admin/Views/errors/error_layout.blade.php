@if($errors->any())
    <div class="alert alert-danger alert-dismissable">
        @foreach($errors->all() as $error)
            <p>{!! $error !!}</p>
        @endforeach
    </div>
@endif