<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Category extends Component
{
    use LivewireAlert;
    public $header = "الاقسام";
    public $id = 0;
    protected $listeners = [
        'deleteCategory',
    ];

    #[Rule('required', message: 'أدخل إسم القسم')]

    public $categoryName = "";
    public $searchCategoryName = "";
    public $searchCategoryShortcut = "";
    public $shortcut = "";
    public Collection $categories;
    public $user;
    public array $currentCategory = [];

    public function mount()
    {
        if(!auth()->check()) {
            redirect("login");
        }

        $this->categories = \App\Models\Category::all();
    }

    public function getCategories()
    {
        $this->categories = \App\Models\Category::all();
    }

    public function searchCategory()
    {
        $this->categories = \App\Models\Category::where('categoryName', 'LIKE', '%' . $this->searchCategoryName . '%')->where('categoryName', 'LIKE', '%' . $this->searchCategoryName . '%')->get();
    }

    public function saveCategory()
    {
        $this->validate();
        if ($this->id == 0) {
            \App\Models\Category::create([
                'categoryName' => $this->categoryName,
            ]);
            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        } else {
            \App\Models\Category::where('id', $this->id)->update([
                'categoryName' => $this->categoryName,
            ]);

            $this->alert('success', 'تم التعديل بنجاح', ['timerProgressBar' => true]);

        }

        $this->getCategories();

        $this->resetCategoryData();
    }

    public function editCategory($category)
    {
        $this->resetCategoryData();
        $this->id = $category['id'];
        $this->categoryName = $category['categoryName'];
    }

    public function deleteMessage($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "deleteCategory",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }

    public function deleteCategory($data)
    {
        \App\Models\Category::where("id", $data['inputAttributes']['id'])->delete();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);

        $this->getCategories();
        $this->resetCategoryData();
    }

    public function resetCategoryData()
    {
        $this->reset('id', 'categoryName', 'currentCategory', 'shortcut');
    }

    public function render()
    {
        $this->user = auth()->user();

        return view('livewire.category');
    }
}
