<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('adminV1.layout.layout')]  //custom layout add // not global layout set for livewire
class ProductAdd extends Component
{
    public $currentStep = 3;
    public $category_id,$name,$slug,$images = [],$price,$sale_price;
    public $totalSteps;
    public function render()
    {
        $categories = Category::all();

        return view('livewire.admin.product.product-add',[
            'categories' => $categories,
        ]);
    }
}
