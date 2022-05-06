<?php

use App\Models\Order;

$ingoing_orders = Order::where('type', '==', 'ingoing')->paginate(18, ['*'], $pageName = 'ingoing', $page = null);
$outgoing_orders = Order::where('type', '==', 'outgoing')->paginate(18, ['*'], $pageName = 'outgoing', $page = null);

/** @var Order $ingoing_order */
/** @var Order $outgoing_order */

?>

<script xmlns:x-on="http://www.w3.org/1999/xhtml">


</script>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white overflow-hidden  shadow-sm sm:rounded-lg ">
                <div class="flex ml-10 mt-3 p-2">

                    <div class="m-7 ">
                        <a href="{{route('orders.create')}}"
                           class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm">Create a new Order</a>
                    </div>
                </div>


                <div class="  p-3 ml-10 mr-10  mb-10">


                    <div class="bg-gray-100 p-3 border rounded-md">
                        <div class="ml-10 mr-10  mt-3 text-center mb-3 p-3 border w rounded-md
                        border-green-400 bg-green-200 text-sm">
                            Ingoing Orders
                        </div>
                        <div class=" ml-10 mr-10 flex grid grid-cols-6">
                            @foreach($ingoing_orders as $ingoing_order)
                                <a class=" hover:bg-blue-50 p-3 m-2 border-green-400 border
                            rounded-md col-span-2  text-center bg-white"
                                   href="{{route('orders.show', $ingoing_order)}}">
                                    <div>
                                        <p> {{$ingoing_order->company->business_name}}</p>
                                        <p> {{$ingoing_order->date}}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div
                            class="ml-10 mt-3 mr-10">{{$ingoing_orders->appends(['ingoing' => $outgoing_orders->currentPage()])->links()}}</div>
                    </div>

                    <div class="bg-gray-100 p-3 mt-10 border rounded-md">
                        <div class="ml-10 mr-10 mt-3 text-center mb-3 p-3 border w rounded-md
                         border-green-400 bg-green-200 text-sm">
                            Outgoing Orders
                        </div>
                        <div class=" ml-10 mr-10 flex grid grid-cols-6">
                            @foreach($outgoing_orders as $outgoing_order)
                                <a class=" hover:bg-blue-50 p-3 m-2 border-green-400 border
                            rounded-md col-span-2  text-center bg-white"
                                   href="{{route('orders.show', $outgoing_order)}}">
                                    <div>
                                        @if($outgoing_order->company->business_name == null)
                                            <p>{{$outgoing_order->company->contact_name}}</p>
                                        @else
                                            <p>{{$outgoing_order->company->contact_name}}</p>
                                        @endif
                                        <p>{{$outgoing_order->date}}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div
                            class="ml-10 mt-3 mr-10">{{$outgoing_orders->appends(['ingoing' => $ingoing_orders->currentPage()])->links()}}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
