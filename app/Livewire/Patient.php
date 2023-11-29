<?php

namespace App\Livewire;

use App\Models\ReferenceRange;
use App\Models\Result;
use App\Models\Visit;
use App\Models\VisitTest;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Patient extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'delete',
        'deleteVisit',
    ];
    public $header = "المرضى";
    public $id = 0;
    public $visit_test_id = 0;
    public $searchName = "";
    public $searchAge = "";
    public $searchPhone = "";
    public $searchGender = "choose";
    public $searchDuration = "choose";

    #[Rule('required', message: 'أدخل إسم المريض')]
    public $patientName = "";
    public $duration = "year";
    public $gender = "male";
    public $insurance_id = null;
    public $age = 0;
    public $phone = 0;
    public Collection $patients;
    public Collection $insurances;
    public Collection $categories;
    public Collection $tests;
    public array $durations = [
        'year' => 'سنة',
        'month' => 'شهر',
        'week' => 'أسبوع',
        'day' => 'يوم',
        'hour' => 'ساعه',
    ];
    public $firstVisitDate = '';
    public array $currentPatient = [];
    public $discount = 0;
    public $amount = 0;
    public $total_amount = 0;

    public $insuranceNumber = null;
    public $doctor = null;
    public $patientEndurance = null;
    public $visit_date = "";
    public $visitId = 0;
    public array $currentCategory = [];
    public array $currentTest = [];
    public Collection $visits;
    public array $currentVisit = [];
    public array $currentLocation = [];
    public array $cart = [];

    public function mount()
    {
        $this->categories = \App\Models\Category::all();
        $this->patients = \App\Models\Patient::latest()->get();
        $this->insurances = \App\Models\Insurance::all();
        $this->firstVisitDate = date('Y-m-d');
    }

    public function getPatients()
    {
        $this->patients = \App\Models\Patient::latest()->get();
    }

    public function getVisits($id)
    {
        $this->visits = \App\Models\Visit::where("patient_id", $id)->latest()->get();
    }

    public function search()
    {
        $this->patients = \App\Models\Patient::where('patientName', 'LIKE', '%' . $this->searchName . '%')->latest()->get();
    }

    public function save()
    {
        $this->validate();
        if ($this->id == 0) {
            $patient = \App\Models\Patient::create([
                'patientName' => $this->patientName,
                'gender' => $this->gender,
                'duration' => $this->duration,
                'age' => $this->age,
                'phone' => $this->phone,
                'firstVisitDate' => $this->firstVisitDate,
            ]);

            $this->choosePatient($patient->toArray());
            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        } else {
            \App\Models\Patient::where('id', $this->id)->update([
                'patientName' => $this->patientName,
                'gender' => $this->gender,
                'duration' => $this->duration,
                'age' => $this->age,
                'phone' => $this->phone,
                'firstVisitDate' => $this->firstVisitDate,
            ]);
            $this->currentPatient = \App\Models\Patient::where("id", $this->id)->first()->toArray();
            $this->alert('success', 'تم التعديل بنجاح', ['timerProgressBar' => true]);

            $this->resetPatientData();
        }

    }


    public function edit($patient)
    {
        $this->id = $patient['id'];
        $this->patientName = $patient['patientName'];
        $this->gender = $patient['gender'];
        $this->age = $patient['age'];
        $this->phone = $patient['phone'];
    }

    public function deletePatientMessage($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "delete",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }

    public function delete($data)
    {
        \App\Models\Patient::where("id", $data['inputAttributes']['id'])->delete();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);

        $this->getPatients();
    }

    public function choosePatient($patient)
    {
        $this->currentPatient = $patient;
        $this->edit($patient);
        $this->visits = Visit::where("patient_id", $this->currentPatient['id'])->get();
    }

    public function chooseCategory($category)
    {
        $this->currentCategory = $category;
        $this->getTests();
    }

    public function getTests()
    {
        if (empty($this->currentCategory)) {
            $this->tests = \App\Models\Test::where("category_id", $this->currentTest['id'])->get();
        } else {
            $this->tests = \App\Models\Test::where("category_id", $this->currentCategory['id'])->get();
        }
    }

    public function calcDiscount()
    {
        $this->total_amount = floatval($this->amount) - floatval($this->discount);
    }

    public function resetPatientData()
    {
        $this->resetVisitData();
        $this->reset('id', 'patientName', 'gender', 'age', 'phone', 'currentPatient');
        $this->getPatients();
    }

    public function saveVisit()
    {
        if ($this->visitId == 0) {
            $visit = \App\Models\Visit::create([
                'patient_id' => $this->currentPatient['id'],
                'user_id' => auth()->id(),
                'insurance_id' => $this->insurance_id,
                'insuranceNumber' => $this->insuranceNumber,
                'amount' => $this->amount,
                'total_amount' => $this->total_amount,
                'discount' => $this->discount,
                'doctor' => $this->doctor,
                'patientEndurance' => $this->insurance_id != null ? $this->insurances->where("id", $this->insurance_id) : 100,
                'visit_date' => $this->visit_date,
            ]);

            $this->chooseVisit($visit->toArray());
            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        } else {
            \App\Models\Patient::where('id', $this->id)->update([
                'patientName' => $this->patientName,
                'gender' => $this->gender,
                'duration' => $this->duration,
                'age' => $this->age,
                'phone' => $this->phone,
                'firstVisitDate' => $this->firstVisitDate,
            ]);

            $this->alert('success', 'تم التعديل بنجاح', ['timerProgressBar' => true]);

            $this->resetPatientData();
        }

    }

    public function chooseVisit($visit)
    {
        $this->cart = [];
        $this->currentVisit = $visit;

        $this->loadDataFromDatabase();

        $this->editVisit($this->currentVisit);
    }

    public function editVisit($visit)
    {
        $this->visitId = $visit['id'];
        $this->insurance_id = $visit['insurance_id'];
        $this->insuranceNumber = $visit['insuranceNumber'];
        $this->amount = $visit['amount'];
        $this->total_amount = $visit['total_amount'];
        $this->discount = $visit['discount'];
        $this->doctor = $visit['doctor'];
        $this->patientEndurance = $visit['patientEndurance'];
        $this->visit_date = $visit['visit_date'];
    }

    public function deleteVisitMessage($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "deleteVisit",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }

    public function deleteVisit($data)
    {
        \App\Models\Visit::where("id", $data['inputAttributes']['id'])->delete();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
        $this->getVisits($this->currentPatient['id']);
    }

    public function resetVisitData()
    {
        $this->reset("id", "insurance_id", "insuranceNumber", "amount", "discount", "total_amount", "doctor", "patientEndurance", "visit_date", "visitId", "currentVisit");
        $this->getVisits($this->currentPatient['id']);
    }


    public function chooseTest($id)
    {
        if ($id == 0) {
            $this->getTests();
        } else {
            $this->currentTest = \App\Models\Test::where("id", $id)->first()->toArray();

            $this->currentLocation[$id] = $this->currentTest['testName'];
            $this->tests = \App\Models\Test::where("test_id", $this->currentTest['id'])->get();
        }
    }

    public function addTest(\App\Models\Test $test)
    {
        if ($test->getAll) {
            $testModel = \App\Models\Test::find($test['id']);
            $this->amount += floatval($testModel->price);

            if ($testModel) {

                VisitTest::where("visit_id", $this->currentVisit['id'])->where("test_id", $testModel->id)->delete();
                $visit_test = VisitTest::create([
                    "visit_id" => $this->currentVisit['id'],
                    "test_id" => $testModel->id,
                    "price" => floatval($testModel->price),
                ]);

                $search = array_search($testModel['testName'], $this->cart);
                unset($this->cart[$search]);
                $this->cart[$testModel['id']] = $testModel['testName'];
                $this->getChildrenTree($testModel, $visit_test['id']);
            }
        } else {
            if ($test->children->count() > 0) {
                if ($test->parent) {
                    VisitTest::where("visit_test_id", $this->visit_test_id)->where("test_id", $test->id)->delete();

                    $visit_test = VisitTest::create([
                        "visit_test_id" => $this->visit_test_id,
                        "test_id" => $test->id,
                        "price" => floatval($test->price),
                    ]);

                    $this->visit_test_id = $visit_test->id;
                    $this->amount += floatval($test->price);

                } else {
                    $check = VisitTest::where("visit_id", $this->currentVisit['id'])->where("test_id", $test->id)->first();
                    if ($check) {
                        $this->visit_test_id = $check->id;
                    } else {
                        $visit_test = VisitTest::create([
                            "visit_id" => $this->currentVisit['id'],
                            "test_id" => $test->id,
                            "price" => floatval($test->price),
                        ]);
                        $this->visit_test_id = $visit_test->id;
                    }

                    $this->amount += floatval($test->price);

                }
                $this->chooseTest($test->id);
            } else {
//                $deleted = VisitTest::where("visit_id", $this->currentVisit['id'])->where("test_id", $test->id)->get();
//                $sum = $deleted->sum("price");
//                $this->amount -= $sum;
//
//                if ($deleted->count() > 0) {
//                    VisitTest::where("visit_id", $this->currentVisit['id'])->where("test_id", $test->parent->id)->delete();
//                }

                if ($this->visit_test_id == 0) {
                    VisitTest::where("visit_id", $this->currentVisit["id"])->where("test_id", $test->id)->delete();
                    $visit_test = VisitTest::create([
                        "visit_id" => $this->currentVisit["id"],
                        "test_id" => $test->id,
                        "price" => floatval($test->price),
                    ]);
                    $result = Result::create([
                        "visit_test_id" => $visit_test->id,
                        "test_id" => $test->id,
                        "price" => floatval($test->price),
                    ]);
                } else {
                    $result = Result::create([
                        "visit_test_id" => $this->visit_test_id,
                        "test_id" => $test->id,
                        "price" => floatval($test->price),
                    ]);

                }


                $search = array_search($test['testName'], $this->cart);
                unset($this->cart[$search]);

                $this->cart[$result->id] = $test['testName'];


                $this->amount += floatval($test->price);

            }
        }
        $this->calcDiscount();

        \App\Models\Visit::where("id", $this->currentVisit["id"])->update([
            "amount" => $this->amount,
            "discount" => $this->discount,
            "total_amount" => $this->total_amount
        ]);

    }

    public function changeLocation($index)
    {
        $this->visit_test_id = 0;
        if ($index == -1) {
            $this->currentCategory = [];
            $this->currentLocation = [];
            $this->currentTest = [];
        } else {

            $this->chooseTest($index);

            $newArray = [];
            foreach ($this->currentLocation as $key => $location) {
                $newArray[$key] = $location;
                if ($index == $key) {
                    break;
                }
            }

            $this->currentLocation = $newArray;

        }

    }


    protected function getChildrenTree($test, $id)
    {
        $children = $test->children;

        if ($children->count() > 0) {
            $tree = [];

            foreach ($children as $child) {
                if ($child->children->count() > 0) {
                    $visit_test = VisitTest::create([
                        "visit_test_id" => $id,
                        "test_id" => $child->id,
                        "price" => floatval($child->price),
                    ]);
                    $this->amount += floatval($child->price);

                    $childTree = $this->getChildrenTree($child, $visit_test['id']);
                    $tree[$child->id] = $child->toArray();
                } else {
                    Result::create([
                        "visit_test_id" => $id,
                        "test_id" => $child->id,
                        "price" => floatval($child->price),
                    ]);
                    $this->amount += floatval($child->price);

                }
            }

            return $tree;
        } else {

            Result::create([
                "visit_test_id" => $id,
                "test_id" => $test->id,
                "price" => floatval($test->price),
            ]);
            $this->amount += floatval($test->price);


        }

        return [];
    }


    public function loadDataFromDatabase()
    {
        $visitTests = VisitTest::where('visit_id', $this->currentVisit['id'])->get();

        foreach ($visitTests as $visitTest) {
            $test = $visitTest->test;

            if ($test->getAll) {
                $search = array_search($test['testName'], $this->cart);
                unset($this->cart[$search]);
                $this->cart[$test['id']] = $test['testName'];
            } else {
                $this->loadChildrenFromDatabase($visitTest);
            }
        }
    }

    protected function loadChildrenFromDatabase($visitTest)
    {
        $children = $visitTest->children;
        if ($children->count() > 0) {
            foreach ($children as $child) {
                $this->loadChildrenFromDatabase($child);
            }
        } else {
            foreach ($visitTest->results as $result) {
                $this->cart[$result->id] = $result->test->testName;
            }

        }
    }

    public function decreseAmount($visitTest)
    {
        $amount = 0;
        $children = $visitTest->children;
        foreach ($children as $child) {
            $amount += floatval($child->price);
            if ($child->children->count() > 0) {
                $this->decreseAmount($child);
            } else {
                $amount += $child->results->sum("price");
            }
        }
        return $amount;
    }

    public function deleteFromCart($id)
    {
        $visitTest = VisitTest::where("test_id", $id)->where("visit_id", $this->currentVisit['id'])->first();
        if ($visitTest) {
            $this->amount -= floatval($visitTest->price);
            if ($visitTest->children->count() > 0) {
                $this->amount -= $this->decreseAmount($visitTest);
            } else {
                $this->amount -= $visitTest->results->sum("price");
            }
            $visitTest->delete();

        } else {
            $visitTest = Result::where("id", $id)->first();
            $this->amount -= floatval($visitTest->price);

            \App\Models\Visit::where("id", $this->currentVisit["id"])->update([
                "amount" => $this->amount,
                "discount" => $this->discount,
                "total_amount" => $this->total_amount
            ]);
            if ($visitTest->visitTest->results->where("id", "!=", $id)->count() > 0) {
                $visitTest->delete();
            } else {
                $this->changeLocation(-1);
                $visitTest->visitTest->delete();
            }
        }

        unset($this->cart[$id]);
        $this->calcDiscount();
    }

    public function render()
    {
        if ($this->visit_date == "") {
            $this->visit_date = date("Y-m-d");
        }
        return view('livewire.patient');
    }
}
