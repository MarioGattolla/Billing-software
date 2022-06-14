<?php

use App\Models\Order;

$ingoing_orders = Order::where('type', '=', 'ingoing')->paginate(18, ['*'], $pageName = 'ingoing', $page = null);
$outgoing_orders = Order::where('type', '=', 'outgoing')->paginate(18, ['*'], $pageName = 'outgoing', $page = null);

/** @var Order $ingoing_order */
/** @var Order $outgoing_order */

?>

<script xmlns:x-on="http://www.w3.org/1999/xhtml"></script>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-white overflow-hidden  shadow-sm sm:rounded-lg ">
                <div class="flex ml-10 mt-3 p-2">

                    <div class="m-7 ">
                        <button
                            class="p-3 border rounded-md border-green-400 hover:bg-green-400
                            bg-green-200 text-sm"

                            onclick="Livewire.emit('openModal', 'orders.create-order')"
                        >Create a new Order
                        </button>
                    </div>

                </div>
                <livewire:orders.index/>
            </div>
        </div>
    </div>
</x-app-layout>
