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
    public $deleteId;
    public $search,$stockFilter = 'all',$categoryFilter = 'all';

    public function render()
    {
        $categories =  Category::where('status', 1)->get();

        $products = Product::latest()->where('name', 'like', '%'.$this->search.'%')
            ->whereHas('category', function ($query) {
            $query->where('status', 1); // Only products with active category
        });
            if($this->stockFilter != 'all'){ 
                $products->whereStock_status($this->stockFilter);
            }
            
            if($this->categoryFilter != 'all'){
                $products->whereCategory_id($this->categoryFilter);
            }
        
        $products = $products->paginate(10);

        return view('livewire.admin.product.productindex',[
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    #[On('message')]
    public function showMessage($message = null)
    {
       session()->flash('message', $message);
    }

    public function  resetFilters()
    {
        $this->reset('search','stockFilter','categoryFilter');
        session()->flash('message', 'Reset Filters successfully.');
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

    public function deleteProduct($id){
        $this->deleteId = $id;
        $this->dispatch('confirmMessage',text: 'You Want To Delete This Product!');
    }
    
    public function Confirmdelete()
    {
        Product::find($this->deleteId)->delete();
        $this->dispatch('doneMessage',text: 'Succesfully Delete Product!',title : 'Deleted!');
        $this->deleteId = null;

    }
}
