<?php ?>

<div class="m-3">
    <p>Name</p>
    <input type="text" x-model="company.contact_name" value="{{null}}" id="contact_name"
           name="contact_name"/>

    <p>Email</p>
    <input type="email" x-model="company.email" value="{{null}}" id="email"
           name="email"/>

    <p>Country</p>
    <input type="text" x-model="company.country" value="{{null}}" id="country"
           name="country"/>
</div>
<div class="m-3">
    <p>Address</p>
    <input type="text" x-model="company.address" value="{{null}}" id="address"
           name="address"/>

    <p>Phone</p>
    <input type="text" x-model="company.phone" value="{{null}}" id="phone"
           name="phone"/>

</div>
