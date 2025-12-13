<?php

namespace App\Livewire;

use App\Models\EmployeeExpense;
use App\Models\InsuranceDebt;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Report extends Component
{
    public $header = "التقارير";
    public $from = "";
    public $user;
    public $to = "";
    public Collection $visits;
    public Collection $incomes;
    public $incomeSum = 0;
    public Collection $expenses;
    public Collection $employees;
    public Collection $insurances;

    public $generalSum = 0;
    public $insurance_id = null;
    public $reportType = null;
    public array $reports = [
        "" => "------------",
        "generalReport" => "تقرير ملخص مالي",
        "incomesReport" => "تقرير إيرادات",
        "employeesReport" => "تقرير موظفين",
        "expensesReport" => "تقرير مصروفات",
        "insuranceReport" => "تقرير تأمين",
    ];
    public Collection $insurancesResult;
    public $insuranceName = "";

    public $insuranceSum = 0;

    public function mount()
    {
        if (!auth()->check()) {
            redirect("login");
        }
        $this->insurances = \App\Models\Insurance::get()->keyBy("id");
    }

    public function getReport()
    {
        if ($this->reportType == "generalReport") {
            $this->generalReports();
        } elseif ($this->reportType == "incomesReport") {
            $this->incomesReports();
        } elseif ($this->reportType == "employeesReport") {
            $this->employeesReports();
        } elseif ($this->reportType == "expensesReport") {
            $this->expensesReports();
        } elseif ($this->reportType == "insuranceReport") {
            $this->insurancesReports();
        }
    }

    public function generalReports()
    {
        $this->generalSum = 0;
        $this->incomes = Visit::whereBetween("visit_date", [$this->from, $this->to])->get();
        $this->incomeSum = $this->incomes->sum(function ($income) {
            return $income->amount * ($income->patientEndurance / 100);
        });
        $this->generalSum += $this->incomeSum;
        $this->expenses = \App\Models\Expense::whereBetween("expenseDate", [$this->from, $this->to])->get();
        $this->insuranceSum = InsuranceDebt::whereBetween("paid_date", [$this->from, $this->to])->sum('amount');
        $this->generalSum += $this->insuranceSum;
        $this->generalSum -= $this->expenses != null ? $this->expenses->sum("amount") : 0;
        $this->employees = EmployeeExpense::whereBetween("payDate", [$this->from, $this->to])->get();
        $this->generalSum -= $this->employees != null ? $this->employees->sum("amount") : 0;

    }

    public function incomesReports()
    {
        $this->incomes = Visit::whereBetween("visit_date", [$this->from, $this->to])->get();
    }

    public function expensesReports()
    {
        $this->expenses = \App\Models\Expense::whereBetween("expenseDate", [$this->from, $this->to])->get();
    }

    public function insurancesReports()
    {
        $this->insuranceName = \App\Models\Insurance::find($this->insurance_id)->insuranceName ?? "";
        $this->visits = \App\Models\Visit::where("insurance_id", $this->insurance_id)->whereBetween("visit_date", [$this->from, $this->to])->get();
    }

    public function employeesReports()
    {
        $this->employees = EmployeeExpense::whereBetween("payDate", [$this->from, $this->to])->get();
    }

    public function render()
    {
        $this->user = auth()->user();

        return view('livewire.report');
    }
}
