@props(['companies'])
<div class="m-3">
    <p>Search Company</p>
    <label>
        <input wire:model="search_company" type="search" placeholder="search for company"/>
    </label>
    @if($this->allow_new_company())
        <x-elements.button wire:click="use_new_company()">New Company</x-elements.button>
    @endif
    <div class="overflow-y-auto bg-white  h-1/2 absolute">
        @foreach($companies as $company)
            <option wire:click="select_company({{$company->id}})"
                    class="hover:bg-gray-100 p-1 cursor-pointer">
                {{$company->name}}
            </option>
        @endforeach
    </div>


</div>
