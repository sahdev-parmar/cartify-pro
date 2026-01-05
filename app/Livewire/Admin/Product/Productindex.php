<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('adminV1.layout.layout')]  //custom layout add // not global layout set for livewire
class Productindex extends Component
{
    use WithPagination,WithoutUrlPagination;

    public $showViewModal,$selectedProduct;
    public $showEditModal = false;

    public function render()
    {
        $categories = Category::all();

        $products = Product::with('category')
            ->whereHas('category', fn ($q) => $q->where('status', 1))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.product.productindex',[
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function viewProduct($id)
    {
        $this->showViewModal = true;
        $this->selectedProduct = Product::find($id);
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
    }

    public function editProduct($id)
    {
        $this->dispatch('openEditModal', productId: $id);  //pass data to edit livewire comonent
        $this->showEditModal = true;
    }

    #[On('closeEditModal')]
    public function closeEditModal()
    {
        $this->showEditModal = false;
    }
}
