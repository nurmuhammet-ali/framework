<?php

namespace Shopper\Framework\Http\Livewire\Categories;

use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Shopper\Framework\Traits\WithSeoAttributes;
use Shopper\Framework\Traits\WithUploadProcess;
use Shopper\Framework\Http\Livewire\AbstractBaseComponent;
use Shopper\Framework\Repositories\Ecommerce\CategoryRepository;

class Edit extends AbstractBaseComponent
{
    use WithFileUploads;

    use WithUploadProcess;

    use WithSeoAttributes;

    public $category;

    public int $categoryId;

    public string $name = '';

    public ?int $parent_id = null;

    public ?string $description = null;

    public bool $is_enabled = false;

    public $seoAttributes = [
        'name' => 'name',
        'description' => 'description',
    ];

    protected $listeners = [
        'mediaDeleted',
        'trix:valueUpdated' => 'onTrixValueUpdate',
    ];

    public function mount($category)
    {
        $this->category = $category;
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->parent_id = $category->parent_id;
        $this->description = $category->description;
        $this->is_enabled = $category->is_enabled;
        $this->updateSeo = true;
        $this->seoTitle = $category->seo_title;
        $this->seoDescription = $category->seo_description;
    }

    public function onTrixValueUpdate($value)
    {
        $this->description = $value;
    }

    /**
     * Define is the current action is create or update for the SEO Trait.
     *
     * @return false
     */
    public function isUpdate(): bool
    {
        return true;
    }

    public function store()
    {
        $this->validate($this->rules());

        $this->category->update([
            'name' => $this->name,
            'slug' => $this->name,
            'parent_id' => $this->parent_id,
            'description' => $this->description,
            'is_enabled' => $this->is_enabled,
            'seo_title' => $this->seoTitle,
            'seo_description' => str_limit($this->seoDescription, 157),
        ]);

        if ($this->file) {
            $this->category->addMedia($this->file->getRealPath())->toMediaCollection(config('shopper.system.storage.disks.uploads'));
        }

        session()->flash('success', __('Category successfully updated!'));

        $this->redirectRoute('shopper.categories.index');
    }

    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'max:150',
                Rule::unique(shopper_table('categories'), 'name')->ignore($this->categoryId),
            ],
            'file' => 'sometimes|nullable|image|max:1024',
        ];
    }

    /**
     * Listen when a file is removed from the storage
     * and update the user screen and remove image preview.
     */
    public function mediaDeleted()
    {
        $this->media = null;
    }

    public function render()
    {
        return view('shopper::livewire.categories.edit', [
            'categories' => (new CategoryRepository())
                ->makeModel()
                ->scopes('enabled')
                ->select('name', 'id')
                ->get()
                ->except($this->category->id),
            'media' => $this->category->getFirstMedia(config('shopper.system.storage.disks.uploads')),
        ]);
    }
}
