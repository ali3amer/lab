<div class="">
    <div wire:loading
         class="h-screen w-full fixed top-0 right-0 bg-gray-700 opacity-25 z-10 absolute text-center justify-items-center">
        <div class="flex items-center h-screen">
            <div class="w-full">
                <i class="fa-solid fa-circle-notch fa-spin text-red-900 " style="font-size: xxx-large"></i>

            </div>
        </div>
    </div>
    <livewire:header :$header/>

    @if($user->hasPermission("expenses-create") || $user->hasPermission("expenses-update"))
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl m-5">
            <form class="w-full" wire:submit="save()">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="description">
                            البيان
                        </label>
                        <input autocomplete="off" required
                               wire:model.live="description"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="description" type="text" placeholder="البيان">
                        <span class="text-red-500">@error('description') {{ $message }} @enderror</span>
                    </div>

                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="expenseDate">
                            التاريخ
                        </label>
                        <input autocomplete="off" required
                               wire:model.live="expenseDate"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="expenseDate" type="date">
                        <span class="text-red-500">@error('expenseDate') {{ $message }} @enderror</span>
                    </div>

                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="amount">
                            المبلغ
                        </label>
                        <input autocomplete="off" required
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
    @endif
    @if($user->hasPermission("expenses-read"))
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

            <div class="overflow-auto h-80">
                <table class="table-fixed w-full">
                    <thead class="bg-cyan-700 text-white">
                    <tr>
                        <th class="py-2 rounded-r-2xl">#</th>
                        <th>التاريخ</th>
                        <th>البيان</th>
                        <th>المبلغ</th>
                        <th class="rounded-l-2xl">التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">

                    @if(!empty($expenses))
                        @foreach($expenses as $expense)
                            <tr class="border-b-2">
                                <td class="py-2">{{$expense->id}}</td>
                                <td>{{$expense->expenseDate}}</td>
                                <td>{{$expense->description}}</td>
                                <td>{{number_format($expense->amount, 2)}}</td>
                                <td>
                                    @if($user->hasPermission("expenses-update"))
                                        <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                                wire:click="edit({{$expense}})"><i class="fa fa-pen"></i></button>
                                    @endif
                                    @if($user->hasPermission("expenses-delete"))
                                        <button class="bg-red-400 p-2 rounded text-xs text-white"
                                                wire:click="deleteExpenseMessage({{$expense->id}})"><i
                                                class="fa fa-trash"></i>
                                        </button>
                                    @endif
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
