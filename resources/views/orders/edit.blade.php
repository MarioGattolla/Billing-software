<?php

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

/** @var Order $order */
/** @var Product $product */

$movements = OrderProduct::whereOrderId($order->id)->get();


?>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" ml-10 p-6 bg-white border-b border-gray-200 text-xl">
                    Order N. {{$order->id}}
                </div>

                <form method="POST" action="/orders/{{$order->id}}" name="order_edit_form">
                    @csrf
                    @method('PUT')
                    <div class="  p-3 ml-10 mr-10  mb-10" x-data="modal()">
                        <input type="text" value="{{$order->company_id}}" name="company[company_id]" hidden/>
                        <div class="bg-gray-100 p-3 border rounded-md">
                            @if($order->company->contact_name == null)
                                <p class="m-3 text-lg">Company</p>
                                <input type="text" value="{{null}}" name="company[contact_name]" hidden/>
                                <div class="flex">
                                    <div class="m-3"><p>Name</p>
                                        <label>
                                            <input type="text" name="company[business_name]"
                                                   value="{{$order->company->business_name}}"/>
                                        </label>
                                    </div>

                                    <div class="m-3"><p>Vat</p>
                                        <label>
                                            <input type="text" name="company[vat_number]"
                                                   value="{{$order->company->vat_number}}"/>
                                        </label>
                                    </div>

                                </div>
                            @else
                                <p class="m-3">Private</p>
                                <input type="text" value="{{null}}" name="company[business_name]" hidden/>
                                <input type="text" value="{{null}}" name="company[vat_number]" hidden/>
                                <div class="m-3"><p>Name</p>
                                    <label>
                                        <input type="text" name="company[contact_name]"
                                               value="{{$order->company->contact_name}}"/>
                                    </label>
                                </div>
                            @endif

                            <div class="flex">
                                <div class="m-3"><p>Email</p>
                                    <label>
                                        <input type="text" name="company[email]" value="{{$order->company->email}}"/>
                                    </label>
                                </div>
                                <div class="m-3"><p>Phone</p>
                                    <label>
                                        <input type="text" name="company[phone]" value="{{$order->company->phone}}"/>
                                    </label>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="m-3"><p>Country</p>
                                    <label>
                                        <input type="text" name="company[country]"
                                               value="{{$order->company->country}}"/>
                                    </label>
                                </div>
                                <div class="m-3"><p>Address</p>
                                    <label>
                                        <input type="text" name="company[address]"
                                               value="{{$order->company->address}}"/>
                                    </label>
                                </div>
                            </div>
                            <div>

                                <p class="m-3 text-lg">Order</p>
                                <div class="m-3">
                                    <label>
                                        <input type="date" name="date" value="{{$order->date}}"/>
                                    </label>

                                </div>


                                <div class="m-3">
                                    <p class="bg-white w-1/6 border border-gray-600 p-2">Type : {{ $order->type }}</p>
                                    <input type="text" value="{{$order->type}}" name="type" hidden/>
                                </div>

                                <p class="m-3 text-lg underline text-red-500">Products are not editable !!</p>
                                <div class="m-3">
                                    <table class="table-fixed w-full  bg-white table-bordered rounded-md
                                    align-items-center table-sm border-gray-400 border">
                                        <thead>
                                        <tr class=" bg-green-200">
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Price Ex Vat</th>
                                            <th>Vat</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($movements as $movement)
                                            @php $product = \App\Models\Product::findOrFail($movement->product_id)@endphp
                                            <tr class="border border-gray-400 h-10">
                                                <th class=" ">{{$product->name}}
                                                </th>
                                                <th>{{$product->price}}</th>
                                                <th class="w-1/12">{{$movement->quantity}}</th>
                                                <th class="w-1/12">{{$movement->total_ex_vat()}}</th>
                                                <th class="w-1/12">{{$product->vat}}</th>
                                                <th class="w-1/12">{{$movement->total()}}</th>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <x-elements.button class="w-20" type="submit">Submit</x-elements.button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
