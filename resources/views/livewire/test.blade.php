<div class="">
    <livewire:header :$header/>

    @if($modals["rangeModal"])
        <div
            class="modal w-full h-screen fixed left-0 z-10 top-0 flex justify-center bg-black bg-opacity-75">
            <div class="bg-gray-100 relative mt-14 h-96 rounded z-20 shadow-lg w-2/3">
                <div class="border-b px-4 flex justify-between items-center py-2">
                    <h2>{{ $currentTest["testName"] ?? ""}}</h2>
                    <button class="text-black close-modal" wire:click="closeModal('rangeModal')">&cross;</button>
                </div>

                <div class="w-full px-3">
                    <div class="flex flex-wrap my-1 bg-white rounded-2xl -mx-3">
                        <div class="w-full md:w-1/3 px-3 py-1">
                            <input
                                autocomplete="off"
                                wire:model.live="choiceName"
                                class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                id="main-choice"
                                type="text"
                                placeholder="أدخل واضغط Enter"
                            >
                        </div>

                        <div class="w-full mt-2 md:w-1/12 px-2">
                            <button type="button" wire:click="addChoice"
                                    class="bg-cyan-800 hover:bg-cyan-700 w-full py-2 rounded text-white"><i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end item-center w-100 border-t absolute w-full bottom-0 p-3">
                    <button class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white ml-1">حفظ</button>
                    <button class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white close-modal">إلغاء</button>
                </div>
            </div>
        </div>
    @endif

    @if(!empty($currentCategory))
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
            <form class="w-full" wire:submit="saveTest()">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="testName">
                            إسم الفحص
                        </label>
                        <input autocomplete="off" required wire:model="testName" @disabled($rangeMode)
                        class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="testName" type="text" placeholder="إسم الفحص">
                        <span class="text-red-500">@error('testName') {{ $message }} @enderror</span>
                    </div>


                    <div class="w-full md:w-1/5 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for=shortcut">
                            الإختصار
                        </label>
                        <input autocomplete="off" wire:model="shortcut" @disabled($rangeMode)
                        class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id=shortcut" type="text" placeholder="الإختصار (إختياري)">
                    </div>


                    <div class="w-full md:w-1/6 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for=unit">
                            الوحده
                        </label>
                        <input autocomplete="off" wire:model="unit" @disabled($rangeMode)
                        class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id=unit" type="text" placeholder="الإختصار (إختياري)">
                    </div>

                    <div class="w-full md:w-1/6 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="price">
                            السعر
                        </label>
                        <input autocomplete="off" wire:model="price" @disabled($getAll) @disabled($rangeMode)
                        class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="price" type="text" placeholder="السعر">
                    </div>

                    <div class="w-1/12 px-3 flex items-center">
                        <input checked id="getAll" wire:model="getAll" type="checkbox"
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="getAll"
                               class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            إضافة الكل</label>
                    </div>

                    <div class="w-full md:w-1/12 px-2  flex items-center ">
                        @if(!$rangeMode)
                            <button type="submit"
                                    class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{$id == 0 ? 'حفظ': 'تعديل'}}</button>
                        @else
                            <button type="button" wire:click="resetTestData()"
                                    class=" py-2.5 bg-red-800 hover:bg-red-700 w-full mt-2 rounded text-white"><i
                                    class="fa fa-close"></i></button>

                        @endif
                    </div>
                </div>

            </form>
        </div>

        @if(!$rangeMode)
            <div class="px-5 py-1 text-cyan-800 bg-white flex font-extrabold border-2 border-dashed rounded-2xl mx-5">
                <div wire:click="changeLocation(-1)" class="mr-1 text-black cursor-pointer"><i class="fa fa-home"></i>
                </div>
                /
                @foreach($currentLocation as $index => $location)
                    <div wire:click="changeLocation({{$index}})"
                         class="mr-1 text-black cursor-pointer">{{ $location }} </div> {{ !$loop->last ? "/" : '' }}
                @endforeach
            </div>

            <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
                <div class="max-h-75 overflow-auto block max-h-96">
                    <table class="table-fixed relative max-h-96 w-full overflow-auto">
                        <thead class="bg-cyan-700 text-white sticky top-0 ">
                        <tr>
                            <th class="rounded-r-2xl py-2">إسم الفحص</th>
                            <th>الإختصار</th>
                            <th>الوحده</th>
                            <th>السعر</th>
                            <th>الكل</th>
                            <th class="rounded-l-2xl">التحكم</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">

                        @foreach($tests as $test)
                            <tr class="border-b-2">
                                <td class="py-2">{{ $test->testName }}</td>
                                <td>{{ $test->shortcut }}</td>
                                <td>{{ $test->unit }}</td>
                                <td>{{ number_format($test->price, 2) }}</td>
                                <td>{{ $test->getAll ? "نعم" : "لا" }}</td>
                                <td>
                                    <button class="py-1 px-2 rounded bg-blue-600 text-white"
                                            wire:click="chooseTest({{$test->id}})"><i class="fa fa-plus"></i></button>
                                    <button class="py-1 px-2 rounded bg-gray-600 text-white"
                                            wire:click="editTest({{$test}})"><i class="fa fa-edit"></i></button>
                                    <button
                                        class="py-1 px-2 rounded bg-red-600 text-white disabled:bg-red-300 disabled:cursor-not-allowed"
                                        @disabled($test->children->count() > 0) wire:click="deleteTestMassage({{$test->id}})">
                                        <i class="fa fa-trash"></i></button>
                                    <button @disabled(empty($currentTest)) wire:click="editTest({{$test}}, {{true}})"
                                            class="py-1 px-2 rounded bg-blue-600 text-white show-modal disabled:bg-blue-300 disabled:cursor-not-allowed" @disabled($test->children->count() > 0)>
                                        <i class="fa fa-arrow-right-arrow-left"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="flex">
                <div
                    class="p-5 w-1/3 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

                    <form wire:submit="saveRange()">
                        <div class="flex flex-wrap -mx-2">

                            <div class="w-1/2 px-2 ">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="gender">
                                    الجنس
                                </label>
                                <select wire:model="gender"
                                        class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="gender">
                                    @foreach($genders as $index => $option)
                                        <option value="{{$index}}">{{$option}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-1/2 px-2 ">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="age">
                                    الفئة العمرية
                                </label>
                                <select wire:model.live="age"
                                        class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="age">
                                    @foreach($ages as $index => $option)
                                        <option value="{{$index}}">{{$option}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-1/2 px-3 ">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="min_age">
                                    العمر من
                                </label>
                                <input autocomplete="off" @disabled($age == "all")
                                wire:model="min_age"
                                       class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                       id="min_age" type="text" placeholder="العمر من">
                                <span class="text-red-500">@error('min_age') {{ $message }} @enderror</span>
                            </div>

                            <div class="w-1/2 px-3 ">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="max_age">
                                    العمر الى
                                </label>
                                <input autocomplete="off" @disabled($age == "all")
                                wire:model="max_age"
                                       class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                       id="max_age" type="text" placeholder="العمر الى">
                                <span class="text-red-500">@error('max_age') {{ $message }} @enderror</span>
                            </div>

                            <div class="w-full px-2 ">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="result_type">
                                    نوع المدى
                                </label>
                                <select wire:model.live="result_type"
                                        class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="result_type">
                                    @foreach($types as $index => $type)
                                        <option value="{{$index}}">{{$type}}</option>
                                    @endforeach
                                </select>
                            </div>


                            @if($result_type == "number")
                                <div class="w-1/2 px-3 ">
                                    <label
                                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                        for="max_value">
                                        من
                                    </label>
                                    <input autocomplete="off"
                                           wire:model="max_value"
                                           class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                           id="max_value" type="text" placeholder="أكبر من">
                                    <span class="text-red-500">@error('max_value') {{ $message }} @enderror</span>
                                </div>

                                <div class="w-1/2 px-3 ">
                                    <label
                                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                        for="min_value">
                                        الى
                                    </label>
                                    <input autocomplete="off"
                                           wire:model="min_value"
                                           class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                           id="min_value" type="text" placeholder="أقل من">
                                    <span class="text-red-500">@error('min_value') {{ $message }} @enderror</span>
                                </div>
                            @elseif($result_type == "multable_choice" || $result_type == "text_and_multable_choice")
                                <div class="w-full px-2  flex items-center ">
                                    <button type="submit" @disabled($choicesMode)
                                    class=" disabled:bg-cyan-400 disabled:cursor-not-allowed py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{ $range_id == 0 ? "إضافة خيارات" : "تعديل الخيارات" }}
                                    </button>
                                </div>
                            @endif

                            <div class="w-full px-2 ">

                            </div>

                            @if($result_type == "number")
                                <div class="w-full px-2  flex items-center ">
                                    <button type="submit"
                                            class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{ $refId == 0 ? "حفظ" : "تعديل" }}
                                    </button>
                                </div>
                            @endif
                        </div>
                    </form>

                </div>

                <div
                    class="p-5 w-2/3 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
                    @if(!$choicesMode)
                        <div class="w-full block max-h-96 overflow-auto mt-2">
                            <table class="table-fixed relative max-h-96 w-full overflow-auto">
                                <thead class="bg-cyan-700 text-white sticky top-0">
                                <tr>
                                    <th class="py-2 rounded-r-2xl">النوع</th>
                                    <th>نوع المدى</th>
                                    <th>الفئة العمرية</th>
                                    <th>البيان</th>
                                    <th class="rounded-l-2xl">التحكم</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($ranges))
                                    @foreach($ranges as $range)
                                        <tr class="border-b-2 text-center">
                                            <td class="py-2">{{$genders[$range->gender]}}</td>
                                            <td class="py-2">{{$types[$range->result_type]}}</td>
                                            <td class="py-2">
                                                @if($range->min_age == null)
                                                    {{$ages[$range->age]}}
                                                @else
                                                    {{ $range->min_age . " - " . $range->max_age . " " . $ages[$range->age] }}
                                                @endif
                                            </td>
                                            <td class="py-2">
                                                @if($range->result_type == "number")
                                                    {{ $range->min_value . " - " . $range->max_value }}
                                                @elseif($range->result_type == "text")
                                                @elseif($range->result_type == "multable_choice" || $range->result_type == "text_and_multable_choice")
                                                    @if(is_array($range->result_multable_choice) || is_object($range->result_multable_choice))
                                                        @foreach($range->result_multable_choice as $ch)
                                                            <span>{{$ch . ", "}}</span>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="py-2">
                                                <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                                        wire:click="editRange({{$range}})"><i
                                                        class="fa fa-pen"></i>
                                                </button>
                                                <button class="bg-red-400 p-2 rounded text-xs text-white"
                                                        wire:click="deleteMassageRange({{$range->id}})"><i
                                                        class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>

                            </table>
                        </div>

                    @else

                        <div class="flex flex-wrap">
                            <div class="w-1/3">
                                <input autocomplete="off"
                                       wire:model="choiceName"
                                       class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                       id="choiceName" type="text"
                                       placeholder="{{ empty($currentChoice) ? "إسم الاختيار" : " إختيار فرعي من " . $currentChoice['choiceName'] }}">
                                <span class="text-red-500">@error('choiceName') {{ $message }} @enderror</span>
                            </div>
                            <div class="w-1/4 px-3 flex items-center">
                                <input checked id="default" wire:model="default" type="checkbox"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="default"
                                       class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">خيار
                                    إفتراضي</label>
                            </div>
                            <div class="w-1/6 px-3 ">
                                <button type="button" wire:click="addChoice()"
                                        class=" py-2.5 w-full bg-cyan-800 hover:bg-cyan-700 rounded text-white"><i
                                        class="fa fa-plus"></i></button>
                            </div>

                            <div class="w-1/6 px-3 ">
                                <button type="button" wire:click="resetChoicesData()"
                                        class=" py-2.5 w-full bg-red-800 hover:bg-cyan-700 rounded text-white"><i
                                        class="fa fa-x"></i></button>
                            </div>

                            <table class="w-full table-fixed text-center">
                                <thead>
                                <tr class="bg-cyan-700 text-white">
                                    <th class="rounded-r-2xl py-1">الإختيار</th>
                                    <th class="">إفتراضي</th>
                                    <th class="rounded-l-2xl py-1">التحكم</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($choices))
                                    @foreach($choices as $option)
                                        <tr class="border-b">
                                            <td>{{ $option->choiceName }}</td>
                                            <td>{{ $option->default ? "نعم" : "لا" }}</td>
                                            <td>
                                                <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                                        wire:click="chooseChoice({{$option}})"><i
                                                        class="fa fa-plus"></i>
                                                </button>

                                                <button class="bg-red-400 p-2 rounded text-xs text-white"
                                                        wire:click="deleteChoice({{$option->id}})"><i
                                                        class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>
        @endif
    @else
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl m-5">
            <input type="text" value="الأقسام" class="p-2 my-2 border-2 text-center font-extrabold" disabled>
            <div class="overflow-auto block max-h-96">
                <table class="table-fixed relative max-h-96 w-full overflow-auto">
                    <thead class="bg-cyan-700 text-white sticky top-0 ">
                    <tr>
                        <th class=" rounded-l-2xl rounded-r-2xl py-2">إسم القسم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">

                    @foreach($categories as $category)
                        <tr class="border-b-2 cursor-pointer" wire:click="chooseCategory({{$category}})">
                            <td class="py-2">{{$category->categoryName}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>


