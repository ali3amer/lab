<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class User extends Component
{
    use LivewireAlert;
    protected $listeners = [
        'deleteUser',
    ];

    public $header = "المستخدمين";
    public $id = 0;
    public $user;
    #[Rule('required', message: 'أدخل إسم القسم')]
    public $username = "";
    public $name = "";
    public $password = "";
    public $searchUserName = "";
    public Collection $users;
    public array $permissions = [];
    public array $permissionsList = [
        ['patients', 'المرضى'],
        ['results', 'النتائج'],
        ['categories', 'الاقسام'],
        ['tests', 'التحاليل'],
        ['insurances', 'التأمينات'],
        ['employees', 'الموظفين'],
        ['visits', 'الزيارات'],
        ['users', 'المستخدمين'],
        ['expenses', 'المصروفات'],
        ['reports', 'التقارير'],
    ];

    public function mount()
    {
        if(!auth()->check()) {
            redirect("login");
        }
        $this->users = \App\Models\User::all();
    }

    public function getUsers()
    {
        $this->users = \App\Models\User::all();
    }

    public function searchUser()
    {
        $this->users = \App\Models\User::where('username', 'LIKE', '%' . $this->searchUserName . '%')->get();
    }

    public function saveUser()
    {
        $this->validate();
        if ($this->id == 0) {
            $user = \App\Models\User::create([
                'name' => $this->name,
                'username' => $this->username,
                'password' => Hash::make($this->password),
            ]);

            $user->addRole('user');

            $user->syncPermissions($this->permissions);
            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        } else {
            $user = \App\Models\User::find($this->id);
            $user->name = $this->name;
            $user->username = $this->username;
            if ($this->password != "") {
                $user->password = Hash::make($this->password);
            }
            if ($user->id != 1) {
                $user->syncPermissions($this->permissions);
            }
            $user->save();
            $this->alert('success', 'تم التعديل بنجاح', ['timerProgressBar' => true]);

        }
        $this->permissions = [];

        $this->getUsers();

        $this->resetUserData();
    }

    public function editUser($user)
    {
        $this->resetUserData();
        $this->permissions = \App\Models\User::find($user['id'])->allPermissions()->pluck('name')->toArray();
        $this->id = $user['id'];
        $this->username = $user['username'];
        $this->name = $user['name'];
    }

    public function deleteMessage($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "deleteUser",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }

    public function deleteUser($data)
    {
        $user = \App\Models\User::find($data['inputAttributes']['id']);
        $user->syncPermissions([]);
        $user->removeRole('user');
        $user->delete();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);

        $this->getUsers();
        $this->resetUserData();
    }

    public function resetUserData()
    {
        $this->reset('id', 'username', 'name', 'password');
    }

    public function render()
    {
        $this->user = auth()->user();

        return view('livewire.user');
    }
}
