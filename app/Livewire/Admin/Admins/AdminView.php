<?php

namespace App\Livewire\Admin\Admins;

use App\Models\User;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class AdminView extends Component
{
    #[Reactive] 
    public $viewUserId;

    public function render()
    {   
        $user = User::find($this->viewUserId);
        return view('livewire.admin.admins.admin-view',[
            'selectedAdmin' => $user
        ]);
    }

    public function closeViewModal()
    {
        $this->dispatch('closeAdminViewModal');
    }

    public function  editAdmin($id) 
    {
        $this->dispatch('editModalOpen', id:$id);
    }
}
