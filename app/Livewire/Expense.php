<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Expense extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'deleteExpense',
    ];

    public $header = 'الموظفين';

    public $id = 0;
    public string $description = "";
    public $expenseDate = "";
    public $amount = "";
    public Collection $expenses;

    public function mount()
    {
        $this->expenses = \App\Models\Expense::all();
    }

    public function getExpenses()
    {
        $this->expenses = \App\Models\Expense::all();
    }

    public function save()
    {
        if ($this->id == 0) {
            \App\Models\Expense::create([
                "description" => $this->description,
                "expenseDate" => $this->expenseDate,
                "amount" => floatval($this->amount),
            ]);
            $this->alert('success', 'تم الحفظ بنجاح', ['timerProgressBar' => true]);

        } else {
            \App\Models\Expense::where("id", $this->id)->update([
                "description" => $this->description,
                "expenseDate" => $this->expenseDate,
                "amount" => floatval($this->amount),
            ]);
            $this->alert('success', 'تم التعديل بنجاح', ['timerProgressBar' => true]);

        }
        $this->resetData();
        $this->getExpenses();
    }

    public function edit($expense)
    {
        $this->id = $expense['id'];
        $this->description = $expense['description'];
        $this->expenseDate = $expense['expenseDate'];
        $this->amount = $expense['amount'];
    }

    public function deleteExpenseMessage($id)
    {
        $this->confirm("  هل توافق على الحذف ؟  ", [
            'inputAttributes' => ["id" => $id],
            'toast' => false,
            'showConfirmButton' => true,
            'confirmButtonText' => 'موافق',
            'onConfirmed' => "deleteExpense",
            'showCancelButton' => true,
            'cancelButtonText' => 'إلغاء',
            'confirmButtonColor' => '#dc2626',
            'cancelButtonColor' => '#4b5563'
        ]);
    }

    public function deleteExpense($data)
    {
        \App\Models\Expense::where('id', $data['inputAttributes']['id'])->delete();
        $this->getExpenses();
        $this->alert('success', 'تم الحذف بنجاح', ['timerProgressBar' => true]);
    }

    public function resetData()
    {
        $this->reset("id", "description", "expenseDate", "amount",);
    }
    public function render()
    {
        return view('livewire.expense');
    }
}
