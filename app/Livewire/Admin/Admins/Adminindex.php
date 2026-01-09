<?php

namespace App\Livewire\Admin\Admins;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('adminV1.layout.layout')]  //custom layout add // not global layout set for livewire
class Adminindex extends Component
{
    public $showAddModal;
    public $showEditModal,$editUserId;
    public $showViewModal,$viewUserId;
    public $deleteid;
    public $search = '';
    public $typeFilter = 'all';
    public $statusFilter = 'all';
    public $sessionFilter = 'all';

    public function render()
    {
        $admins = User::whereIn('type',['admin','superadmin']);
        
            if($this->search){
                $admins->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('mobile_number', 'like', '%' . $this->search . '%');
                });
            }

            if ($this->typeFilter != 'all') {
                $admins->where('type', $this->typeFilter);
            }

            if ($this->statusFilter != 'all') {
                $admins->where('status', $this->statusFilter);
            }

            if ($this->sessionFilter === 'active') {
                    $admins->whereIn('id', function($q) {
                    $q->select('user_id')
                    ->from('sessions')
                    ->whereRaw('last_activity > ?', [now()->subMinutes(5)->timestamp])
                    ->whereNotNull('user_id');
            });
            } elseif ($this->sessionFilter === 'inactive') {
                    $admins->whereNotIn('id', function($q) {
                    $q->select('user_id')
                    ->from('sessions')
                    ->whereRaw('last_activity > ?', [now()->subMinutes(5)->timestamp])
                    ->whereNotNull('user_id');
            });
        }


        $admins = $admins->latest()->paginate(10);

        foreach ($admins as $admin) {
            $admin->has_active_session = $this->hasActiveSession($admin->id);
        }

        return view('livewire.admin.admins.adminindex',[
            'admins' => $admins
        ]);
    }

    public function resetFilters()
    {
        $this->reset('typeFilter','sessionFilter','statusFilter');
    }

    public function hasActiveSession($userId)
    {
        return DB::table('sessions')
            ->where('user_id', $userId)
            ->whereRaw('last_activity > ?', [now()->subMinutes(5)->timestamp])
            ->exists();
    }

    public function revokeAllSessions($userId)
    {
        DB::table('sessions')
            ->where('user_id', $userId)
            ->delete();

        session()->flash('message', 'All sessions revoked successfully.');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => !$user->status]);
    }

    #[On('closeAddModal')]
    public function closeAddModal()
    {
        $this->showAddModal = false;
    }

    #[On('closeEditModal')]
    public function closeEditModal()
    {
        $this->showEditModal = false;
    }

    #[On('closeAdminViewModal')]
    public function closeAdminViewModal()
    {
        $this->showViewModal = false;
    }

    #[On('editModalOpen')]
    public function editUser($id)
    {
        $this->showEditModal = true;
        $this->showViewModal = false;
        $this->editUserId = $id;
    }

    public function viewUser($id)
    {
        $this->showViewModal = true;
        $this->viewUserId = $id;    
    }

   public function deleteUser($id)
    {
        $this->deleteid = $id;
        $this->dispatch('confirmMessage',text: 'ou Want To Delete This User Account!');
    }

    public function Confirmdelete()
    {
        User::find($this->deleteid)->delete();
        $this->dispatch('doneMessage',text: 'Succesfully Delete User Account!',title : 'Deleted!');
    }

}
