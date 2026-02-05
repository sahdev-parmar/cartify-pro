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
    public $search,$statusFilter = 'all';
    public $deleteid;

    public function render()
    {   
       $users = User::latest()->whereType('user')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('mobile_number', 'like', '%' . $this->search . '%');
        });

        if($this->statusFilter != 'all')
        {
            $users->whereStatus($this->statusFilter);
        }

        $users = $users->paginate(10);

        return view('livewire.admin.customers.customer-index',[
            'users' => $users
        ]);
    }

    #[On('message')]
    public function showMessage($message = null)
    {
       session()->flash('message', $message);
    }

    public function resetFilters()
    {
        $this->reset('statusFilter');    
        session()->flash('message', 'Reset Filters successfully.');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => !$user->status]);
        session()->flash('message', 'Update status successfully.');
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

    public function deleteUser($id)
    {
        $this->deleteid = $id;
        $this->dispatch('confirmMessage',text: 'ou Want To Delete This Customers Account!');
    }

    public function Confirmdelete()
    {
        User::find($this->deleteid)->delete();
        $this->dispatch('doneMessage',text: 'Succesfully Delete Customer Account!',title : 'Deleted!');
    }
}
