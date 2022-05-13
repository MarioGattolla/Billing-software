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
            tempCompanyId: null,

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


            searchProducts(event) {

                if (event.keyCode > 36 && event.keyCode < 41) {
                    return event.preventDefault();
                }

                if (this.searchProduct === '') {
                    return this.filteredProduct = '';
                }

                if (this.selectedRadioID == 2) {
                    axios.get('{{URL::to('/search/product')}}', {
                        'params': {'search': this.searchProduct}
                    }).then(response => {
                        this.filteredProduct = response.data.data;
                    });

                    this.selectedProductIndex = 0;

                } else {
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
                            if (response.data.data == null) {
                                this.filteredProduct = [];
                            } else {
                                this.filteredProduct = response.data.data;
                                this.selectedProductIndex = 0;
                            }
                        });
                    }

                }
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
                    id: product.id,
                    name: product.name,
                    description: product.description,
                    price: product.price,
                    vat: product.vat,
                    quantity: '',
                    total: ''
                });
                if (this.tempCompanyId != null) {
                    this.company.id = this.tempCompanyId;
                }
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
            },


        }

    }


</script>

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" ml-20 mt-10 bg-white  text-xl">
                    New Order
                </div>
                <div class="m-10 ">


                    <div x-data="formFilter()" class="bg-gray-100 p-10 max-w border rounded-md">


                        <form method="POST" x-on:keydown.enter="event.preventDefault()"
                              action="{{route('orders.store')}}" name="orders_create_form">
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

                            <input x-model="company.id" type="text" name="company.id" hidden/>

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
                                            <option class=" p-2 hover:cursor-pointer   rounded-md hover:bg-indigo-100"
                                                    x-on:keyup.enter.window="company = selected_company ,  company_only_click(company)"
                                                    @click="company = selected_company ,  company_only_click(company)"
                                                    x-text="selected_company.contact_name + selected_company.business_name "
                                                    :class="{'bg-indigo-100': index===selectedCompanyIndex}">
                                            </option>

                                        </template>
                                    </div>

                                    <x-elements.button x-on:click="new_business">New Company</x-elements.button>

                                    <div class="flex" x-show="company_type == 2">
                                        <x-companies.business-main-data/>
                                    </div>
                                </div>


                                <div x-show="modal == true" class="fixed top-0 right-0 left-0 w-full
                                h-full bg-gray-100 bg-opacity-75 flex items-center  "
                                     x-on:keyup.escape.window="modal = false">

                                    <x-orders.create.product-search-with-modal/>

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

                                    <x-elements.button x-on:click="new_business">New Company</x-elements.button>

                                    <x-elements.button x-on:click="new_private">New Private</x-elements.button>

                                    <div class="flex" x-show="company_type == 1">
                                        <x-companies.private-main-data/>
                                    </div>

                                    <div class="flex" x-show="company_type == 2">
                                        <x-companies.business-main-data/>
                                    </div>

                                </div>


                                <div x-show="modal == true" class="fixed top-0 right-0 left-0 w-full
                                 h-full bg-gray-100 bg-opacity-75 flex items-center "
                                     x-on:keyup.escape.window="modal = false">

                                    <x-orders.create.product-search-with-modal/>

                                </div>
                            </div>
                            <div>
                                <x-orders.create.order-product-table/>
                            </div>

                            <x-elements.button type="submit" class="w-1/5 bg-green-200 mt-3 h-10 rounded-md
                                  border border-green-400 hover:bg-green-400 ">
                                Submit
                            </x-elements.button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
