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
    public $header = "المستخدمين";
    public $id = 0;
    #[Rule('required', message: 'أدخل إسم القسم')]

    public $username = "";
    public $name = "";
    public $password = "";
    public $searchUserName = "";
    public Collection $users;

    public array $permissionsList = [
        ['patients', 'المرضى'],
        ['categories', 'الاقسام'],
        ['analyses', 'التحاليل'],
        ['sub_analyses', 'التحاليل الفرعية'],
        ['insurances', 'التأمينات'],
        ['visits', 'الزيارات'],
        ['users', 'المستخدمين'],
    ];

    public function mount()
    {
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
            \App\Models\User::create([
                'name' => $this->name,
                'username' => $this->username,
                'password' => Hash::make($this->password),
            ]);
        } else {
            $user = \App\Models\User::find($this->id);
            $user->name = $this->name;
            $user->username = $this->username;
            if ($this->password != "") {
                $user->password = Hash::make($this->password);
            }
            $user->save();
        }

        $this->getUsers();

        $this->resetUserData();
    }

    public function editUser($user)
    {
        $this->resetUserData();
        $this->id = $user['id'];
        $this->userName = $user['userName'];
    }

    public function deleteUser($id)
    {
        \App\Models\User::where("id", $id)->delete();
        $this->getUsers();
        $this->resetUserData();
    }

    public function resetUserData()
    {
        $this->reset('id', 'username', 'name', 'password');
    }
    public function render()
    {
        return view('livewire.user');
    }
}
