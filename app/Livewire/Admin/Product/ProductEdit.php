<?php

namespace App\Livewire\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductEdit extends Component
{
    use WithFileUploads;

    public $productId;
    public $name,$slug,$stock_status,$sales_count,$category_id,$price,$description;
    public $images = [],$previwImages = [],$previwPrimarychange,$ImagePrimarychange;
    public $primaryImageIndex = 0,$primaryPreviewIndex = null;

    #[On('openEditModal')]
    public function open($productId)
    {
        $this->productId = $productId;
        $product = Product::find($productId);
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->category_id = $product->category_id;
        $this->stock_status = $product->stock_status;
        $this->sales_count = $product->sales_count;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->images = product_images($product->images);
        
    }

    public function render()
    {
        $categories = Category::all();

        return view('livewire.admin.product.product-edit',[
            'categories' => $categories,
        ]);
    }

    public function closeEditModal()
    {
        $this->dispatch('closeEditModal'); //pass to index livewire component
    }

    public function updatingName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }
    
    public function removePreviewImage($index)
    {
        unset($this->previwImages[$index]);
        $this->previwImages = array_values($this->previwImages);
    }

    public function makePreviewPrimary($index)
    {
        $this->previwPrimarychange = true;
        $this->primaryPreviewIndex = $index;
        $this->primaryImageIndex = null;
        $this->ImagePrimarychange =false;
    }

    public function makePrimary($index)
    {
        $this->previwPrimarychange = false;
        $this->primaryImageIndex = $index;
        $this->primaryPreviewIndex = null;
        $this->ImagePrimarychange = true;
    }

    public function updateProduct()
    {
        $product = Product::find($this->productId);
        if($this->ImagePrimarychange){
            [$this->images[0], $this->images[$this->primaryImageIndex]] = 
            [$this->images[$this->primaryImageIndex], $this->images[0]];
        }
        
        if($this->previwImages){

            // GET LAST IDEX OF IMAGE
            $lastImage = end($this->images); // get last value
            $nameWithoutExt = pathinfo($lastImage, PATHINFO_FILENAME);
            $parts = explode('_', $nameWithoutExt);
            $lastIndex = (int) $parts[2];
            $end = count($this->images);

            foreach($this->previwImages as $index => $image){
                $lastIndex = $lastIndex + 1; 
                $extension = $image->getClientOriginalExtension();
            
                $productImage = "product_" .$product->id. "_" . "$lastIndex" . "_" .now()->format('mdy').".".$extension;
                $image->storeAs('uploads/product',$productImage,'public');

                $this->images[] = $productImage;
            }

            if($this->previwPrimarychange){
                
                [$this->images[0], $this->images[$end + $this->primaryPreviewIndex]] = 
                [$this->images[$end + $this->primaryPreviewIndex], $this->images[0]];
            }
            
        }

        dd($this->images);

    }
}
