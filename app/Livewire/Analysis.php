<?php

namespace App\Livewire;

use App\Models\ReferenceRange;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Rule;
use Livewire\Component;
use function MongoDB\BSON\toJSON;

class Analysis extends Component
{
    public $header = "التحاليل";
    public $id = 0;
    public $subId = 0;
    public $rangeId = 0;
    #[Rule('required', message: 'أدخل إسم القسم')]
    public $analysisName = "";
    public $subAnalysisName = "";
    public $searchCategoryName = "";
    public $searchAnalysisName = "";
    public $searchAnalysisShortcut = "";
    public $shortcut = "";
    public $choice = "";
    public $result_text = "";
    public $result_types = "number";

    public $types = [
        'number' => 'مدى رقمي',
        'text' => 'نص',
        'multable_choice' => 'خيارات',
    ];
    public $genders = ["all" => "الكل", "ذكر" => "male", "أنثى" => "female"];
    public $gender = "all";
    public $ages = ["all" => "الكل", "years" => "سنوات", "months" => "شهور", "weeks" => "أسابيع", "days" => "أيام"];
    public $age = "all";
    public $age_range = "all";
    public $age_from = null;
    public $age_to = null;
    public $range_from = "";
    public $range_to = "";
    public Collection $categories;
    public Collection $analyzes;
    public Collection $subAnalyzes;
    public array $currentCategory = [];
    public array $currentAnalysis = [];
    public $searchSubAnalysisName = '';
    public array $currentSubAnalysis = [];
    public array $choices = [];
    public Collection $ranges;
    public $referenceId = 0;

    public function mount()
    {
        $this->categories = \App\Models\Category::all();
    }

    public function addChoice()
    {
        if ($this->choice != "") {
            $this->choices[$this->choice] = $this->choice;
            $this->choice = '';
        }
    }

    public function saveReferenceRange()
    {
        if ($this->age_range == "all") {
        $this->age_from = null;
        $this->age_to = null;
        $this->age = "all";
        }
        if ($this->referenceId == 0) {
            ReferenceRange::create([
                "sub_analysis_id" => $this->currentSubAnalysis['id'],
                "gender" => $this->gender,
                "age" => $this->age,
                "result_types" => $this->result_types,
                "age_from" => $this->age_from,
                "age_to" => $this->age_to,
                "range_from" => $this->range_from,
                "range_to" => $this->range_to,
                "result_multable_choice" => $this->choices,
                "result_text" => $this->result_text,
            ]);
        }
    }

    public function getAnalyses()
    {
        $this->analyzes = \App\Models\Analysis::where('category_id', $this->currentCategory['id'])->get();
    }

    public function getSubAnalyses()
    {
        $this->subAnalyzes = \App\Models\SubAnalysis::where('analysis_id', $this->currentAnalysis['id'])->get();
    }

    public function getReferenceRange()
    {
        $this->ranges = ReferenceRange::where("sub_analysis_id", $this->currentSubAnalysis['id'])->get();
    }

    public function getCategories()
    {
        $this->categories = \App\Models\Category::all();
    }

    public function searchAnalyses()
    {
        if (!empty($this->currentCategory)) {
            $this->analyzes = \App\Models\Analysis::where("category_id", $this->currentCategory['id'])->where('shortcut', 'LIKE', '%' . $this->searchAnalysisShortcut . '%')->where('analysisName', 'LIKE', '%' . $this->searchAnalysisName . '%')->get();
        }
    }

    public function searchSubAnalyses()
    {
        $this->subAnalyzes = \App\Models\SubAnalysis::where("analysis_id", $this->currentAnalysis['id'])->where('subAnalysisName', 'LIKE', '%' . $this->searchSubAnalysisName . '%')->get();
    }

    public function searchCategories()
    {
        $this->categories = \App\Models\Category::where('categoryName', 'LIKE', '%' . $this->searchCategoryName . '%')->get();
    }

    public function saveAnalysis()
    {
        $this->validate();
        if ($this->id == 0) {
            \App\Models\Analysis::create([
                'analysisName' => $this->analysisName,
                'shortcut' => $this->shortcut,
                'category_id' => $this->currentCategory['id']
            ]);
        } else {
            \App\Models\Analysis::where('id', $this->id)->update([
                'analysisName' => $this->analysisName,
                'shortcut' => $this->shortcut,
            ]);
        }

        $this->getAnalyses();

        $this->resetAnalysisData();
    }

    public function saveSubAnalysis()
    {
        $this->validate();
        if ($this->subId == 0) {
            \App\Models\SubAnalysis::create([
                'subAnalysisName' => $this->subAnalysisName,
                'analysis_id' => $this->currentAnalysis['id']
            ]);
        } else {
            \App\Models\SubAnalysis::where('id', $this->subId)->update([
                'subAnalysisName' => $this->subAnalysisName,
            ]);
        }

        $this->getSubAnalyses();

        $this->resetSubAnalysisData();
    }

    public function editAnalysis($category)
    {
        $this->resetAnalysisData();
        $this->id = $category['id'];
        $this->analysisName = $category['analysisName'];
        $this->shortcut = $category['shortcut'];
    }

    public function editRange($range)
    {
        $this->rangeId = $range['id'];
        $this->gender = $range['gender'];
        $this->age = $range['age'];
        $this->result_types = $range['result_types'];
        $this->age_from = $range['age_from'];
        $this->age_to = $range['age_to'];
        $this->range_from = $range['range_from'];
        $this->range_to = $range['range_to'];
        $this->choices = $range['result_multable_choice'];
        $this->result_text = $range['result_text'];
    }

    public function deleteAnalysis($id)
    {
        \App\Models\Analysis::where("id", $id)->delete();
        $this->getAnalyses();
        $this->resetAnalysisData();
    }

    public function chooseAnalysis($analysis)
    {
        $this->analysisName = $analysis['analysisName'];
        $this->shortcut = $analysis['shortcut'];
        $this->currentAnalysis = $analysis;
        $this->getSubAnalyses();
    }

    public function editSubAnalysis($subAnalysis)
    {
        $this->subId = $subAnalysis['id'];
        $this->subAnalysisName = $subAnalysis['subAnalysisName'];
    }

    public function deleteSubAnalysis($id)
    {
        \App\Models\SubAnalysis::where("id", $id)->delete();
        $this->getSubAnalyses();
        $this->resetSubAnalysisData();
    }

    public function chooseSubAnalysis($subAnalysis)
    {
        $this->currentSubAnalysis = $subAnalysis;
        $this->getReferenceRange();
    }

    public function chooseCategory($category)
    {
        $this->currentCategory = $category;
        $this->getAnalyses();
    }

    public function resetSubAnalysisData()
    {
        $this->reset('subId', 'subAnalysisName');
    }

    public function resetAnalysisData()
    {
        $this->reset('id', 'analysisName', 'currentAnalysis', 'shortcut');
    }

    public function render()
    {
        return view('livewire.analysis');
    }
}
