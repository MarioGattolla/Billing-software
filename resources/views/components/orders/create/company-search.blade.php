
<div class="m-3">
    <p>Search Company</p>
    <label>
        <input wire:model="search_company" type="search" placeholder="search for company"/>
    </label>
    @if($this->allow_new_company())
        <button wire:click="use_new_company()">Create New Company</button>
    @endif
    <div class="overflow-y-auto bg-white w-1/3 h-1/2 ">
        @foreach($filtered_companies as $filtered_company)
            <option wire:click="select_company({{$filtered_company->id}})"
                    class="hover:bg-gray-100 p-1 cursor-pointer">
                {{$filtered_company->name}}
            </option>
        @endforeach
    </div>


</div>
