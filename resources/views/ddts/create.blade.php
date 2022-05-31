<?php

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
            selectedRadioID: 0,
            filteredCompany: [],
            searchCompany: '',
            selectedCompanyIndex: 0,


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
                                    />

                                </label>
                                <label x-text="item.name"></label>
                            </div>

                        </template>

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
                                <option class=" p-2   rounded-md hover:bg-indigo-100"
                                        @click="company = selected_company ,  company_all_click(company)"
                                        x-text="selected_company.contact_name + selected_company.business_name "
                                        :class="{'bg-indigo-100': index===selectedCompanyIndex}">
                                </option>

                            </template>
                        </div>

                        <div x-show="selectedRadioID == 0">
                            <div>
                                <div>
                                    <p class="mt-2">Progressive N#</p>
                                    <label>
                                        <input type="text" class=" mt-2 w-20 mb-2" name="progressive"/>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <p>Date</p>
                                <label>
                                    <input type="date" value="{{today()->format('Y-m-d')}}" class="mt-2 mb-2"
                                           name="date" min="{{today()->subMonth()}}"/>
                                </label>


                                <p>Causal</p>
                                <label>
                                    <input type="text" class="mt-2 mb-2" name="causal"/>
                                </label>
                            </div>

                            <div>
                                <input type="file" class="mt-2 mb-2" name="file"/>
                            </div>
                        </div>

                        <div class="bg-teal-300 p-2 rounded-md mt-2" x-show="selectedRadioID == 1">

                            <div class=" flex m-3 ">
                                <svg class="fill-current h-8 w-8 mr-2" width="54" height="54" viewBox="0 0 54 54"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.5 22.1c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 38.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z"/>
                                </svg>
                                <span class="font-semibold text-xl tracking-tight ">Billing Software</span>
                            </div>

                            <div class="m-3 grid grid-cols-6">
                                <div class="flex col col-span-2">
                                    <div class="m-3 ">
                                        <p>Progressive</p>
                                        <label>
                                            <input type="number" class="w-20" name="progressive"/>
                                        </label>
                                    </div>

                                    <div class="m-3 ">
                                        <p>Date</p>
                                        <label>
                                            <input type="date" value="{{today()->format('Y-m-d')}}" class=""
                                                   name="date"/>
                                        </label>
                                    </div>
                                </div>

                                <div class=" bg-white col-span-2 p-2 m-3 border rounded border-black">
                                    <div>Seller:</div>
                                    <div>Billing Software SPA</div>
                                    <div> 12541685322</div>
                                    <div> Via Mario 1 70125</div>
                                    <div> Italy</div>
                                    <div> 0805254875</div>
                                    <div> Mario@mario.mario</div>

                                </div>

                                <div class=" bg-white col-span-2 p-2 m-3 border rounded border-black">
                                    <div>Recipient:</div>
                                    <div x-text="company.contact_name"></div>
                                    <div x-text="company.vat_number"></div>
                                    <div x-text="company.business_name"></div>
                                    <div x-text="company.address"></div>
                                    <div x-text="company.country"></div>
                                    <div x-text="company.phone"></div>
                                    <div x-text="company.email"></div>
                                </div>

                            </div>

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
