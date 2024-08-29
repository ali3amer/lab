<div wire:keydown.esc.window="resetData()" class="">
    <livewire:header :$header/>
    <div class="p-5 text-cyan-800 bg-white font-extrabold max-w-full border-2 border-dashed rounded-2xl my-2 mx-5">
        <form class="w-full" wire:submit="save()">
            <div class="flex flex-wrap -mx-3">
                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="patientName">
                        إسم شركة التأمين
                    </label>
                    <input autocomplete="off" @disabled(!empty($currentInsurance)) required wire:model="insuranceName"
                           class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="insuranceName" type="text" placeholder="إسم شركة التأمين">
                    <span class="text-red-500">@error('insuranceName') {{ $message }} @enderror</span>
                </div>

                <div class="w-full md:w-1/6 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="companyEndurance">
                        نسبة تحمل الشركه
                    </label>
                    <input autocomplete="off" @disabled(!empty($currentInsurance)) wire:model="companyEndurance"
                           class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="companyEndurance" type="text" placeholder="نسبة تحمل الشركه">
                </div>

                <div class="w-full md:w-1/6 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="patientEndurance">
                        نسبة تحمل المريض
                    </label>
                    <input autocomplete="off" @disabled(!empty($currentInsurance)) wire:model="patientEndurance"
                           class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="patientEndurance" type="text" placeholder="نسبة تحمل المريض">
                </div>
                <div class="w-full md:w-1/4 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="contractDate">
                        تاريخ التعاقد
                    </label>
                    <input autocomplete="off" @disabled(!empty($currentInsurance)) wire:model="contractDate"
                           class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="contractDate" type="date">
                </div>

                <div class="md:w-1/6 px-2  flex items-center ">
                    @if(empty($currentInsurance))
                        <button type="submit"
                                class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{$id == 0 ? 'حفظ': 'تعديل'}}</button>
                    @else
                        <button type="button" class=" py-2.5 bg-red-800 hover:bg-red-700 w-full mt-2 rounded text-white"
                                wire:click="resetData()"><i class="fa fa-close"></i></button>
                    @endif
                </div>
            </div>

        </form>
    </div>


    @if(empty($currentInsurance))
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
            <div class="overflow-auto h-80">
                <table class="table-fixed w-full">
                    <thead class="bg-cyan-700 text-white">
                    <tr>
                        <th class="py-2 rounded-r-2xl">إسم شركة التأمين</th>
                        <th>نسبة تحمل الشركه</th>
                        <th>نسبة تحمل المريض</th>
                        <th>تاريخ التعاقد</th>
                        <th>المطالبه</th>
                        <th class="rounded-l-2xl">التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <tr>
                        <td class="py-2 rounded-r-2xl">
                        </td>
                        <td class="py-2 rounded-r-2xl">
                            <input autocomplete="off" type="text" wire:model.live="searchName" wire:keydown="search()"
                                   class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                   placeholder="إسم شركة التأمين">
                        </td>
                        <td class="py-2 rounded-r-2xl">
                        </td>
                        <td class="py-2 rounded-r-2xl">
                        </td>
                        <th class="rounded-l-2xl"></th>
                    </tr>

                    @foreach($insurances as $insurance)
                        <tr class="border-b-2">
                            <td>{{$insurance->insuranceName}}</td>
                            <td>{{$insurance->companyEndurance}}</td>
                            <td>{{$insurance->patientEndurance}}</td>
                            <td>{{$insurance->contractDate}}</td>
                            <td>{{number_format($insurance->balance, 2)}}</td>
                            <td>
                                <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                        wire:click="edit({{$insurance}})"><i class="fa fa-pen"></i></button>
                                <button class="bg-red-400 p-2 rounded text-xs text-white"
                                        wire:click="delete({{$insurance->id}})"><i class="fa fa-trash"></i></button>
                                <button class="bg-yellow-400 p-2 rounded text-xs text-white"
                                        wire:click="chooseInsurance({{$insurance}})"><i class="fa fa-eye"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
            <form class="w-full" wire:submit="saveDebt()">
                <div class="flex flex-wrap -mx-3">

                    <div class="w-full md:w-1/6 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="amount">
                            المبلغ
                        </label>
                        <input autocomplete="off" wire:model="amount"
                               class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="amount" type="text" placeholder="المبلغ">
                    </div>
                    <div class="w-full md:w-1/6 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="paid_date">
                            تاريخ الدفع
                        </label>
                        <input autocomplete="off" wire:model="paid_date"
                               class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="paid_date" type="date">
                    </div>

                    <div class="w-full md:w-1/4 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="note">
                            ملاحظات
                        </label>
                        <input autocomplete="off" wire:model="note"
                               class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="note" type="text" placeholder="ملاحظات">
                    </div>

                    <div class="w-full md:w-1/6 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="note">
                            الرصيد
                        </label>
                        <input disabled autocomplete="off" wire:model="balance"
                               class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="note" type="text" placeholder="الرصيد">
                    </div>

                    <div class="w-full md:w-1/6 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="note">
                            المتبقي
                        </label>
                        <input disabled autocomplete="off" wire:model="remainder"
                               class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="note" type="text" placeholder="المتبقي">
                    </div>
                    <div class="md:w-1/12 px-2  flex items-center ">
                        <button type="submit"
                                class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-3 rounded text-white">{{$debtId == 0 ? 'حفظ': 'تعديل'}}</button>
                    </div>
                </div>

            </form>
        </div>

        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
            <div class="overflow-auto h-80">
                <table class="table-fixed w-full">
                    <thead class="bg-cyan-700 text-white">
                    <tr>
                        <th class="py-2 rounded-r-2xl">تاريخ الدفع</th>
                        <th>المبلغ المدفوع</th>
                        <th>ملاحظات</th>
                        <th class="rounded-l-2xl">التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @if(!empty($debts))
                        @foreach($debts as $debt)
                            <tr class="border-b-2">
                                <td class="py-2">{{$debt->paid_date}}</td>
                                <td>{{number_format($debt->amount, 2)}}</td>
                                <td>{{$debt->note}}</td>
                                <td>
                                    <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                            wire:click="editDebt({{$debt}})"><i class="fa fa-pen"></i></button>
                                    <button class="bg-red-400 p-2 rounded text-xs text-white"
                                            wire:click="deleteDebt({{$debt->id}})"><i class="fa fa-trash"></i></button>
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
