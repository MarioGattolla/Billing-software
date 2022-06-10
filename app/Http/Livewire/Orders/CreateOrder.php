<?php

namespace App\Http\Livewire\Orders;

use App\Actions\Orders\CreateNewOrder;
use App\Enums\OrderType;
use App\Http\Concerns\SearchesCompanies;
use App\Models\Company;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Redirector;
use LivewireUI\Modal\ModalComponent;

class CreateOrder extends ModalComponent
{
    use SearchesCompanies;

    public string $type = 'incoming';

    public Order $order;

    /** @var array|Collection<int, OrderProduct>  */
    public array|Collection $order_products;

    public string $date;

    protected $listeners = [
        'order.product.selected' => 'add_row',
    ];

    public array $rules = [
        'company.id' => 'required',
        'company.name' => 'required|string',
        'company.country' => 'required|string',
        'company.address' => 'required|string',
        'company.vat_number' => 'nullable|string',
        'company.phone' => 'required|string',
        'company.email' => 'required|email',

        'order_products.*.quantity' => 'required|integer',

        'date' => 'required|date',
        'order.type' => 'required|string',
    ];

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function allow_new_company(): bool
    {
        return true;
    }

    public function mount(): void
    {
        $this->order = new Order([
            'type' => OrderType::outcoming
        ]);
        $this->order_products = Collection::empty();
        $this->date = today()->format('Y-m-d');
    }

    public function render(): View
    {
        return view('livewire.orders.create-order')->with([
            'filtered_companies' => $this->search_companies(),

        ]);
    }

    public function hydrateOrderProducts(array $order_products){
       $this->order_products = Collection::make($order_products)
           ->mapInto(OrderProduct::class);
    }

    public function dehydrateOrderProducts(Collection $order_products){
        $this->order_products = $order_products->toArray();
    }

    public function add_row(Product $product)
    {
        $row = OrderProduct::make([
            'product_id' =>  $product->id,
            'price' => $product->price,
            'vat' => $product->vat,
            'quantity' => 1,
        ]);
        $row->setRelation('product', $product);


        $this->order_products->push($row);
    }

    public function remove_row(int $index){
        $this->order_products->pull($index);
    }

    public function save(): Redirector|RedirectResponse
    {
        $this->validate();

        $this->company->save();

        $this->order->company_id = $this->company->id;
        $this->order->date = Carbon::make($this->date);
        $this->order->save();

        $this->order_products->each(function (OrderProduct $order_product){
            $order_product->order_id = $this->order->id;
            $order_product->save();
        });


        return redirect()->route('orders.index')->with('success', 'Order created !!');
    }

}

