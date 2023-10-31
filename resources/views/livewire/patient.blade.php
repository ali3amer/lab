<div wire:keydown.esc.window="resetData()" class="">
    <livewire:header :$header />
    <div class="p-5 text-cyan-800 bg-white font-extrabold max-w-full border-2 border-dashed rounded-2xl my-2 mx-5">
        <form class="w-full" wire:submit="save()">
            <div class="flex flex-wrap -mx-3">
                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="patientName">
                        إسم المريض
                    </label>
                    <input autocomplete="off" required wire:model="patientName" class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="patientName" type="text" placeholder="إسم المريض">
                    <span class="text-red-500">@error('patientName') {{ $message }} @enderror</span>
                </div>

                <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="gender">
                        النوع
                    </label>
                    <select wire:model="gender" class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="gender">
                        <option value="male">ذكر</option>
                        <option value="female">أنثى</option>
                    </select>

                </div>

                <div class="w-full md:w-1/6 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="age">
                        العمر
                    </label>
                    <input autocomplete="off" wire:model="age" class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="age" type="text" placeholder="العمر">
                </div>

                <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="gender">
                        الفتره
                    </label>
                    <select wire:model="duration" class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="gender">
                        @foreach($durations as $key => $time)
                            <option value="{{$key}}">{{$time}}</option>
                        @endforeach
                    </select>

                </div>

                <div class="w-full md:w-1/6 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="phone">
                        الهاتف
                    </label>
                    <input autocomplete="off" wire:model="phone" class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="phone" type="text" placeholder="الهاتف">
                </div>

                <div class="w-full md:w-1/12 px-2  flex items-center ">
                    <button type="submit" class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{$id == 0 ? 'حفظ': 'تعديل'}}</button>
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
                    <th>إسم المريض</th>
                    <th>النوع</th>
                    <th>العمر</th>
                    <th>الفتره</th>
                    <th>الهاتف</th>
                    <th class="rounded-l-2xl">التحكم</th>
                </tr>
                </thead>
                <tbody class="text-center">
                <tr>
                    <td class="py-2 rounded-r-2xl">
                    </td>
                    <td class="py-2 rounded-r-2xl">
                        <input autocomplete="off" type="text" wire:model.live="searchName" wire:keydown="search()" class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="إسم المريض">
                    </td>
                    <td class="py-2 rounded-r-2xl">
                        <select wire:model.live="searchGender" wire:change="search()" class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-1.5 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="gender">
                            <option value="choose">---</option>
                            <option value="male">ذكر</option>
                            <option value="female">أنثى</option>
                        </select>
                    </td>
                    <td class="py-2 rounded-r-2xl">
                        <input autocomplete="off" type="text" wire:model.live="searchAge" wire:keydown="search()" class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="العمر">
                    </td>
                    <td class="py-2 rounded-r-2xl">
                        <select wire:model.live="searchDuration" wire:change="search()" class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-1.5 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="gender">
                            <option value="choose">---</option>
                            @foreach($durations as $key => $time)
                                <option value="{{$key}}">{{$time}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="py-2 rounded-r-2xl">
                        <input autocomplete="off" type="text" wire:model.live="searchPhone" wire:keydown="search()" class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="الهاتف">
                    </td>
                    <th class="rounded-l-2xl"></th>
                </tr>

                @foreach($patients as $patient)
                    <tr class="border-b-2">
                        <td class="py-2">{{$patient->id}}</td>
                        <td>{{$patient->patientName}}</td>
                        <td>{{$patient->gender == 'male' ? 'ذكر' : 'أنثى'}}</td>
                        <td>{{$patient->age}}</td>
                        <td>{{$durations[$patient->duration]}}</td>
                        <td>{{$patient->phone}}</td>
                        <td>
                            <button class="bg-cyan-400 p-2 rounded text-xs text-white" wire:click="edit({{$patient}})"><i class="fa fa-pen"></i></button>
                            <button class="bg-red-400 p-2 rounded text-xs text-white" wire:click="delete({{$patient->id}})"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
