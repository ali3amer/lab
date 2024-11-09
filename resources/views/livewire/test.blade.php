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

    @if(!empty($currentCategory))
        @if($user->hasPermission("tests-create") || $user->hasPermission("tests-update"))
            <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
                <form class="w-full" wire:submit="saveTest()">
                    <div class="flex flex-wrap -mx-3">
                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="testName">
                                إسم الفحص
                            </label>
                            <input autocomplete="off" required wire:model="testName" @disabled($ageGenderGroupMode)
                            class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                   id="testName" type="text" placeholder="إسم الفحص">
                            <span class="text-red-500">@error('testName') {{ $message }} @enderror</span>
                        </div>


                        <div class="w-full md:w-1/6 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for=shortcut">
                                الإختصار
                            </label>
                            <input autocomplete="off" wire:model="shortcut" @disabled($ageGenderGroupMode)
                            class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id=shortcut" type="text" placeholder="الإختصار (إختياري)">
                        </div>

                        <div class="w-full md:w-1/6 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for=unit">
                                الوحده
                            </label>
                            <input autocomplete="off" wire:model="unit" @disabled($ageGenderGroupMode)
                            class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id=unit" type="text" placeholder="الإختصار (إختياري)">
                        </div>

                        <div class="w-full md:w-1/6 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="price">
                                السعر
                            </label>
                            <input autocomplete="off" wire:model="price" @disabled($ageGenderGroupMode)
                            class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="price" type="text" placeholder="السعر">
                        </div>

                        <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="gender">
                                الرينج
                            </label>
                            <select wire:model.live="result_type" @disabled($ageGenderGroupMode)
                            class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="insurance_id">
                                <option value="">--------------</option>
                                <option value="number">رقمي</option>
                                <option value="text">نص</option>
                                <option value="multiple_choice">خيارات</option>
                                <option value="text_and_multiple_choice">نص وخيارات</option>
                            </select>

                        </div>

                        <div class="w-1/12 px-3 flex items-center">
                            <input checked id="getAll" wire:model="getAll" @disabled($ageGenderGroupMode) type="checkbox"
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="getAll"
                                   class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                إضافة الكل</label>
                        </div>

                        <div class="w-full md:w-1/12 px-2  flex items-center ">
                            @if(!$ageGenderGroupMode)
                                <button type="submit"
                                        class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white" @disabled($result_type == "")>{{$id == 0 ? 'حفظ': 'تعديل'}}</button>
                            @else
                                <button type="button" wire:click="resetTestData()"
                                        class=" py-2.5 bg-red-800 hover:bg-red-700 w-full mt-2 rounded text-white"><i
                                        class="fa fa-close"></i></button>

                            @endif
                        </div>
                    </div>

                </form>
            </div>
        @endif
        @if(!$ageGenderGroupMode)
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
                            <th>الرينج</th>
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
                                <td>{{ $types[$test->result_type] }}</td>
                                <td>{{ $test->getAll ? "نعم" : "لا" }}</td>
                                <td>
                                    @if($user->hasPermission("tests-create"))
                                        <button class="py-1 px-2 rounded bg-blue-600 text-white"
                                                wire:click="chooseTest({{$test->id}})"><i class="fa fa-plus fa-xs"></i>
                                        </button>
                                    @endif
                                    @if($user->hasPermission("tests-update"))
                                        <button class="py-1 px-2 rounded bg-gray-600 text-white"
                                                wire:click="editTest({{$test}})"><i class="fa fa-edit fa-xs"></i></button>
                                    @endif
                                    @if($user->hasPermission("tests-delete"))
                                        <button
                                            class="py-1 px-2 rounded bg-red-600 text-white disabled:bg-red-300 disabled:cursor-not-allowed"
                                            @disabled($test->children->count() > 0) wire:click="deleteTestMassage({{$test->id}})">
                                            <i class="fa fa-trash fa-xs"></i></button>
                                    @endif
                                    @if($user->hasPermission("tests-create"))
                                        <button
                                            @disabled($test->children->count() > 0) wire:click="editTest({{$test}}, {{true}})"
                                            class="py-1 px-2 rounded bg-blue-600 text-white show-modal disabled:bg-blue-300 disabled:cursor-not-allowed" @disabled($test->children->count() > 0)>
                                            <i class="fa fa-arrow-right-arrow-left fa-xs"></i>
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
            <livewire:age-gender-group :$test_id :$result_type />
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


