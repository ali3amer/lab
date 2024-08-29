<div>
    <livewire:header :$header/>

    <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl m-2 mx-5">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full md:w{{ $reportType == "insuranceReport" ? "-1/6" : "-1/3" }} px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="reportType">
                    نوع التقرير
                </label>
                <select
                    wire:model.live="reportType"
                    class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                    id="reportType">
                    @foreach($reports as $index => $report)
                        <option value="{{ $index }}">{{ $report }}</option>
                    @endforeach
                </select>
                <span class="text-red-500">@error('reportType') {{ $message }} @enderror</span>
            </div>

            @if($reportType == "insuranceReport")
                <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="reportType">
                        التأمين
                    </label>
                    <select
                        wire:model.live="insurance_id"
                        class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="reportType">
                        <option value="">--------------</option>
                        @foreach($insurances as $index => $insurance)
                            <option value="{{ $insurance['id'] }}">{{ $insurance['insuranceName'] }}</option>
                        @endforeach
                    </select>
                    <span class="text-red-500">@error('reportType') {{ $message }} @enderror</span>
                </div>
            @endif

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


            <div class="w-full md:w-1/12 px-2  flex items-center ">
                <button @disabled($reportType == "") type="button" wire:click="getReport()"
                        class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white"><i
                        class="fa fa-file-lines"></i></button>
            </div>

            <div class="w-full md:w-1/12 px-2  flex items-center " id="printReport">
                <button @disabled($reportType == "") type="button" wire:click="getReport()"
                        class=" py-2.5 bg-blue-600 hover:bg-cyan-700 w-full mt-2 rounded text-white"><i
                        class="fa fa-print"></i></button>
            </div>
        </div>
    </div>

    <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl mx-5  my-0">
        <div class="overflow-auto h-80">
            <div class="report" dir="rtl">
                <div class="header hidden print:block">
                    <div class="flex items-center border border-2 rounded-xl px-1 border-cyan-600"
                         style="height: 90px;">
                        <div class="w-1/5 rounded-xl">
                            <img src="{{asset("js/newheader.jpg")}}" style="width: 100%;">
                        </div>
                        <div class="w-3/5 items-center text-center">
                            <h2 class="result-header">معمل النخبة للتحاليل الطبيه</h2>
                        </div>
                        <div class="w-1/5 rounded-xl">
                            <img src="{{asset("js/newheader.jpg")}}" style="width: 100%;">
                        </div>
                    </div>
                    <span class="mx-5">التاريخ: {{ date("Y-m-d") }}</span>
                    <h3 class="text-center font-extrabold">{{ $reports[$reportType] . ' من تاريخ : ' . $from . ' إلى تاريخ : ' . $to }}</h3>
                </div>
                <div class="print:mx-5">
                    @if($reportType == "generalReport")
                        <table class="w-full table-fixed text-center">
                            <thead class="bg-cyan-700 font-extrabold text-white">
                            <tr>
                                <th class="py-2 ">البيان</th>
                                <th class="py-2 ">المبلغ</th>
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
                                <th class="py-2 ">الجمله</th>
                                <th class="py-2 ">{{ number_format($generalSum, 2) }}</th>
                            </tr>
                            </tfoot>
                        </table>
                    @elseif($reportType == "incomesReport")
                        @if(!empty($incomes))
                            <table class="w-full table-fixed text-center">
                                <thead class="bg-cyan-700 font-extrabold text-white">
                                <tr>
                                    <th class="py-2 ">التاريخ</th>
                                    <th class="py-2 ">إسم المريض</th>
                                    <th class="py-2 ">المبلغ</th>
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
                                    <th class="py-2 " colspan="2">الجمله</th>
                                    <th class="py-2 ">{{ number_format($incomes->sum("amount"), 2) }}</th>
                                </tr>
                                </tfoot>
                            </table>
                        @endif
                    @elseif($reportType == "employeesReport")
                        @if(!empty($employees))
                            <table class="w-full table-fixed text-center">
                                <thead class="bg-cyan-700 font-extrabold text-white">
                                <tr>
                                    <th class="py-2 ">التاريخ</th>
                                    <th class="py-2 ">إسم الموظف</th>
                                    <th class="py-2 ">المبلغ</th>
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
                                    <th class="py-2 " colspan="2">الجمله</th>
                                    <th class="py-2 ">{{ number_format($employees->sum("amount"), 2) }}</th>
                                </tr>
                                </tfoot>
                            </table>
                        @endif
                    @elseif($reportType == "expensesReport")
                        @if(!empty($expenses))
                            <table class="w-full table-fixed text-center">
                                <thead class="bg-cyan-700 font-extrabold text-white">
                                <tr>
                                    <th class="py-2 ">التاريخ</th>
                                    <th class="py-2 ">البيان</th>
                                    <th class="py-2 ">المبلغ</th>
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
                                    <th class="py-2 " colspan="2">الجمله</th>
                                    <th class="py-2 ">{{ number_format($expenses->sum("amount"), 2) }}</th>
                                </tr>
                                </tfoot>
                            </table>
                        @endif
                    @elseif($reportType == "insuranceReport" && !empty($visits))
                        <h3>شركة تأمين : {{ $insurances[$insurance_id]['insuranceName'] }}</h3>
                        <table class="w-full table-fixed text-center">
                            <thead class="bg-cyan-700 font-extrabold text-white">
                            <tr>
                                <th class="py-2 ">التاريخ</th>
                                <th class="py-2 ">إسم المريض</th>
                                <th class="py-2 ">المبلغ</th>
                                <th class="py-2 ">نسبة المريض</th>
                                <th class="py-2 ">تحمل المريض</th>
                                <th class="py-2 ">تحمل التأمين</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $patientEndurance = 0;
                                $insuranceEndurance = 0;
                            @endphp
                            @foreach($visits as $visit)
                                @php
                                    $patientEndurance += floatval($visit->total_amount) * (floatval($visit->patientEndurance) / 100);
                                    $insuranceEndurance += floatval($visit->total_amount) * ((100 - floatval($visit->patientEndurance)) / 100);
                                @endphp
                                <tr>
                                    <td class="py-2">{{ $visit->visit_date }}</td>
                                    <td>{{ $visit->patient->patientName }}</td>
                                    <td>{{ number_format($visit->total_amount, 2) }}</td>
                                    <td>{{ $visit->patientEndurance . "%" }}</td>
                                    <td>{{ number_format($visit->total_amount * ($visit->patientEndurance / 100), 2) }}</td>
                                    <td>{{ number_format($visit->total_amount * ((100 - $visit->patientEndurance) / 100), 2) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="bg-cyan-700 font-extrabold text-white">
                            <tr>
                                <th class="py-2 " colspan="2">الجمله</th>
                                <th class="py-2 ">{{ number_format($visits->sum("total_amount"), 2) }}</th>
                                <th></th>
                                <th class="py-2 ">{{ number_format($patientEndurance, 2) }}</th>
                                <th class="py-2 ">{{ number_format($insuranceEndurance, 2) }}</th>
                            </tr>
                            </tfoot>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
