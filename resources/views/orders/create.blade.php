<script>
    function formFilter() {
        return {
            radioItem:
                [{id: 1, name: 'Ingoing Order'},
                    {id: 2, name: 'Outgoing Order'}],
            selectedRadioID: 1,
            fields: [],
            modal: false,
            search: '',
            selectedProductIndex: 0,
            product: {
                id: null,
                name: null,
                description: null,
                price: null,
                vat: null,
            },
            filteredProduct: [],

            addNewField() {
                this.fields.push({
                    name: '',
                    description: '',
                    price: '',
                    vat: '',
                    quantity: '',
                    total: ''
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            },

            searchProduct(event) {

                if (event.keyCode > 36 && event.keyCode < 41) {
                    return event.preventDefault();
                }

                if (this.search === '') {
                    return this.filteredProduct = '';
                }
                axios.get('{{URL::to('/orders/search')}}', {
                    'params': {'search': this.search}
                }).then(response => {
                    this.filteredProduct = response.data;
                });

                this.selectedProductIndex = 0;
            },

            reset() {
                this.search = '';
                this.filteredProduct = '';
            },

            selectNextProduct() {
                if (this.selectedProductIndex === '') {
                    this.selectedProductIndex = 0;
                } else {
                    if (this.selectedProductIndex < this.filteredProduct.length - 1) {
                        this.selectedProductIndex++;

                    }
                }
            },

            selectPreviousProduct() {
                if (this.selectedProductIndex === '') {
                    this.selectedProductIndex = 0;
                } else {

                    if (this.selectedProductIndex > 0) {
                        this.selectedProductIndex--;
                    }
                }
            },
        }


    }


</script>

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" ml-20 mt-10 bg-white  text-xl">
                    Here you can create a new Order
                </div>
                <div class="m-10 ">


                    <div x-data="formFilter()" class="bg-gray-100 p-10 max-w border rounded-md">


                        <form method="POST" action="{{route('orders.store')}}" name="orders_create_form">
                            @csrf
                            <template x-for="item in radioItem" :key="item.id">
                                <div class="p-1">
                                    <label>
                                        <input x-model="selectedRadioID" type="radio" :value="item.id" :id="item.name">
                                    </label>
                                    <label x-text="item.name"></label>

                                </div>
                            </template>
                            <div x-show="selectedRadioID == 1
                                " class="pt-1"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-90"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-90">
                                <p>Business</p>
                                <label for="business_name"></label><input class="rounded-md  " type="text" id="business_name" name="business_name"/>
                            </div>

                            <div x-show="selectedRadioID == 2"
                                 class="pt-1"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-90"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-90">
                                <p>Contact Name</p>
                                <label for="contact_name"></label><input class="rounded-md  " type="text" id="contact_name" name="contact_name"/>
                            </div>


                            <div class="row">
                                <div class="mt-4">
                                    <table class="table-fixed w-full  bg-white table-bordered rounded-md
                                     align-items-center table-sm border-gray-400 border">
                                        <thead class="bg-green-200 h-10 ">
                                        <tr>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th class="w-1/12">Price</th>
                                            <th class="w-1/12">Vat</th>
                                            <th class="w-1/12">Quantity</th>
                                            <th class="w-1/12">Total</th>
                                            <th class="w-10"></th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <template x-for="(field, index) in fields" :key="index">
                                            <tr class=" ">
                                                <td class=""><label>
                                                        <input x-model="field.name" type="text" name="name[]"
                                                                            class="w-full border-gray-400"/>
                                                    </label></td>
                                                <td class=""><label>
                                                        <input x-model="field.description" type="text"
                                                                            name="description[]"
                                                                            class="w-full border-gray-400"/>
                                                    </label></td>
                                                <td class=""><label>
                                                        <input x-model="field.price" type="number" name="price[]"
                                                                            class="w-full border-gray-400"/>
                                                    </label></td>
                                                <td class=""><label>
                                                        <input x-model="field.vat" type="number" name="vat[]"
                                                                            class="w-full border-gray-400"/>
                                                    </label></td>
                                                <td><label>
                                                        <input x-model="field.quantity" type="number" name="quantity[]"
                                                                   class="w-full border-gray-400"/>
                                                    </label></td>
                                                <td><label>
                                                        <input x-model="field.total" type="number" name="total[]"
                                                                   class="w-full border-gray-400"/>
                                                    </label></td>
                                                <td class="text-center">
                                                    <button type="button" class="w-full" @click="removeField(index)">
                                                        &times;
                                                    </button>
                                                </td>
                                            </tr>

                                        </template>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-left h-10">
                                                <button type="button" class=" bg-green-200 p-1
                                            border border-green-300  rounded-md m-2" x-on:click="modal = true">Add Row
                                                </button>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>

                                </div>

                                <div x-show="modal == true"
                                     class="fixed top-0 right-0 left-0  h-full w-full bg-gray-100 bg-opacity-75 flex
                             items-center  ">
                                    <div class="  bg-white rounded-md border m-auto w-1/3 text-center
                            rounded-md border-2 p-3 ">
                                        <div class="m-3">
                                            <div>
                                                Search for the product
                                            </div>
                                        </div>

                                        <div class=" rounded-md  flex-col w-1/3 p-2 ">
                                            <label for="search"></label><input class="w-full flex-col "
                                                                               autocomplete="off"
                                                                               type="search"
                                                                               id="search"
                                                                               x-model="search" placeholder="Search for Product"
                                                                               @click.away="reset()"
                                                                               x-on:keyup="searchProduct"
                                                                               x-on:keyup.down="selectNextProduct()"
                                                                               x-on:keyup.up="selectPreviousProduct()"

                                            />


                                            <div class="overflow-y-auto max-h-52 border-2"
                                                 x-show="filteredProduct.length>0">
                                                <template x-for="(selected_product, index) in filteredProduct">
                                                    <option class=" p-2   rounded-md hover:bg-indigo-100"
                                                            @click="product = selected_product"
                                                            x-text="selected_product.name + ' ' + selected_product.description"
                                                            :class="{'bg-indigo-100': index===selectedProductIndex}">
                                                    </option>

                                                </template>
                                            </div>
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


                            <div class="pt-2">
                                <p>Address</p>
                                <label for="address"></label><input class="rounded-md  " type="text" id="address" name="address" required/>
                            </div>

                            <div class="pt-2">
                                <p>Email</p>
                                <label for="email"></label><input class="rounded-md  " type="email" id="email" name="email" required/>
                            </div>


                            <div class="pt-2">
                                <p>Phone Number</p>
                                <label for="phone"></label><input class="rounded-md " type="text" id="phone" name="phone" required/>
                            </div>

                            <button
                                class="w-1/5 bg-green-200 mt-3 h-10 rounded-md border border-green-400 hover:bg-green-400 type="
                                type="submit">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
