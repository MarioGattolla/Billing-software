<?php ?>

<div class="m-3">
    <p>Name</p>
    <input type="text" x-model="company.business_name" value="{{null}}" id="business_name"
           name="company[business_name]"/>

    <p>Email</p>
    <input type="text" x-model="company.email" value="{{null}}" id="email"
           name="company[email]"/>
</div>
<div class="m-3">
    <p>Country</p>
    <input type="text" x-model="company.country" value="{{null}}" id="country"
           name="company[country]"/>

    <p>Address</p>
    <input type="text" x-model="company.address" value="{{null}}" id="address"
           name="company[address]"/>
</div>
<div class="m-3">
    <p>Phone</p>
    <input type="text" x-model="company.phone" value="{{null}}" id="phone"
           name="company[phone]"/>

    <p>Vat Number</p>
    <input type="text" x-model="company.vat_number" value="{{null}}" id="vat_number"
           name="company[vat_number]"/>
</div>
