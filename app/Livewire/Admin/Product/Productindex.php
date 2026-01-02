<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('adminV1.layout.layout')]  //custom layout add // not global layout set for livewire
class Productindex extends Component
{
    public $showViewModal,$selectedProduct;

    public function render()
    {
        $categories = Category::all();

        $products = Product::latest()->paginate(10);
        return view('livewire.admin.product.productindex',[
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
