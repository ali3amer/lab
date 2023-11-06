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
    #[Rule('required', message: 'أدخل إسم القسم')]

    public $categoryName = "";
    public $searchCategoryName = "";
    public $searchCategoryShortcut = "";
    public $shortcut = "";
    public Collection $categories;
    public Collection $analyzies;
    public array $currentCategory = [];

    public function mount()
    {
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
        } else {
            \App\Models\Category::where('id', $this->id)->update([
                'categoryName' => $this->categoryName,
            ]);
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

    public function deleteCategory($id)
    {
        \App\Models\Category::where("id", $id)->delete();
        $this->getCategories();
        $this->resetCategoryData();
    }

    public function resetCategoryData()
    {
        $this->reset('id', 'categoryName', 'currentCategory', 'shortcut');
    }

    public function render()
    {
        return view('livewire.category');
    }
}
