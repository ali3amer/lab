<?php

namespace App\Livewire;

use App\Models\EmployeeExpense;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Report extends Component
{
    public $header = "التقارير";
    public $from = "";
    public $to = "";
    public Collection $incomes;
    public Collection $expenses;
    public Collection $employees;

    public $generalSum = 0;
    public $reportType = null;
    public array $reports = [
        "" => "------------",
        "generalReport" => "تقرير ملخص مالي",
        "incomesReport" => "تقرير إيرادات",
        "employeesReport" => "تقرير موظفين",
        "expensesReport" => "تقرير مصروفات",
    ];

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
        }
    }

    public function generalReports()
    {
        $this->generalSum = 0;
        $this->incomes = Visit::whereBetween("visit_date", [$this->from, $this->to])->get();
        $this->generalSum += $this->incomes != null ? $this->incomes->sum("total_amount") : 0;
        $this->expenses = \App\Models\Expense::whereBetween("expenseDate", [$this->from, $this->to])->get();
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

    public function employeesReports()
    {
        $this->employees = EmployeeExpense::whereBetween("payDate", [$this->from, $this->to])->get();
    }

    public function render()
    {
        return view('livewire.report');
    }
}
