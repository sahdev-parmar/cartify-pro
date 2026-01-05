<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductEdit extends Component
{
    public $productId;


    #[On('openEditModal')]
    public function open($productId)
    {
        $this->productId = $productId;
    }

    public function render()
    {

        $categories = Category::all();

        return view('livewire.admin.product.product-edit',[
            'categories' => $categories
        ]);
    }

    public function closeEditModal()
    {
        $this->dispatch('closeEditModal'); //pass to index livewire component
    }
}
