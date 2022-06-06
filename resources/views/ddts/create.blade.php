<?php
$actual_progressive = \App\Models\Ddt::where('type', '==', 'outgoing')->count() + 1;
?>

<script>

    function ddt_form() {
        return {
            radioItem:
                [
                    {id: 0, name: 'ingoing'},
                    {id: 1, name: 'outgoing'}
                ],

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
            selected_order: {
                id: null,
                date: null,
                type: null,
            },
            movements: [],
            selectedRadioID: 0,
            filteredCompany: [],
            filteredOrders: [],
            searchCompany: '',
            selectedCompanyIndex: 0,
            selectedOrderIndex: 0,

            modal: false,


            search_company_with_orders(event) {

                if (event.keyCode > 36 && event.keyCode < 41) {
                    return event.preventDefault();
                }

                if (this.searchCompany === '') {
                    return this.filteredCompany = '';
                }
                axios.get('{{URL::to('/search/company_with_orders')}}', {
                    'params': {'search': this.searchCompany, 'type': this.radioItem[this.selectedRadioID].name}
                }).then(response => {
                    this.filteredCompany = response.data.data;
                });

                this.selectedCompanyIndex = 0;
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
            company_all_click(company) {
                if (company.business_name === '') {
                    this.company_type = 1;

                } else {
                    this.company_type = 2;
                }
                this.filteredCompany = [];

                return company;
            },

            set_order() {
                axios.get('{{URL::to('/search/orders_by_company')}}', {
                    'params': {'company_id': this.company.id}
                }).then(response => {
                    this.filteredOrders = response.data.data;
                });
                this.modal = true;
            },

            set_movements(order) {
                console.log(order[1])
            },

            reset() {
                this.filteredCompany = [];
                this.searchCompany = '';
                this.selectedCompanyIndex = 0;
                this.company = [];

            },
        }
    }
</script>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="pb-10 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-elements.validation-errors :errors="$errors"/>

                <div class=" ml-20 mt-10 bg-white  text-xl ">
                    New DDT
                </div>
                <div x-data="ddt_form()" class="m-10 bg-gray-100 p-10 border rounded-md">
                    <form method="POST" enctype="multipart/form-data" action="{{route('ddts.store')}}"
                          name="ddts_create_form">
                        @csrf

                        <p>Type</p>
                        <template x-for="item in radioItem" :key="item.id">
                            <div class="p-1">
                                <label>
                                    <input x-model="selectedRadioID" type="radio" :value="item.id"
                                           x-on:click="reset()"
                                    />

                                </label>
                                <label x-text="item.name"></label>
                            </div>

                        </template>

                        <div class="flex">
                            <div class="m-3">
                                <p>Progressive N#</p>
                                <label>
                                    <input type="number" class=" mt-2 w-20 mb-2" name="progressive"/>
                                </label>
                            </div>

                            <div class="m-3">
                                <p>Date</p>
                                <label>
                                    <input type="date" value="{{today()->format('Y-m-d')}}" class="mt-2 mb-2"
                                           name="date" min="{{today()->subMonth()}}"/>
                                </label>
                            </div>
                            <div class="m-3">
                                <p>Causal</p>
                                <label>
                                    <input type="text" class="mt-2 mb-2" name="causal"/>
                                </label>
                            </div>
                        </div>
                        <p class="mt-2">Search for Company</p>
                        <label for="searchCompanyAll">
                        </label>
                        <label for="searchCompany"></label>
                        <input class="w-1/3 flex-col "
                               autocomplete="off"
                               type="search"
                               id="searchCompany"
                               x-model="searchCompany"
                               placeholder="Search for Company"
                               @click.away="searchCompany = '', filteredCompany = 0 "
                               x-on:keyup="search_company_with_orders"
                               x-on:keyup.down="selectNextCompany()"
                               x-on:keyup.up="selectPreviousCompany()"

                        />


                        <div class="overflow-y-auto w-1/3    bg-white h-1/2 border-2"
                             x-show="filteredCompany.length>0">
                            <template x-for="(selected_company, index) in filteredCompany">
                                <option class=" p-2 cursor-pointer   rounded-md hover:bg-indigo-100"
                                        @click="company = selected_company ,  company_all_click(company)"
                                        x-text="selected_company.contact_name + selected_company.business_name "
                                        :class="{'bg-indigo-100': index===selectedCompanyIndex}">
                                </option>

                            </template>
                        </div>


                        <div x-show="company.contact_name == ''">
                            <x-companies.business-main-data/>
                        </div>

                        <div x-show="company.business_name == ''">
                            <x-companies.private-main-data/>
                        </div>

                        <x-ddts.create-ddt-raws-table/>
                        <div class="mt-2 mb-2">
                            <input type="file" class="mt-2 mb-2" name="file"/>
                        </div>

                        <div x-show="modal == true" class="fixed top-0 right-0 left-0 w-full
                                h-full bg-gray-200   bg-opacity-75 flex items-center  "
                             x-on:keyup.escape.window="modal = false">
                            <x-ddts.ddt-modal-for-order-select/>
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
</x-app-layout>
