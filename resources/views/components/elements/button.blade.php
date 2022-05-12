@props(['type' => 'button'])

<button {{$attributes->class('bg-green-200 p-1 border border-green-300 hover:cursor-pointer hover:bg-green-400  rounded-md m-2')}} type="{{$type}}">
    {{$slot}}
</button>
