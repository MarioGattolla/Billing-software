<?php ?>

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
               x-on:keyup="searchProducts"
               x-on:keyup.down="selectNextProduct()"
               x-on:keyup.up="selectPreviousProduct()"

        />

        <div class="overflow-y-auto h-1/2 border-2"
             x-show="filteredProduct.length>0">

            <template x-for="(selected_product, index) in filteredProduct">
                <option class=" hover:cursor-pointer  p-2   rounded-md hover:bg-indigo-100"
                        @click="product_click(selected_product)"
                        x-text="selected_product.name "
                        :class="{'bg-indigo-100': index===selectedProductIndex}">
                </option>


            </template>

        </div>

        <div class=" p-2 rounded-md hover:bg-indigo-100 hover:cursor-pointer "
             x-on:click="tempCompanyId = company.id , company.id = null ,searchProducts"
             x-show="company.id != null">
            Check on all product
        </div>

    </div>

    <div class="col-span-1 items-center ">
        <div class="p-3  border center hover:cursor-pointer  rounded-md border-green-400 hover:bg-green-400
               bg-green-200 text-sm" x-on:click="modal = false">
            Return Back
        </div>
    </div>
</div>
