<?php

namespace Shopper\Framework\Http\Livewire\Settings\Inventories;

use Shopper\Framework\Rules\Phone;
use Shopper\Framework\Models\System\Country;
use Shopper\Framework\Models\Shop\Inventory\Inventory;
use Shopper\Framework\Http\Livewire\AbstractBaseComponent;

class Create extends AbstractBaseComponent
{
    public string $name = '';

    public ?string $description = null;

    public string $email = '';

    public string $city = '';

    public string $street_address = '';

    public ?string $street_address_plus = null;

    public ?string $zipcode = null;

    public ?string $phone_number = null;

    public ?int $country_id = null;

    public bool $isDefault = false;

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:' . shopper_table('inventories'),
            'name' => 'required|max:100',
            'city' => 'required',
            'street_address' => 'required',
            'zipcode' => 'required',
            'phone_number' => ['nullable', new Phone()],
            'country_id' => 'required|exists:' . shopper_table('system_countries') . ',id',
        ];
    }

    public function store()
    {
        $this->validate($this->rules());

        Inventory::query()->create([
            'name' => $this->name,
            'code' => str_slug($this->name),
            'email' => $this->email,
            'city' => $this->city,
            'description' => $this->description,
            'street_address' => $this->street_address,
            'street_address_plus' => $this->street_address_plus,
            'zipcode' => $this->zipcode,
            'phone_number' => $this->phone_number,
            'country_id' => $this->country_id,
            'is_default' => $this->isDefault,
        ]);

        session()->flash('success', __('Inventory Successfully Added.'));

        $this->redirectRoute('shopper.settings.inventories.index');
    }

    public function render()
    {
        return view('shopper::livewire.settings.inventories.create', [
            'countries' => Country::select('name', 'id')->orderBy('name')->get(),
        ]);
    }
}
