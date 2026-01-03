<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('adminV1.layout.layout')]  //custom layout add // not global layout set for livewire
class CategoryIndex extends Component
{
    use WithFileUploads;
    use WithPagination,WithoutUrlPagination;


    public $showModal = false;
    public $categoryId,$categoryimage,$deleteId;
    public $name,$description,$slug,$image,$status;
    public $statusFilter = "all",$search;
    public function render()
    {
        $categories = Category::latest()->where('name', 'like', '%'.$this->search.'%');
        if($this->statusFilter != 'all'){
            $categories->whereStatus($this->statusFilter);
        }
        $categories = $categories->paginate(5);

        return view('livewire.admin.categories.category-index',[
            'categories' => $categories,
        ]);
         
    }

    public function openModal()
    {
        
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->reset('name','slug','description','image','status','categoryId','categoryimage');
        $this->resetValidation();
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
            'slug' => 'required|unique:categories,slug',
            'description' => 'nullable',
            'image' => $this->categoryId ? 'nullable' : 'required'.'|image|mimes:jpeg,png,jpg',
            'status' => 'required|integer'
        ],
        [
            'status.*' => 'Please Select status'
        ]);
        
        if($this->categoryId){                      //dynamic in one modal edit and create
            $category = Category::find($this->categoryId);
            $category->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'status' => $this->status
            ]);

            session()->flash('message', 'Category edited successfully.');

        }else{
           $category = Category::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'status' => $this->status
            ]);

            session()->flash('message', 'Category created successfully.');
        }

        if($this->image){
            $extension = $this->image->getClientOriginalExtension();
            $categoryImage = "category_" .$category->id. "_" .now()->format('mdy').".".$extension;
            $this->image->storeAs('uploads/category',$categoryImage,'public');

            $category->image = $categoryImage;
        }
        $category->save();

        $this->closeModal();
    }

    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);
        $category->update(['status' => !$category->status]);
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->status = $category->status;
        $this->description = $category->description;
        $this->categoryimage = $category->image;
        
        $this->showModal = true;
        $this->categoryId = $id;

    }

    public function deleteCategory($id){
        $this->deleteId = $id;
        $this->dispatch('confirmMessage',text: 'You Want To Delete This Categpory!');
    }
    
    public function Confirmdelete()
    {
        Category::find($this->deleteId)->delete();
        $this->dispatch('doneMessage',text: 'Succesfully Delete Categpory!',title : 'Deleted!');
        $this->deleteId = null;

    }
}
