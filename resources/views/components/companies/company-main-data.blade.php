<?php ?>
<div class="flex">
    <div class="m-3">
        <p> Name</p>
        <label>
            <input type="text" id="name" name="company[name]"
                   wire:model="company.name"/>
        </label>
    </div>
    <div class="m-3">
        <p> Country</p>
        <label>
            <input type="text" id="country" name="company[country]"
                   wire:model="company.country"/>
        </label>
    </div>
</div>
<div class="flex">
    <div class="m-3">
        <p> Address</p>
        <label>
            <input type="text" id="address" name="company[address]"
                   wire:model="company.address"/>
        </label>
    </div>
    <div class="m-3">
        <p> Email</p>
        <label>
            <input type="text" id="email" name="company[email]"
                   wire:model="company.email"/>
        </label>
    </div>
</div>
<div class="flex">
    <div class="m-3">
        <p> Phone</p>
        <label>
            <input type="text" id="phone" name="company[phone]"
                   wire:model="company.phone"/>
        </label>
    </div>
    <div class="m-3">
        <p> Vat</p>
        <label>
            <input type="text" id="vat_number" name="company[vat_number]"
                   wire:model="company.vat_number"/>
        </label>
    </div>
</div>
