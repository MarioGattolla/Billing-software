<?php ?>
<div class="m-3 flex">
    <div class="m-3">
        <p>Name</p>
        <input type="text" x-model="company.name" value="{{null}}" id="name"
               name="company[name]"/>
    </div>
    <div class="m-3"><p>Email</p>
        <input type="text" x-model="company.email" value="{{null}}" id="email"
               name="company[email]"/>
    </div>
</div>
<div class="m-3 flex">
    <div class="m-3">
        <p>Country</p>
        <input type="text" x-model="company.country" value="{{null}}" id="country"
               name="company[country]"/>
    </div>
    <div class="m-3">
        <p>Address</p>
        <input type="text" x-model="company.address" value="{{null}}" id="address"
               name="company[address]"/>
    </div>
</div>
<div class="m-3 flex">
    <div class="m-3">
        <p>Phone</p>
        <input type="text" x-model="company.phone" value="{{null}}" id="phone"
               name="company[phone]"/>
    </div>
    <div class="m-3">
        <p>Vat Number</p>
        <input type="text" x-model="company.vat_number" value="{{null}}" id="vat_number"
               name="company[vat_number]"/>
    </div>
</div>
