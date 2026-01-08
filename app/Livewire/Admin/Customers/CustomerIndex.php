<?php

namespace App\Livewire\Admin\Customers;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('adminV1.layout.layout')]  //custom layout add // not global layout set for livewire
class CustomerIndex extends Component
{
    public $showViewModal,$selectedUser;
    public $showEditModal,$editUserId;

    public function render()
    {   
        $users = User::paginate(10);
        return view('livewire.admin.customers.customer-index',[
            'users' => $users
        ]);
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => !$user->status]);
    }

    public function viewUser($id)
    {
        $this->selectedUser = User::find($id);
        $this->showViewModal = true;
    }
    
    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->reset('selectedUser');
        
    }

    public function editUser($id)
    { 
        $this->showEditModal = true; 
        $this->editUserId = $id;
    }

    #[On('closeUserEditModal')]
    public function closeModal()
    {
        $this->showEditModal = false; 
    }
}
