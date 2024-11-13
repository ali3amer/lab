<div>
    @if($user->hasPermission("visits-create") || $user->hasPermission("visits-update"))
        <div
            class="p-5 text-cyan-800 bg-white font-extrabold max-w-full border-2 border-dashed rounded-2xl my-2 mx-5">
            <form id="visit" class="w-full" wire:submit="save()">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="id">
                            رقم زيارة المريض
                        </label>
                        <input autocomplete="off" disabled wire:model="id"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="id" type="text">
                        <span class="text-red-500">@error('id') {{ $message }} @enderror</span>
                    </div>

                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="visit_date">
                            تاريخ الزيارة
                        </label>
                        <input autocomplete="off" required wire:model="visit_date"
                               @disabled($visitTestMode)
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="patientName" type="date">
                        <span class="text-red-500">@error('patientName') {{ $message }} @enderror</span>
                    </div>

                    <div class="w-full md:w-1/4 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="doctor">
                            الدكتور
                        </label>
                        <input autocomplete="off" wire:model="doctor" @disabled($visitTestMode)
                        class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="doctor" type="text" placeholder="الدكتور">
                    </div>

                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="gender">
                            التأمين
                        </label>
                        <select wire:model="insurance_id" @disabled($visitTestMode)
                        class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="insurance_id">
                            <option>--------------</option>
                            @foreach($insurances as $insurance)
                                <option value="{{$insurance['id']}}">{{$insurance['insuranceName']}}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="w-full md:w-1/4 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="amount">
                            الجمله
                        </label>
                        <input autocomplete="off" wire:model.live="amount" disabled
                               class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="amount" type="text" placeholder="الجمله">
                    </div>

                    <div class="w-full md:w-1/4 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="discount">
                            التخفيض
                        </label>
                        <input @disabled($visitTestMode) autocomplete="off"
                               wire:model.live="discount"
                               class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="discount" type="text" placeholder="التخفيض">
                    </div>

                    <div class="w-full md:w-1/4 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="total_amount">
                            الصافي
                        </label>
                        <input autocomplete="off" wire:model="total_amount" disabled
                               class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="total_amount" type="text" placeholder="الصافي">
                    </div>

                    <div class="w-full md:w-1/4 px-2  flex items-end ">
                        @if(!$visitTestMode)
                            <button type="submit"
                                    class=" py-2.5 px-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">
                                {{ $id == 0 ? "حفظ" : "تعديل" }}
                            </button>
                        @else
                            <button type="button" wire:click="resetVisitData()"
                                    class=" py-2.5 bg-red-800 hover:bg-red-700 w-full mt-2 rounded text-white">
                                <i
                                    class="fa fa-close"></i></button>

                        @endif
                    </div>
                </div>

            </form>
        </div>
    @endif
    @if(!$visitTestMode && $user->hasPermission("visits-read"))
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

            <div class="overflow-auto h-80">
                <table class="table-fixed relative max-h-96 w-full overflow-auto">
                    <thead class="bg-cyan-700 text-white sticky top-0 ">
                    <tr>
                        <th class="py-2 rounded-r-2xl">#</th>
                        <th>تاريخ الزيارة</th>
                        <th>الدكتور</th>
                        <th>التأمين</th>
                        <th>نسبة التحمل</th>
                        <th>المبلغ</th>
                        <th>التخفيض</th>
                        <th>الصافي</th>
                        <th class="rounded-l-2xl">التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($visits as $visit)
                        <tr class="border-b-2">
                            <td class="py-2">{{$visit->id}}</td>
                            <td>{{$visit->visit_date}}</td>
                            <td>{{$visit->doctor}}</td>
                            <td>{{$visit->insurance_id ? $visit->insurance->insuranceName : ""}}</td>
                            <td>  {{$visit->patientEndurance}} %</td>
                            <td>{{number_format($visit->amount, 2)}}</td>
                            <td>{{number_format($visit->discount, 2)}}</td>
                            <td>{{number_format($visit->total_amount * ($visit->patientEndurance / 100), 2)}}</td>
                            <td>
                                @if($user->hasPermission("visits-update"))
                                    <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                            wire:click="edit({{$visit}})">
                                        <i class="fa fa-pen"></i></button>
                                @endif
                                @if($user->hasPermission("visits-delete"))
                                    <button class="bg-red-400 p-2 rounded text-xs text-white"
                                            wire:click="deleteMessage({{$visit->id}})"><i
                                            class="fa fa-trash"></i></button>
                                @endif
                                @if($user->hasPermission("visits-delete") || $user->hasPermission("visits-update"))
                                    <button class="bg-yellow-400 p-2 rounded text-xs text-white"
                                            wire:click="chooseVisit({{$visit}})"><i class="fa fa-eye"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    @else
        <livewire:visit-test :$visit_id />
    @endif
</div>
