<?php

namespace Shopper\Framework\Http\Livewire\Products\Form;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Shopper\Framework\Repositories\Ecommerce\ProductRepository;
use Shopper\Framework\Traits\WithSeoAttributes;

class Seo extends Component
{
    use WithSeoAttributes;

    /**
     * Product Model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    public $product;

    /**
     * Product id.
     *
     * @var int
     */
    public $productId;

    /**
     * Product slug url.
     *
     * @var string
     */
    public $slug;

    /**
     * Component Mount method.
     *
     * @return void
     */
    public function mount($product)
    {
        $this->product = $product;
        $this->productId = $product->id;
        $this->slug = $product->slug;
        $this->seoTitle = $product->seo_title;
        $this->seoDescription = $product->seo_description;
    }

    /**
     * Store/Update a entry to the storage.
     *
     * @return void
     */
    public function store()
    {
        $this->validate([
            'slug' => [
                'required',
                Rule::unique(shopper_table('products'), 'sku')->ignore($this->productId),
            ]
        ]);

        (new ProductRepository())->getById($this->productId)->update([
            'slug' => str_slug($this->slug),
            'seo_title' => $this->seoTitle,
            'seo_description' => $this->seoDescription,
        ]);

        $this->emit('productHasUpdated', $this->productId);

        $this->notify([
            'title' => __("Updated"),
            'message' => __("Product successfully updated!"),
        ]);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('shopper::livewire.products.forms.form-seo');
    }
}