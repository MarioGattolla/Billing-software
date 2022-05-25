@props(['errors'])

@if($errors->any())
    <div class="bg-red-100  w-50 text-center m-3 p-2 rounded-md">
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    </div>
@endif
