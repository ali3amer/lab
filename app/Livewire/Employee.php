<?php

namespace App\Livewire;

use App\Models\EmployeeExpense;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Employee extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $listeners = [
        'deleteEmployee',
        'deleteEmployeeExpense',
    ];

    public $header = 'الموظفين';
    public $id = 0;
    public $user;
    public $employeeName = "";
    public $amount = 0;
    public $expenseId = 0;
    public $payDate = "";

    public array $currentEmployee = [];

    public function mount()
    {
        if (!auth()->check()) {
            redirect("login");
        }
    }

    public function save()
    {
        if ($this->id == 0) {
            \App\Models\Employee::create([
                'employeeName' => $this->employeeName
            ]);
            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);
        } else {
            \App\Models\Employee::where("id", $this->id)->update([
                'employeeName' => $this->employeeName
            ]);
            $this->alert('success', 'تم التعديل بنجاح', ['timerProgressBar' => true]);
        }

        $this->resetData();
    }

    public function edit($employee)
    {
        $this->id = $employee['id'];
        $this->employeeName = $employee['employeeName'];
    }

    public function deleteEmployeeMessage($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "deleteEmployee",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }

    public function deleteEmployee($data)
    {
        \App\Models\Employee::where("id", $data['inputAttributes']['id'])->delete();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset("id", "employeeName", "currentEmployee");
    }

    public function resetExpenseData()
    {
        $this->reset("expenseId", "amount", "payDate");
    }

    public function chooseEmployee($employee)
    {
        $this->currentEmployee = $employee;
    }

    public function saveEmployeeExpenses()
    {
        if ($this->expenseId == 0) {
            EmployeeExpense::create([
                "employee_id" => $this->currentEmployee['id'],
                "amount" => $this->amount,
                "payDate" => $this->payDate,
            ]);
            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        } else {
            EmployeeExpense::where("id", $this->expenseId)->update([
                "amount" => $this->amount,
                "payDate" => $this->payDate,
            ]);

            $this->alert('success', 'تم التعديل بنجاح', ['timerProgressBar' => true]);

        }
        $this->resetExpenseData();
    }

    public function editExpense($expense)
    {
        $this->expenseId = $expense['id'];
        $this->payDate = $expense['payDate'];
        $this->amount = $expense['amount'];
    }

    public function deleteEmployeeExpenseMessage($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "deleteEmployeeExpense",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }

    public function deleteEmployeeExpense($data)
    {
        \App\Models\EmployeeExpense::where("id", $data['inputAttributes']['id'])->delete();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function render()
    {
        if ($this->payDate == "") {
            $this->payDate = date("Y-m-d");
        }

        $this->user = auth()->user();

        $employees = \App\Models\Employee::paginate(10);

        $expenses = null;
        if (!empty($this->currentEmployee) && isset($this->currentEmployee['id'])) {
            $expenses = EmployeeExpense::where("employee_id", $this->currentEmployee['id'])->paginate(10);
        }

        return view('livewire.employee', [
            "employees" => $employees,
            "expenses" => $expenses,
        ]);
    }

}
