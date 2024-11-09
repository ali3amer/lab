<div class="">
    <div
        class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

        <form wire:submit="save()">
            <div class="flex flex-wrap">

                <div class="w-1/5 px-2 ">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="gender">
                        الجنس
                    </label>
                    <select wire:model="gender" @disabled($rangeMode)
                    class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="gender">
                        @foreach($genders as $index => $option)
                            <option value="{{$index}}">{{$option}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-1/5 px-2 ">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="age">
                        الفئة العمرية
                    </label>
                    <select wire:model.live="age" @disabled($rangeMode)
                    class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="age">
                        @foreach($ages as $index => $option)
                            <option value="{{$index}}">{{$option}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-1/5 px-3 ">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="min_age">
                        العمر من
                    </label>
                    <input autocomplete="off" @disabled($rangeMode) @disabled($age == "all")
                    wire:model="min_age"
                           class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="min_age" type="text" placeholder="العمر من">
                    <span class="text-red-500">@error('min_age') {{ $message }} @enderror</span>
                </div>

                <div class="w-1/5 px-3 ">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="max_age">
                        العمر الى
                    </label>
                    <input autocomplete="off" @disabled($rangeMode) @disabled($age == "all")
                    wire:model="max_age"
                           class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="max_age" type="text" placeholder="العمر الى">
                    <span class="text-red-500">@error('max_age') {{ $message }} @enderror</span>
                </div>
                <div class="w-1/5 flex items-center">
                    @if(!$rangeMode)
                        <button type="submit"
                                class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{ $id == 0 ? "حفظ" : "تعديل" }}
                        </button>
                    @else
                        <button type="button" wire:click="resetData()"
                                class=" py-2.5 bg-red-800 hover:bg-red-700 w-full mt-2 rounded text-white"><i
                                class="fa fa-close"></i></button>
                    @endif
                </div>
            </div>
        </form>

    </div>

    @if(!$rangeMode)
        <div
            class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

            <div class="w-full block max-h-96 overflow-auto mt-2">
                <table class="table-fixed relative max-h-96 w-full overflow-auto">
                    <thead class="bg-cyan-700 text-white sticky top-0">
                    <tr>
                        <th class="py-2 rounded-r-2xl">النوع</th>
                        <th>الفئة العمرية</th>
                        <th>الفتره</th>
                        <th class="rounded-l-2xl">التحكم</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ageGenderGroups as $ageGenderGroup)
                        <tr class="border-b-2 text-center">
                            <td class="py-2">{{$genders[$ageGenderGroup->gender]}}</td>
                            <td class="py-2">
                                {{$ages[$ageGenderGroup->age]}}
                            </td>
                            <td class="py-2">
                                @if($ageGenderGroup->age != "all")
                                    {{ $ageGenderGroup->min_age . " - " . $ageGenderGroup->max_age . " " . $ageGenderGroup[$ageGenderGroup->age] }}
                                @endif
                            </td>
                            <td class="py-2">
                                <button class="bg-yellow-400 p-2 rounded text-xs text-white"
                                        wire:click="chooseAgeGenderGroup({{$ageGenderGroup}})"><i
                                        class="fa fa-eye"></i>
                                </button>

                                <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                        wire:click="edit({{$ageGenderGroup}})"><i
                                        class="fa fa-pen"></i>
                                </button>
                                <button class="bg-red-400 p-2 rounded text-xs text-white"
                                        wire:click="deleteMassage({{$ageGenderGroup->id}})"><i
                                        class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    @else
        <livewire:range :$result_type :$age_gender_group_id/>
    @endif


</div>
