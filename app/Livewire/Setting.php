<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Artisan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Setting extends Component
{

    use LivewireAlert;
    use WithPagination;

    protected $listeners = [
        'delete',
    ];

    public $id = null;
    public $header = "الإعدادات";

    public $name = "معمل النخبة للتحاليل الطبيه";
    public $first_name = "Dr.Kamal Magalad";
    public $second_name = "Dr.Sami Hashim";

    public $setting;

    public function mount()
    {
        $setting = \App\Models\Setting::first();

        if ($setting) {
            $this->setting = $setting;
            $this->name = $setting->name;
            $this->first_name = $setting->first_name;
            $this->second_name = $setting->second_name;
        } else {
            $this->setting = \App\Models\Setting::create([
                'name' => $this->name,
                'first_name' => $this->first_name,
                'second_name' => $this->second_name,
            ]);
        }
    }


    public function save()
    {
        $this->setting->name = $this->name;
        $this->setting->first_name = $this->first_name;
        $this->setting->second_name = $this->second_name;
        $this->setting->save();

        $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
    }

    public function collectFromAnotherDatabase()
    {
//        $choices = RangeChoice::where("choiceName", "LIKE", "%+%")->get()->toArray();
//        $c = [];
//        foreach ($choices as $choice) {
//            $c[$choice["id"]] = $choice["choiceName"];
//        }
//        dd($c);

        Artisan::call("migrate:fresh --seed");

//        \App\Models\Category::where("id", ">", 0)->delete();
        $db2 = \DB::connection('db2');


        $categories = $db2->table('categories')->get()->keyBy("id");
        foreach ($categories as $category) {
            \App\Models\Category::create([
                'id' => $category->id,
                'categoryName' => $category->categoryName,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at,
            ]);
        }

        $tests = $db2->table('tests')->whereNotNull("category_id")->get()->keyBy("id");

        foreach ($tests as $test) {
            $range = $db2->table('reference_ranges')->where("test_id", $test->id)->first();
            if ($range) {
                $result_type = $range->result_type == "multable_choice" ? "multiple_choice" : "number";
            } else {
                $result_type = "number";
            }
            \App\Models\Test::create([
                'id' => $test->id,
                'testName' => $test->testName,
                'result_type' => $result_type,
                'shortcut' => $test->shortcut,
                'price' => floatval($test->price),
                'unit' => $test->unit,
                'category_id' => $test->category_id,
                'test_id' => $test->test_id,
                'getAll' => $test->getAll,
                'created_at' => $test->created_at,
                'updated_at' => $test->updated_at,
            ]);
        }

        $tests = $db2->table('tests')->whereNull("category_id")->get()->keyBy("id");

        foreach ($tests as $test) {
            $range = $db2->table('reference_ranges')->where("test_id", $test->id)->first();
            if ($range) {
                $result_type = $range->result_type == "multable_choice" ? "multiple_choice" : "number";
            } else {
                $result_type = "number";
            }
            \App\Models\Test::create([
                'id' => $test->id,
                'testName' => $test->testName,
                'result_type' => $result_type,
                'shortcut' => $test->shortcut,
                'price' => floatval($test->price),
                'unit' => $test->unit,
                'category_id' => $test->category_id,
                'test_id' => $test->test_id,
                'getAll' => $test->getAll,
                'created_at' => $test->created_at,
                'updated_at' => $test->updated_at,
            ]);
        }

        $reference_ranges = $db2->table('reference_ranges')->get()->keyBy("id");

        foreach ($reference_ranges as $reference_range) {
            $ageGenderGroup = \App\Models\AgeGenderGroup::create([
                'test_id' => $reference_range->test_id,
                'gender' => $reference_range->gender,
                'age' => $reference_range->age,
                'min_age' => $reference_range->min_age,
                'max_age' => $reference_range->max_age,
            ]);

            if ($ageGenderGroup->test->result_type == "number") {
                \App\Models\NumericRange::create([
                    'age_gender_group_id' => $ageGenderGroup->id,
                    'min_value' => $reference_range->min_value,
                    'max_value' => $reference_range->max_value,
                ]);
            } elseif ($ageGenderGroup->test->result_type == "multiple_choice") {
                $choices = $db2->table('range_choices')->where("range_id", $reference_range->id)->get()->keyBy("id");

                foreach ($choices as $choice) {
                    \App\Models\ChoiceRange::create([
                        'id' => $choice->id,
                        'age_gender_group_id' => $ageGenderGroup->id,
                        'choiceName' => $choice->choiceName,
                        'default' => $choice->default,
                    ]);

                    $this->addChoices($choice);
                }
            }

        }


        $employees = $db2->table('employees')->get()->keyBy("id");
        foreach ($employees as $employee) {
            \App\Models\Employee::create([
                'id' => $employee->id,
                'employeeName' => $employee->employeeName,
                'created_at' => $employee->created_at,
                'updated_at' => $employee->updated_at,
            ]);
        }

        $employee_expenses = $db2->table('employee_expenses')->get()->keyBy("id");
        foreach ($employee_expenses as $employee_expense) {
            \App\Models\EmployeeExpense::create([
                'id' => $employee_expense->id,
                'employee_id' => $employee_expense->employee_id,
                'amount' => $employee_expense->amount,
                'payDate' => $employee_expense->payDate,
                'created_at' => $employee_expense->created_at,
                'updated_at' => $employee_expense->updated_at,
            ]);
        }

        $expenses = $db2->table('expenses')->get()->keyBy("id");
        foreach ($expenses as $expense) {
            \App\Models\Expense::create([
                'id' => $expense->id,
                'description' => $expense->description,
                'amount' => $expense->amount,
                'expenseDate' => $expense->expenseDate,
                'created_at' => $expense->created_at,
                'updated_at' => $expense->updated_at,
            ]);
        }

        $patients = $db2->table('patients')->get()->keyBy("id");
        foreach ($patients as $patient) {
            \App\Models\Patient::create([
                'id' => $patient->id,
                'patientName' => $patient->patientName,
                'age' => $patient->age,
                'duration' => $patient->duration,
                'firstVisitDate' => $patient->firstVisitDate,
                'phone' => $patient->phone,
                'created_at' => $patient->created_at,
                'updated_at' => $patient->updated_at,
            ]);
        }

        $visits = $db2->table('visits')->get()->keyBy("id");
        foreach ($visits as $visit) {
            \App\Models\Visit::create([
                'id' => $visit->id,
                'patient_id' => $visit->patient_id,
                'insurance_id' => $visit->insurance_id,
                'insuranceNumber' => $visit->insuranceNumber,
                'discount' => $visit->discount,
                'doctor' => $visit->doctor,
                'patientEndurance' => $visit->patientEndurance,
                'visit_date' => $visit->visit_date,
                'created_at' => $visit->created_at,
                'updated_at' => $visit->updated_at,
                'user_id' => 1,
            ]);
        }

        $visit_tests = $db2->table('visit_tests')->get()->keyBy("id");
        foreach ($visit_tests as $visit_test) {
            \App\Models\VisitTest::create([
                'id' => $visit_test->id,
                'visit_id' => $visit_test->visit_id,
                'visit_test_id' => $visit_test->visit_test_id,
                'test_id' => $visit_test->test_id,
                'price' => $visit_test->price,
                'comment' => $visit_test->comment,
                'created_at' => $visit_test->created_at,
                'updated_at' => $visit_test->updated_at,
            ]);
        }

        $results = $db2->table('results')->get()->keyBy("id");
        foreach ($results as $result) {
            \App\Models\Result::create([
                'id' => $result->id,
                'visit_test_id' => $result->visit_test_id,
                'test_id' => $result->test_id,
                'price' => $result->price,
                'result' => $result->result,
                'result_choice' => $result->result_choice,
                'created_at' => $result->created_at,
                'updated_at' => $result->updated_at,
            ]);
        }

        $this->alert('success', 'تم سحب البيانات', ['timerProgressBar' => true]);


//        foreach ($categories as $category) {
//            $cat = \App\Models\Category::create([
//                "categoryName" => $category->categoryName
//            ]);
//            $analyses = $db2->table('analyses')->where("category_id", $category->id)->get()->keyBy("id");
//            foreach ($analyses as $analysis) {
//                $sub_analyses = $db2->table('sub_analyses')->where("analysis_id", $analysis->id)->get()->keyBy("id");
//                $count = $sub_analyses->count();
//                if ($count == 1) {
//                    $test = \App\Models\Test::create([
//                        "testName" => $sub_analyses->first()->subAnalysisName,
//                        "unit" => $sub_analyses->first()->unit,
//                        "price" => $sub_analyses->first()->price,
//                        "category_id" => $cat->id
//                    ]);
//
//                    $ranges = $db2->table('reference_ranges')->where("sub_analysis_id", $sub_analyses->first()->id)->get();
//
//                    foreach ($ranges as $range) {
//                        $ref = ReferenceRange::create([
//                            "test_id" => $test->id,
//                            "age" => $range->age == "years" ? "year" : $range->age,
//                            "gender" => $range->gender,
//                            "min_value" => $range->range_from,
//                            "max_value" => $range->range_to,
//                            "min_age" => $range->age_from,
//                            "max_age" => $range->age_to,
//                            "result_type" => $range->result_types,
//                        ]);
//
//                        if ($range->result_types == "multiple_choice") {
//                            foreach (json_decode($range->result_multiple_choice) as $index => $choice) {
//                                RangeChoice::create([
//                                    "range_id" => $ref->id,
//                                    "choiceName" => $choice,
//                                    "default" => in_array($choice, ["nil", "yellow", "negative", "clear", "Brown", "Normal"])
//                                ]);
//                            }
//                        }
//                    }
//
//                } else {
//                    $parentTest = \App\Models\Test::create([
//                        "testName" => $analysis->analysisName,
//                        "category_id" => $cat->id
//                    ]);
//                    foreach ($sub_analyses as $sub) {
//                        $test = \App\Models\Test::create([
//                            "testName" => $sub->subAnalysisName,
//                            "unit" => $sub->unit,
//                            "price" => $sub->price,
//                            "test_id" => $parentTest->id
//                        ]);
//
//                        $ranges = $db2->table('reference_ranges')->where("sub_analysis_id", $sub->id)->get();
//
//                        foreach ($ranges as $range) {
//                            $ref = ReferenceRange::create([
//                                "test_id" => $test->id,
//                                "age" => $range->age == "years" ? "year" : $range->age,
//                                "gender" => $range->gender,
//                                "min_value" => $range->range_from,
//                                "max_value" => $range->range_to,
//                                "min_age" => $range->age_from,
//                                "max_age" => $range->age_to,
//                                "result_type" => $range->result_types,
//                            ]);
//
//                            if ($range->result_types == "multiple_choice") {
//                                foreach (json_decode($range->result_multiple_choice) as $index => $choice) {
//                                    RangeChoice::create([
//                                        "range_id" => $ref->id,
//                                        "choiceName" => $choice,
//                                        "default" => in_array($choice, ["nil", "yellow", "negative", "clear"])
//                                    ]);
//                                }
//                            }
//                        }
//                    }
//                }
//            }
//
//        }
//
//        $urin = \App\Models\Test::create(["testName" => "URINE GENERAL", "category_id" => 3, "getAll" => true]);
//        $stool = \App\Models\Test::create(["testName" => "STOOL GENERAL", "category_id" => 3, "getAll" => true]);
//
//        \App\Models\Test::where("testName", "URINE GENERAL - Microscopy")->update([
//            "testName" => "Microscopy",
//            "category_id" => null,
//            "test_id" => $urin->id
//        ]);
//        \App\Models\Test::where("testName", "URINE GENERAL - MACRO")->update([
//            "testName" => "MACRO",
//            "category_id" => null,
//            "test_id" => $urin->id
//        ]);
//        \App\Models\Test::where("testName", "Stool Genral -MACRO")->update([
//            "testName" => "MACRO",
//            "category_id" => null,
//            "test_id" => $stool->id
//        ]);
//        \App\Models\Test::where("testName", "Stool Genral -MICRO")->update([
//            "testName" => "MICRO",
//            "category_id" => null,
//            "test_id" => $stool->id
//        ]);
//
//        \App\Models\Test::where("testName", "CBC")->update([
//            "getAll" => true
//        ]);
    }

    public function addChoices($choice)
    {
        $db2 = \DB::connection('db2');
        $newChoices = $db2->table('range_choices')->where("choice_id", $choice->id)->get()->keyBy("id");
        if ($newChoices->count() > 0) {
            foreach ($newChoices as $ch) {
                \App\Models\ChoiceRange::create([
                    'choice_range_id' => $choice['id'],
                    'choiceName' => $ch->choiceName,
                    'default' => $ch->default,
                ]);
                $this->addChoices($ch);
            }
        }
    }


    public function render()
    {
        return view('livewire.setting');
    }
}
