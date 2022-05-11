<script>
    function formFilter() {
        return {
            radioItem:
                [
                    {id: 1, name: 'Ingoing Order'},
                    {id: 2, name: 'Outgoing Order'}
                ],

            company_type:
                [
                    {id: 0, name: null},
                    {id: 1, name: 'private'},
                    {id: 2, name: 'business'}
                ],
            selectedRadioID: 1,
            fields: [],
            modal: false,
            searchProductShow: false,
            searchProduct: '',
            searchCompanyAll: '',
            searchCompanyOnly: '',
            selectedProductIndex: 0,
            selectedCompanyIndex: 0,


            product: {
                id: null,
                name: null,
                description: null,
                quantity: null,
                price: null,
                vat: null,
            },
            company: {
                id: null,
                business_name: null,
                contact_name: null,
                country: null,
                address: null,
                email: null,
                phone: null,
                vat_number: null,
            },
            filteredProduct: [],
            filteredCompany: [],


            removeField(index) {
                this.fields.splice(index, 1);
            },

            searchProductsOutgoing(event) {

                if (event.keyCode > 36 && event.keyCode < 41) {
                    return event.preventDefault();
                }

                if (this.searchProduct === '') {
                    return this.filteredProduct = '';
                }
                axios.get('{{URL::to('/search/product')}}', {
                    'params': {'search': this.searchProduct}
                }).then(response => {
                    this.filteredProduct = response.data.data;
                });

                this.selectedProductIndex = 0;
            },


            searchProductsIngoing(event) {

                if (event.keyCode > 36 && event.keyCode < 41) {
                    return event.preventDefault();
                }

                if (this.searchProduct === '') {
                    return this.filteredProduct = '';
                }
                if (this.company.id == null) {
                    axios.get('{{URL::to('/search/product')}}', {
                        'params': {'search': this.searchProduct}
                    }).then(response => {
                        this.filteredProduct = response.data.data;
                    });
                } else {

                    axios.get('{{URL::to('/search/product_by_company')}}', {
                        'params': {'search': this.searchProduct, 'id': this.company.id}
                    }).then(response => {
                        console.log(response.data.data)
                        this.filteredProduct = response.data.data;
                    });
                }


                this.selectedProductIndex = 0;
            },

            searchCompaniesOnly(event) {

                if (event.keyCode > 36 && event.keyCode < 41) {
                    return event.preventDefault();
                }

                if (this.searchCompanyOnly === '') {
                    return this.filteredCompany = '';
                }
                axios.get('{{URL::to('/search/company/companies')}}', {
                    'params': {'search': this.searchCompanyOnly}
                }).then(response => {
                    this.filteredCompany = response.data.data;
                });

                this.selectedCompanyIndex = 0;
            },

            searchCompaniesPrivates(event) {

                if (event.keyCode > 36 && event.keyCode < 41) {
                    return event.preventDefault();
                }

                if (this.searchCompanyAll === '') {
                    return this.filteredCompany = '';
                }
                axios.get('{{URL::to('/search/company/all')}}', {
                    'params': {'search': this.searchCompanyAll}
                }).then(response => {
                    this.filteredCompany = response.data.data;
                });

                this.selectedCompanyIndex = 0;
            },


            reset() {
                this.searchProductShow = false;
                this.searchProduct = '';
                this.searchCompanyAll = '';
                this.company = [];
                this.company_type = 0;
                this.fields = [];
                this.searchProductShow = false;
                this.searchProduct = '';
                this.filteredProduct = [];
                this.filteredCompany = [];

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

            selectNextCompany() {
                if (this.selectedCompanyIndex === '') {
                    this.selectedCompanyIndex = 0;
                } else {
                    if (this.selectedCompanyIndex < this.filteredCompany.length - 1) {
                        this.selectedCompanyIndex++;

                    }
                }
            },

            selectPreviousCompany() {
                if (this.selectedCompanyIndex === '') {
                    this.selectedCompanyIndex = 0;
                } else {

                    if (this.selectedCompanyIndex > 0) {
                        this.selectedCompanyIndex--;
                    }
                }
            },

            set_total(index) {
                no_vat_total = this.fields[index].price * this.fields[index].quantity;
                vat_total = Math.round((no_vat_total * this.fields[index].vat) / 100);
                this.fields[index].total = no_vat_total + vat_total;
            },

            product_click(selected_product) {
                product = selected_product;
                this.modal = false;
                this.searchProduct = '';
                this.filteredProduct = [];
                this.fields.push({
                    name: product.name,
                    description: product.description,
                    price: product.price,
                    vat: product.vat,
                    quantity: '',
                    total: ''
                });
            },

            company_all_click(company) {
                if (company.business_name === '') {
                    this.company_type = 1;

                } else {
                    this.company_type = 2;

                }
                this.filteredCompany = [];

                return company;
            },

            company_only_click(company) {
                this.company_type = 2
                this.filteredCompany = [];

                return company;
            },

            new_business() {
                this.company = [];
                this.company_type = 2;

            },


            new_private() {
                this.company = [];
                this.company_type = 1;

            }


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
                                        <input x-model="selectedRadioID" type="radio" :value="item.id"
                                               x-on:click="reset()"/>
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
                                <div class=" rounded-md  flex-col  pt-2 ">

                                    <p>Select the Company</p>
                                    <input class="w-1/3 flex-col "
                                           autocomplete="off"
                                           type="search"
                                           id="searchCompanyOnly"
                                           x-model="searchCompanyOnly"
                                           placeholder="Search for Company"
                                           @click.away="searchCompanyOnly = '' , filteredCompany = 0"
                                           x-on:keyup="searchCompaniesOnly"
                                           x-on:keyup.down="selectNextCompany()"
                                           x-on:keyup.up="selectPreviousCompany()"

                                    />


                                    <div class="overflow-y-auto bg-white w-1/3 h-1/2 border-2"
                                         x-show="filteredCompany.length>0">
                                        <template x-for="(selected_company, index) in filteredCompany">
                                            <option class=" p-2   rounded-md hover:bg-indigo-100"
                                                    @click="company = selected_company ,  company_only_click(company)"
                                                    x-text="selected_company.contact_name + selected_company.business_name "
                                                    :class="{'bg-indigo-100': index===selectedCompanyIndex}">
                                            </option>

                                        </template>
                                    </div>

                                    <button type="button"
                                            class=" bg-green-200 p-1 border border-green-300  rounded-md m-2"
                                            x-on:click="new_business">New Company
                                    </button>

                                    <div class="flex" x-show="company_type == 2">
                                        <div class="m-3">
                                            <p>Name</p>
                                            <input type="text" x-model="company.business_name" id="company_name"
                                                   name="company_name"/>

                                            <p>Email</p>
                                            <input type="text" x-model="company.email" id="company_email"
                                                   name="company_email"/>
                                        </div>
                                        <div class="m-3">
                                            <p>Country</p>
                                            <input type="text" x-model="company.country" id="company_country"
                                                   name="company_country"/>

                                            <p>Address</p>
                                            <input type="text" x-model="company.address" id="company_address"
                                                   name="company_address"/>
                                        </div>
                                        <div class="m-3">
                                            <p>Phone</p>
                                            <input type="text" x-model="company.phone" id="company_phone"
                                                   name="company_phone"/>

                                            <p>Vat Number</p>
                                            <input type="text" x-model="company.vat_number" id="company_vat"
                                                   name="company_vat"/>
                                        </div>
                                    </div>
                                </div>

                                <p class="mt-2">Select the Products</p>
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
                                                            <input x-model="field.quantity" type="number"
                                                                   name="quantity[]"
                                                                   x-on:input="set_total(index)"
                                                                   class="w-full border-gray-400"/>
                                                        </label></td>
                                                    <td><label>
                                                            <input x-model="field.total" type="number" name="total[]"
                                                                   class="w-full border-gray-400"/>
                                                        </label></td>
                                                    <td class="text-center">
                                                        <button type="button" class="w-full"
                                                                @click="removeField(index)">
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
                                </div>

                                <div x-show="modal == true"
                                     class="fixed top-0 right-0 left-0 w-full h-full bg-gray-100 bg-opacity-75 flex
                             items-center  ">
                                    <div class="  bg-white rounded-md border m-auto w-1/3 text-center
                            rounded-md border-2 p-3  ">
                                        <div class="m-3">
                                            <div>
                                                Search for the product
                                            </div>
                                        </div>

                                        <div class=" rounded-md  flex-col  p-2 ">
                                            <input class="w-full flex-col"
                                                   autocomplete="off"
                                                   type="search"
                                                   id="searchProduct"
                                                   x-model="searchProduct"
                                                   placeholder="Search for Product"
                                                   @click.away="searchProduct = '', filteredProduct = 0"
                                                   x-on:keyup="searchProductsIngoing"
                                                   x-on:keyup.down="selectNextProduct()"
                                                   x-on:keyup.up="selectPreviousProduct()"

                                            />


                                            <div class="overflow-y-auto h-1/2 border-2"
                                                 x-show="filteredProduct.length>0">

                                                <template x-for="(selected_product, index) in filteredProduct">
                                                    <option class=" p-2   rounded-md hover:bg-indigo-100"
                                                            @click="product_click(selected_product)"
                                                            x-text="selected_product.name "
                                                            :class="{'bg-indigo-100': index===selectedProductIndex}">
                                                    </option>


                                                </template>
                                            </div>
                                            <div class=" p-2 rounded-md hover:bg-indigo-100" x-on:click="searchProductsOutgoing"  x-show="filteredProduct.length == 0">
                                               Check on all product
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

                            <div x-show="selectedRadioID == 2"
                                 class="pt-1"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-90"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-90">
                                <div class=" rounded-md  flex-col  pt-2 ">

                                    <p>Select the Company/Private</p>
                                    <input class="w-1/3 flex-col "
                                           autocomplete="off"
                                           type="search"
                                           id="searchCompanyAll"
                                           x-model="searchCompanyAll"
                                           placeholder="Search for Company"
                                           @click.away="searchCompanyAll = '', filteredCompany = 0 "
                                           x-on:keyup="searchCompaniesPrivates"
                                           x-on:keyup.down="selectNextCompany()"
                                           x-on:keyup.up="selectPreviousCompany()"

                                    />


                                    <div class="overflow-y-auto w-1/3    bg-white h-1/2 border-2"
                                         x-show="filteredCompany.length>0">
                                        <template x-for="(selected_company, index) in filteredCompany">
                                            <option class=" p-2   rounded-md hover:bg-indigo-100"
                                                    @click="company = selected_company ,  company_all_click(company)"
                                                    x-text="selected_company.contact_name + selected_company.business_name "
                                                    :class="{'bg-indigo-100': index===selectedCompanyIndex}">
                                            </option>

                                        </template>
                                    </div>

                                    <button type="button" id="button1 "
                                            class=" bg-green-200 p-1 border border-green-300  rounded-md m-2"
                                            x-on:click="new_business">New Company
                                    </button>
                                    <button type="button" id="button1 "
                                            class=" bg-green-200 p-1 border border-green-300  rounded-md m-2"
                                            x-on:click="new_private">New Private
                                    </button>

                                    <div class="flex" x-show="company_type == 1">

                                        <div class="m-3">
                                            <p>Name</p>
                                            <input type="text" x-model="company.contact_name" id="private_name"
                                                   name="private_name"/>

                                            <p>Email</p>
                                            <input type="email" x-model="company.email" id="private_email"
                                                   name="private_email"/>

                                            <p>Country</p>
                                            <input type="text" x-model="company.country" id="private_country"
                                                   name="private_country"/>
                                        </div>
                                        <div class="m-3">
                                            <p>Address</p>
                                            <input type="text" x-model="company.address" id="private_email"
                                                   name="private_email"/>

                                            <p>Phone</p>
                                            <input type="text" x-model="company.phone" id="private_phone"
                                                   name="private_phone"/>

                                        </div>
                                    </div>

                                    <div class="flex" x-show="company_type == 2">
                                        <div class="m-3">
                                            <p>Name</p>
                                            <input type="text" x-model="company.business_name" id="company_name"
                                                   name="company_name"/>

                                            <p>Email</p>
                                            <input type="text" x-model="company.email" id="company_email"
                                                   name="company_email"/>
                                        </div>
                                        <div class="m-3">
                                            <p>Country</p>
                                            <input type="text" x-model="company.country" id="company_country"
                                                   name="company_country"/>

                                            <p>Address</p>
                                            <input type="text" x-model="company.address" id="company_address"
                                                   name="company_address"/>
                                        </div>
                                        <div class="m-3">
                                            <p>Phone</p>
                                            <input type="text" x-model="company.phone" id="company_phone"
                                                   name="company_phone"/>

                                            <p>Vat Number</p>
                                            <input type="text" x-model="company.vat_number" id="company_vat"
                                                   name="company_vat"/>
                                        </div>
                                    </div>

                                </div>

                                <p class="mt-2">Select the Products</p>
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
                                                            <input x-model="field.quantity" type="number"
                                                                   name="quantity[]"
                                                                   x-on:input="set_total(index)"
                                                                   class="w-full border-gray-400"/>
                                                        </label></td>
                                                    <td><label>
                                                            <input x-model="field.total" type="number" name="total[]"
                                                                   class="w-full border-gray-400"/>
                                                        </label></td>
                                                    <td class="text-center">
                                                        <button type="button" class="w-full"
                                                                @click="removeField(index)">
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
                                         class="fixed top-0 right-0 left-0 w-full h-full bg-gray-100 bg-opacity-75 flex
                             items-center  ">
                                        <div class="  bg-white rounded-md border m-auto w-1/3 text-center
                            rounded-md border-2 p-3  ">
                                            <div class="m-3">
                                                <div>
                                                    Search for the product
                                                </div>
                                            </div>

                                            <div class=" rounded-md  flex-col  p-2 ">
                                                <input class="w-full flex-col"
                                                       autocomplete="off"
                                                       type="search"
                                                       id="searchProduct"
                                                       x-model="searchProduct"
                                                       placeholder="Search for Product"
                                                       @click.away="searchProduct = '', filteredProduct = 0"
                                                       x-on:keyup="searchProductsOutgoing"
                                                       x-on:keyup.down="selectNextProduct()"
                                                       x-on:keyup.up="selectPreviousProduct()"

                                                />


                                                <div class="overflow-y-auto h-1/2 border-2"
                                                     x-show="filteredProduct.length>0">
                                                    <template x-for="(selected_product, index) in filteredProduct">
                                                        <option class=" p-2   rounded-md hover:bg-indigo-100"
                                                                @click="product_click(selected_product)"
                                                                x-text="selected_product.name "
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

                                <button
                                    class="w-1/5 bg-green-200 mt-3 h-10 rounded-md border border-green-400 hover:bg-green-400 type="
                                    type="submit">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
