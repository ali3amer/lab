<div class="">
    <div wire:loading class="h-screen w-full fixed top-0 right-0 bg-gray-700 opacity-25 z-10 absolute text-center justify-items-center">
        <div class="flex items-center h-screen">
            <div class="w-full">
                <i class="fa-solid fa-circle-notch fa-spin text-red-900 " style="font-size: xxx-large"></i>

            </div>
        </div>
    </div>
    <livewire:header :$header/>

    @if(empty($currentEmployee))
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl m-5">
            <form class="w-full" wire:submit="save()">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="description">
                            إسم الموظف
                        </label>
                        <input autocomplete="off" required
                               wire:model.live="employeeName"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="employeeName" type="text" placeholder="إسم الموظف">
                        <span class="text-red-500">@error('employeeName') {{ $message }} @enderror</span>
                    </div>

                    <div class="w-full md:w-1/6 px-2  flex items-center ">
                        <button type="submit"
                                class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{$id == 0 ? 'حفظ': 'تعديل'}}</button>
                    </div>
                </div>


            </form>
        </div>

        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

            <div class="overflow-auto h-80">
                <table class="table-fixed w-full">
                    <thead class="bg-cyan-700 text-white">
                    <tr>
                        <th class="py-2 rounded-r-2xl">#</th>
                        <th>إسم الموظف</th>
                        <th class="rounded-l-2xl">التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">

                    @if(!empty($employees))
                        @foreach($employees as $employee)
                            <tr class="border-b-2">
                                <td class="py-2">{{$employee->id}}</td>
                                <td>{{$employee->employeeName}}</td>
                                <td>
                                    <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                            wire:click="edit({{$employee}})"><i class="fa fa-pen"></i></button>
                                    <button class="bg-red-400 p-2 rounded text-xs text-white"
                                            wire:click="deleteEmployeeMessage({{$employee->id}})"><i class="fa fa-trash"></i>
                                    </button>
                                    <button class="bg-yellow-400 p-2 rounded text-xs text-white"
                                            wire:click="chooseEmployee({{$employee}})"><i class="fa fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

        </div>
    @else
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl m-5">
            <form class="w-full" wire:submit="saveEmployeeExpenses()">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="description">
                            إسم الموظف
                        </label>
                        <input autocomplete="off" disabled
                               wire:model.live="currentEmployee.employeeName"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="employeeName" type="text" placeholder="إسم الموظف">
                        <span class="text-red-500">@error('employeeName') {{ $message }} @enderror</span>
                    </div>

                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="payDate">
                            التاريخ
                        </label>
                        <input autocomplete="off" required
                               wire:model.live="payDate"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="payDate" type="date" >
                        <span class="text-red-500">@error('payDate') {{ $message }} @enderror</span>
                    </div>

                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="amount">
                            المبلغ
                        </label>
                        <input autocomplete="off"
                               wire:model.live="amount"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="amount" type="text" placeholder="المبلغ">
                        <span class="text-red-500">@error('amount') {{ $message }} @enderror</span>
                    </div>

                    <div class="w-full md:w-1/6 px-2  flex items-center ">
                        <button type="submit"
                                class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{$id == 0 ? 'حفظ': 'تعديل'}}</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

            <div class="overflow-auto h-80">
                <table class="table-fixed w-full">
                    <thead class="bg-cyan-700 text-white">
                    <tr>
                        <th class="py-2 rounded-r-2xl">التاريخ</th>
                        <th>المبلغ</th>
                        <th class="rounded-l-2xl">التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">

                    @if(!empty($expenses))
                        @foreach($expenses as $expense)
                            <tr class="border-b-2">
                                <td class="py-2">{{$expense->payDate}}</td>
                                <td>{{$expense->amount}}</td>
                                <td>
                                    <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                            wire:click="editExpense({{$expense}})"><i class="fa fa-pen"></i></button>
                                    <button class="bg-red-400 p-2 rounded text-xs text-white"
                                            wire:click="deleteEmployeeExpenseMessage({{$expense->id}})"><i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

        </div>

    @endif

</div>
