<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('adminV1.layout.layout')]  //custom layout add // not global layout set for livewire
class CategoryIndex extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $categoryId;
    public $name,$description,$slug,$image,$status;
    public function render()
    {
        $categories = Category::latest()->paginate(10);
        return view('livewire.admin.categories.category-index',[
            'categories' => $categories,
        ]);
         
    }

    public function openAddModal()
    {
        $this->reset('name','slug','description','image');
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    
    public function updatingName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required',
            'description' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'status' => 'required|integer'
        ],
        [
            'status.*' => 'Please Select status'
        ]);
        

        $category = Category::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status
        ]);

        if($this->image){
            $extension = $this->image->getClientOriginalExtension();
            $categoryImage = "category_" .$category->id. "_" .now()->format('mdy').".".$extension;
            $this->image->storeAs('uploads/category',$categoryImage,'public');

            $category->image = $categoryImage;
            $category->save();

        }

        $this->closeModal();
    }
}
