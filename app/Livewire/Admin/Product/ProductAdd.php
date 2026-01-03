<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('adminV1.layout.layout')]  //custom layout add // not global layout set for livewire
class ProductAdd extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $category_id,$name,$slug,$images = [],$price,$sales_count,$stock_status,$description;
    public $totalSteps = 3;

    public function render()
    {
        $categories = Category::all();

        return view('livewire.admin.product.product-add',[
            'categories' => $categories,
        ]);
    }

    public function updatingName($value)
    {
        $this->slug = Str::slug($value);
    }
    
    public function previousStep()
    {
        $this->currentStep--;
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    } 

    public function nextStep()
    {
        if($this->currentStep == 1){
            $this->validate([
                'category_id' => 'required|integer',
                'name' => 'required',
                'slug' => 'required|unique:products,slug',
                'description' => 'required'
            ],[
                'category_id.*' => 'Please select category',
                'name.required' => 'Product name is required',
                'slug.required' => 'Product slug is required',
                'slug.unique' => 'Product slug is aleredy exist please enter another name or slug',
                'description.required' => 'Product description is required',
            ]);
        }
        
        if($this->currentStep == 2){
            $this->validate([
                'images' => 'required',
                'images.*' => 'image',
                'price' => 'required'
            ],[
                'images.required' => 'Please uplods images',
                'images.image' => 'Please select image',
                'price.required' => 'Product price is required',
            ]);
        }

       
        $this->currentStep++;
    }

    public function save()
    {
        $this->validate([
            'stock_status' => 'required|integer',
            'sales_count' => 'required|integer'

        ],[
            'stock_status.*' => 'Please select stock status',
            'sales_count.*' => 'Please enter sales count'
        ]);

        $product = Product::create([
            'category_id' => $this->category_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'stock_status' => $this->stock_status,
            'sales_count' => $this->sales_count
        ]);

        if($this->images){
            foreach($this->images as $index => $image){
                $extension = $image->getClientOriginalExtension();
                $productImage = "product_" .$product->id. "_" . "$index" . "_" .now()->format('mdy').".".$extension;
                $image->storeAs('uploads/product',$productImage,'public');

                $imageNames[] = $productImage;
            }

            $product->images = implode(',',$imageNames);
        }

        $product->save(); 

        session()->flash('message', 'Product created successfully!');

        $this->reset();

    }
}
