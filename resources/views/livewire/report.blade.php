<div>
    <livewire:header :$header/>

    <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl m-2 mx-5">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full md:w-1/5 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="reportType">
                    نوع التقرير
                </label>
                <select
                    wire:model="reportType"
                    class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    id="reportType">
                    <option>--------------------</option>
                    <option value="generalReport">تقرير ملخص مالي</option>
                    <option value="incomesReport">تقرير إيرادات</option>
                    <option value="employeesReport">تقرير موظفين</option>
                    <option value="expensesReport">تقرير مصروفات</option>
                </select>
                <span class="text-red-500">@error('reportType') {{ $message }} @enderror</span>
            </div>

            <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="from">
                    من
                </label>
                <input autocomplete="off"
                       wire:model="from"
                       class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                       id="from" type="date">
                <span class="text-red-500">@error('from') {{ $message }} @enderror</span>
            </div>

            <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="to">
                    الى
                </label>
                <input
                    wire:model="to"
                    class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    id="to" type="date">
                <span class="text-red-500">@error('to') {{ $message }} @enderror</span>
            </div>


            <div class="w-full md:w-1/6 px-2  flex items-center ">
                <button type="button" wire:click="getReport()"
                        class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white"><i
                        class="fa fa-file-lines"></i></button>
            </div>

            <div class="w-full md:w-1/12 px-2  flex items-center " id="printReport">
                <button type="button" wire:click="getReport()"
                        class=" py-2.5 bg-blue-600 hover:bg-cyan-700 w-full mt-2 rounded text-white"><i
                        class="fa fa-print"></i></button>
            </div>
        </div>
    </div>

    <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl mx-5  my-0">
        <div class="overflow-auto h-80">
            <div class="report" dir="rtl">
                <div class="header hidden print:block">
                    <img src="{{ asset('js/header.jpg') }}" style="width: 100%; height: 150px"
                         alt="">
                    <span>التاريخ: {{ date("Y-m-d") }}</span>
                    <h3 class="text-center font-extrabold">{{ $reports[$reportType] . ' من تاريخ : ' . $from . ' إلى تاريخ : ' . $to }}</h3>
                </div>
                @if($reportType == "generalReport")
                    <table class="w-full table-fixed text-center">
                        <thead class="bg-cyan-700 font-extrabold text-white">
                        <tr>
                            <th class="py-2 rounded-r-2xl">البيان</th>
                            <th class="py-2 rounded-l-2xl">المبلغ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>الإيرادات</td>
                            <td>{{ $incomes != null ? number_format($incomes->sum("total_amount"), 2) : 0 }}</td>
                        </tr>
                        <tr>
                            <td>المصروفات</td>
                            <td>{{ $expenses != null ? number_format($expenses->sum("amount"), 2) : 0 }}</td>
                        </tr>
                        <tr>
                            <td>الموظفين</td>
                            <td>{{ $employees != null ? number_format($employees->sum("amount"), 2) : 0 }}</td>
                        </tr>
                        </tbody>
                        <tfoot class="bg-cyan-700 font-extrabold text-white">
                        <tr>
                            <th class="py-2 rounded-r-2xl">الجمله</th>
                            <th class="py-2 rounded-l-2xl">{{ number_format($generalSum, 2) }}</th>
                        </tr>
                        </tfoot>
                    </table>
                @elseif($reportType == "incomesReport")
                    @if(!empty($incomes))
                        <table class="w-full table-fixed text-center">
                            <thead class="bg-cyan-700 font-extrabold text-white">
                            <tr>
                                <th class="py-2 rounded-r-2xl">التاريخ</th>
                                <th class="py-2 ">إسم المريض</th>
                                <th class="py-2 rounded-l-2xl">المبلغ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($incomes as $income)
                                <tr>
                                    <td class="py-2">{{ $income->visit_date }}</td>
                                    <td>{{ $income->patient->patientName }}</td>
                                    <td>{{ number_format($income->amount, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="bg-cyan-700 font-extrabold text-white">
                            <tr>
                                <th class="py-2 rounded-r-2xl" colspan="2">الجمله</th>
                                <th class="py-2 rounded-l-2xl">{{ number_format($incomes->sum("amount"), 2) }}</th>
                            </tr>
                            </tfoot>
                        </table>
                    @endif
                @elseif($reportType == "employeesReport")
                    @if(!empty($employees))
                        <table class="w-full table-fixed text-center">
                            <thead class="bg-cyan-700 font-extrabold text-white">
                            <tr>
                                <th class="py-2 rounded-r-2xl">التاريخ</th>
                                <th class="py-2 ">إسم الموظف</th>
                                <th class="py-2 rounded-l-2xl">المبلغ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td class="py-2">{{ $employee->payDate }}</td>
                                    <td>{{ $employee->employee->employeeName }}</td>
                                    <td>{{ number_format($employee->amount, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="bg-cyan-700 font-extrabold text-white">
                            <tr>
                                <th class="py-2 rounded-r-2xl" colspan="2">الجمله</th>
                                <th class="py-2 rounded-l-2xl">{{ number_format($employees->sum("amount"), 2) }}</th>
                            </tr>
                            </tfoot>
                        </table>
                    @endif
                @elseif($reportType == "expensesReport")
                    @if(!empty($expenses))
                        <table class="w-full table-fixed text-center">
                            <thead class="bg-cyan-700 font-extrabold text-white">
                            <tr>
                                <th class="py-2 rounded-r-2xl">التاريخ</th>
                                <th class="py-2 ">البيان</th>
                                <th class="py-2 rounded-l-2xl">المبلغ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($expenses as $expense)
                                <tr>
                                    <td class="py-2">{{ $expense->expenseDate }}</td>
                                    <td>{{ $expense->description }}</td>
                                    <td>{{ number_format($expense->amount, 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="bg-cyan-700 font-extrabold text-white">
                            <tr>
                                <th class="py-2 rounded-r-2xl" colspan="2">الجمله</th>
                                <th class="py-2 rounded-l-2xl">{{ number_format($expense->sum("amount"), 2) }}</th>
                            </tr>
                            </tfoot>
                        </table>
                    @endif
                @endif
            </div>
        </div>
    </div>

</div>
