<div class="">
    <livewire:header :$header/>

    @if(!empty($currentAnalysis))
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl m-5">
            <div class="flex flex-wrap -mx-3">
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="analysisName">
                        إسم التحليل
                    </label>
                    <input autocomplete="off" required
                           disabled wire:model.live="analysisName"
                           class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="analysisName" type="text" placeholder="إسم التحليل">
                    <span class="text-red-500">@error('analysisName') {{ $message }} @enderror</span>
                </div>

                <div class="w-full md:w-1/3 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="phone">
                        الإختصار
                    </label>
                    <input autocomplete="off" disabled wire:model.live="shortcut"
                           class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                           id="shortcut" type="text" placeholder="الإختصار">
                </div>

                <div class="w-full md:w-1/12 px-2  flex items-center ">
                    <button type="button" wire:click="resetAnalysisData()"
                            class=" py-2.5 bg-red-800 hover:bg-red-700 w-full mt-2 rounded text-white"><i
                            class="fa fa-close"></i></button>
                </div>
            </div>
        </div>

        <div class="flex">
            <div class="w-1/2">
                <div class="p-2 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
                    <div class="">
                        <form wire:submit="saveSubAnalysis()" class="flex flex-wrap -mx-2">
                            <div class="w-1/3 px-3 ">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="analysisName">
                                    إسم التحليل
                                </label>
                                <input autocomplete="off" required
                                       wire:model.live="subAnalysisName"
                                       class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                       id="subAnalysisName" type="text" placeholder="إسم التحليل">
                                <span class="text-red-500">@error('subAnalysisName') {{ $message }} @enderror</span>
                            </div>

                            <div class="w-1/3 px-3 ">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="analysisName">
                                    السعر
                                </label>
                                <input autocomplete="off" required
                                       wire:model.live="price"
                                       class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                       id="price" type="text" placeholder="السعر ...">
                                <span class="text-red-500">@error('price') {{ $message }} @enderror</span>
                            </div>

                            <div class="w-1/6 px-3 ">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="analysisName">
                                    الوحده
                                </label>
                                <input autocomplete="off"
                                       wire:model.live="unit"
                                       class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                       id="unit" type="text" placeholder="الوحده">
                                <span class="text-red-500">@error('unit') {{ $message }} @enderror</span>
                            </div>

                            <div class="w-1/6 px-2  flex items-center ">
                                <button type="submit"
                                        class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white"><i
                                        class="fa fa-save"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
                    <div class="overflow-auto h-80">
                        <table class="table-fixed w-full">
                            <thead class="bg-cyan-700 text-white">
                            <tr>
                                <th class="rounded-r-2xl py-2">إسم التحليل</th>
                                <th>الوحده</th>
                                <th>السعر</th>
                                <th class="rounded-l-2xl">التحكم</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            <tr>
                                <td class="py-2 rounded-r-2xl">
                                    <input autocomplete="off" type="text" wire:model.live="searchSubAnalysisName"
                                           wire:keydown="searchSubAnalyses()"
                                           class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                           placeholder="إسم التحليل">
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            @if(!empty($subAnalyzes))
                                @foreach($subAnalyzes as $analysis)
                                    <tr class="border-b-2">
                                        <td>{{$analysis->subAnalysisName}}</td>
                                        <td>{{$analysis->unit}}</td>
                                        <td>{{$analysis->price}}</td>
                                        <td>
                                            <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                                    wire:click="editSubAnalysis({{$analysis}})"><i
                                                    class="fa fa-pen"></i>
                                            </button>
                                            <button class="bg-red-400 p-2 rounded text-xs text-white"
                                                    wire:click="deleteSubAnalysis({{$analysis->id}})"><i
                                                    class="fa fa-trash"></i>
                                            </button>
                                            <button class="bg-yellow-400 p-2 rounded text-xs text-white"
                                                    wire:click="chooseSubAnalysis({{$analysis}})"><i
                                                    class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="p-5 w-1/2 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
                <div class="flex flex-wrap -mx-2">
                    <div class="w-1/2 px-3 ">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="subAnalysisName">
                            إسم التحليل
                        </label>
                        <input autocomplete="off" disabled
                               wire:model.live="currentSubAnalysis.subAnalysisName"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="subAnalysisName" type="text" placeholder="إسم التحليل">
                        <span class="text-red-500">@error('subAnalysisName') {{ $message }} @enderror</span>
                    </div>

                    <div class="w-1/4 px-2 ">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="gender">
                            الجنس
                        </label>
                        <select wire:model="gender"
                                class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="gender">
                            <option value="all">الكل</option>
                            <option value="male">ذكر</option>
                            <option value="female">أنثى</option>
                        </select>
                    </div>

                    <div class="w-1/4 px-2 ">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="age_range">
                            الفئة العمرية
                        </label>
                        <select wire:model="age"
                                class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="age_range">
                            <option value="all">الكل</option>
                            <option value="years">سنوات</option>
                            <option value="months">شهور</option>
                            <option value="weeks">أسابيع</option>
                            <option value="days">أيام</option>
                        </select>
                    </div>

                    <div class="w-1/2 px-3 ">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="age_from">
                            عمر أكبر من
                        </label>
                        <input autocomplete="off"
                               wire:model.live="age_from"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="range_from" type="text" placeholder="عمر أكبر من">
                        <span class="text-red-500">@error('age_from') {{ $message }} @enderror</span>
                    </div>

                    <div class="w-1/2 px-3 ">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="age_to">
                            عمر أقل من
                        </label>
                        <input autocomplete="off"
                               wire:model.live="age_to"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="age_to" type="text" placeholder="عمر أقل من">
                        <span class="text-red-500">@error('age_to') {{ $message }} @enderror</span>
                    </div>

                    <div class="w-1/2 px-2 ">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="result_types">
                            نوع المدى
                        </label>
                        <select wire:model.live="result_types"
                                class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="result_types">
                            @foreach($types as $index => $type)
                                <option value="{{$index}}">{{$type}}</option>
                            @endforeach
                        </select>
                    </div>

                    @if($result_types == "number")
                        <div class="w-1/4 px-3 ">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="range_from">
                                أكبر من
                            </label>
                            <input autocomplete="off"
                                   wire:model.live="range_from"
                                   class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                   id="range_from" type="text" placeholder="أكبر من">
                            <span class="text-red-500">@error('range_from') {{ $message }} @enderror</span>
                        </div>

                        <div class="w-1/4 px-3 ">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="range_to">
                                أقل من
                            </label>
                            <input autocomplete="off"
                                   wire:model.live="range_to"
                                   class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                   id="range_to" type="text" placeholder="أقل من">
                            <span class="text-red-500">@error('range_to') {{ $message }} @enderror</span>
                        </div>
                    @elseif($result_types == "multable_choice" || $result_types == "text_and_multable_choice")
                        <div class="w-1/2 px-3 ">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="multable_choice">
                                الخيارات
                            </label>
                            <input autocomplete="off"
                                   wire:model.live="choice" wire:keydown.enter="addChoice()"
                                   class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                   id="text" type="text" placeholder="إضغط Enter">
                            <span class="text-red-500">@error('multable_choice') {{ $message }} @enderror</span>
                        </div>
                    @endif

                    <div class="w-full px-2 ">
                        @foreach($choices as $index => $item)
                            <button class="px-2 py-1 border-2 border-solid border-red-300 rounded" wire:click="deleteChoice({{$index}})">{{$item}}</button>
                        @endforeach
                    </div>

                    <div class="w-full px-2  flex items-center ">
                        <button type="button" wire:click="saveReferenceRange()" @disabled($result_types == "number" && ($range_from == null || $range_to == null))
                                class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">حفظ
                        </button>
                    </div>
                </div>

                <div class="w-full mt-2">
                    <table class="table-fixed w-full">
                        <thead class="bg-cyan-700 text-white">
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
                                    <td class="py-2">{{$types[$range->result_types]}}</td>
                                    <td class="py-2">
                                        @if($range->age_from == null)
                                            {{$ages[$range->age]}}
                                        @else
                                            {{ $range->age_from . " - " . $range->age_to . " " . $ages[$range->age] }}
                                        @endif
                                    </td>
                                    <td class="py-2">
                                        @if($range->result_types == "number")
                                            {{ $range->range_from . " - " . $range->range_to }}
                                        @elseif($range->result_types == "text")
                                        @elseif($range->result_types == "multable_choice" || $range->result_types == "text_and_multable_choice")
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
                                                wire:click="deleteRange({{$range->id}})"><i
                                                class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="flex">
            <div class="p-5 w-1/3 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

                <div class="overflow-auto h-80">
                    <table class="table-fixed w-full">
                        <thead class="bg-cyan-700 text-white">
                        <tr>
                            <th class="py-2 rounded-r-2xl">#</th>
                            <th class="rounded-l-2xl">إسم القسم</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <tr>
                            <td class="py-2 rounded-r-2xl">
                            </td>
                            <td class="py-2 rounded-r-2xl">
                                <input autocomplete="off" type="text" wire:model.live="searchCategoryName"
                                       wire:keydown="searchCategories()"
                                       class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                       placeholder="إسم القسم">
                            </td>
                        </tr>

                        @if(!empty($categories))
                            @foreach($categories as $category)
                                <tr class="border-b-2" wire:click="chooseCategory({{$category}})">
                                    <td class="py-2">{{$category->id}}</td>
                                    <td>{{$category->categoryName}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="w-2/3">
                <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
                    <form class="w-full" wire:submit="saveAnalysis()">
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full md:w-60 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="analysisName">
                                    إسم التحليل
                                </label>
                                <input autocomplete="off" required
                                       @disabled(empty($currentCategory)) wire:model.live="analysisName"
                                       class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                       id="categoryName" type="text" placeholder="إسم التحليل">
                                <span class="text-red-500">@error('analysisName') {{ $message }} @enderror</span>
                            </div>

                            <div class="w-48 px-3 mb-6 md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                       for="shortcut">
                                    الإختصار
                                </label>
                                <input autocomplete="off"
                                       @disabled(empty($currentCategory)) wire:model.live="shortcut"
                                       class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                       id="shortcut" type="text" placeholder="الإختصار">
                                <span class="text-red-500">@error('shortcut') {{ $message }} @enderror</span>
                            </div>

                            <div class=" w-36 px-2  flex items-center ">
                                <button type="submit" @disabled(empty($currentCategory))
                                class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{$id == 0 ? 'حفظ': 'تعديل'}}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
                    <input autocomplete="off" type="text"
                           @if(!empty($currentCategory)) wire:model.live="currentCategory.categoryName" @endif
                           disabled
                           class=" rounded-md w-72 mb-3 text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                           placeholder="إسم القسم">
                    <div class="overflow-auto h-80">
                        <table class="table-fixed w-full">
                            <thead class="bg-cyan-700 text-white">
                            <tr>
                                <th class="py-2 rounded-r-2xl">#</th>
                                <th class="">إسم التحليل</th>
                                <th class="">الاختصار</th>
                                <th class="rounded-l-2xl">التحكم</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            <tr>
                                <td class="py-2 rounded-r-2xl">
                                </td>
                                <td class="py-2 rounded-r-2xl">
                                    <input autocomplete="off" type="text" wire:model.live="searchAnalysisName"
                                           wire:keydown="searchAnalyses()"
                                           class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                           placeholder="إسم التحليل">
                                </td>
                                <td class="py-2 rounded-r-2xl">
                                    <input autocomplete="off" type="text" wire:model.live="searchAnalysisShortcut"
                                           wire:keydown="searchAnalyses()"
                                           class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                           placeholder="إسم الاختصار">
                                </td>
                                <td>
                                </td>
                            </tr>

                            @if(!empty($analyzes))
                                @foreach($analyzes as $analysis)
                                    <tr class="border-b-2">
                                        <td class="py-2">{{$analysis->id}}</td>
                                        <td>{{$analysis->analysisName}}</td>
                                        <td>{{$analysis->shortcut}}</td>
                                        <td>
                                            <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                                    wire:click="editAnalysis({{$analysis}})"><i class="fa fa-pen"></i>
                                            </button>
                                            <button class="bg-red-400 p-2 rounded text-xs text-white"
                                                    wire:click="deleteAnalysis({{$analysis->id}})"><i
                                                    class="fa fa-trash"></i>
                                            </button>
                                            <button class="bg-yellow-400 p-2 rounded text-xs text-white"
                                                    wire:click="chooseAnalysis({{$analysis}})"><i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    @endif

</div>
