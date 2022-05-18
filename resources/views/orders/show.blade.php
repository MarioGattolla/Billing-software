<?php

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

/** @var Order $order */
/** @var Product $product */

$movements = OrderProduct::whereOrderId($order->id)->get();


?>
<script>
    function modal() {
        return {
            modal: false,
        }
    }

</script>
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" ml-10 p-6 bg-white border-b border-gray-200 text-xl">
                    Order N. {{$order->id}}
                </div>

                <div class="  p-3 ml-10 mr-10  mb-10" x-data="modal()">
                    <div class="bg-gray-100 p-3 border rounded-md">
                        @if($order->company->contact_name == null)
                            <p class="m-3 text-lg">Company</p>
                            <div class="flex">
                                <div class="bg-white p-3 m-2 rounded-md border-2 w-1/3">
                                    Name : {{ $order->company->business_name }}
                                </div>
                                <div class="bg-white p-3 m-2 rounded-md border-2 w-1/3">
                                    Vat : {{ $order->company->vat_number }}
                                </div>
                            </div>
                        @else
                            <p class="m-3">Private</p>
                            <div class="bg-white p-3 m-2 rounded-md border-2 w-1/3">
                                Name : {{ $order->company->contact_name }}
                            </div>
                        @endif

                        <div class="flex">
                            <div class="bg-white p-3 m-2 rounded-md border-2 w-1/3">
                                Email : {{ $order->company->email }}
                            </div>
                            <div class="bg-white p-3 m-2 rounded-md border-2 w-1/3">
                                Phone : {{ $order->company->phone }}
                            </div>
                        </div>

                        <div class="flex">
                            <div class="bg-white p-3 m-2 rounded-md border-2 w-1/3">
                                Country : {{ $order->company->country }}
                            </div>
                            <div class="bg-white p-3 m-2 rounded-md border-2 w-1/3">
                                Address : {{ $order->company->address }}
                            </div>
                        </div>
                        <div>

                            <p class="m-3 text-lg">Order</p>
                            <div class="flex">
                                <div class="bg-white p-3 m-2 rounded-md border-2 w-1/3">
                                    Date : {{ $order->date }}
                                </div>
                                <div class="bg-white p-3 m-2 rounded-md border-2 w-1/3">
                                    Type : {{ $order->type }}
                                </div>
                            </div>

                            <p class="m-3 text-lg">Products</p>
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
                                            <th class="hover:bg-blue-50 cursor-pointer"><a
                                                    href="{{route('products.show', $product)}}">{{$product->name}}</a>
                                            </th>
                                            <th>{{$product->price}}</th>
                                            <th class="w-1/12">{{$movement->quantity}}</th>
                                            <th class="w-1/12">{{$movement->price_ex_vat}}</th>
                                            <th class="w-1/12">{{$product->vat}}</th>
                                            <th class="w-1/12">{{$movement->total}}</th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <a href="{{route('orders.edit',$order)}}" class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm ml-3 mr-5 mt-2 mb-2">
                                Edit Order
                            </a>

                            <button class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm ml-3 mr-5 mt-2 mb-2 modal" x-on:click="modal = true">
                                Delete Order
                            </button>
                        </div>


                        <div x-show="modal == true"
                             class="fixed top-0 right-0 left-0  h-full w-full bg-gray-100 bg-opacity-75 flex
                             items-center  ">
                            <div class="  bg-white rounded-md border m-auto w-1/3 text-center
                            rounded-md border-2 p-3 ">
                                <div class="m-3">
                                    <div>
                                        You are trying to cancel the current Order.

                                    </div>
                                    <div>
                                        By clicking "DELETE" , Order will be permanently deleted. Are you sure?

                                    </div>
                                </div>
                                <div class=" flex grid grid-cols-2 items-center ">

                                    <div class="col-span-1 items-center ">
                                        <form method="POST" class="mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="mt-1   p-3 border rounded-md border-green-400 hover:bg-green-400
                                            bg-green-200 text-sm"> Delete Order
                                            </button>
                                        </form>

                                    </div>

                                    <div class="col-span-1 items-center ">
                                        <button class="p-3 border rounded-md border-green-400 hover:bg-green-400
                                            bg-green-200 text-sm" x-on:click="modal = false">
                                            Return Back
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
