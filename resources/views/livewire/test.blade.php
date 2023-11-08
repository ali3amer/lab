<div class="">
    <livewire:header :$header/>

    <button class="bg-blue-600 hidden hover:bg-blue-700 px-3 py-1 rounded text-white m-5 show-modal">Show Modal</button>

    <div wire:ignore.self wire:keydown="searchCategory()"
         class="modal w-full h-screen fixed left-0 top-0 flex justify-center items-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded shadow-lg w-1/3">
            <div class="border-b px-4 flex justify-between items-center py-2">
                <h3>Modal Title</h3>
                <button class="text-black close-modal">&cross;</button>
            </div>

            <div class="p-3">
                <input type="text" wire:model.live="categoryName">
                <table>
                    @if(!empty($categories))
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->categoryName }}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
            <div class="flex justify-end item-center w-100 border-t p-3">
                <button class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white ml-1">Ok</button>
                <button class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white close-modal">Cancel</button>
            </div>
        </div>
    </div>

    @if(!empty($currentCategory))
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
            <form class="w-full" wire:submit="saveTest()">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="testName">
                            إسم الفحص
                        </label>
                        <input autocomplete="off" required wire:model="testName"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="testName" type="text" placeholder="إسم الفحص">
                        <span class="text-red-500">@error('testName') {{ $message }} @enderror</span>
                    </div>


                    <div class="w-full md:w-1/5 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for=shortcut">
                            الإختصار
                        </label>
                        <input autocomplete="off" wire:model="shortcut"
                               class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id=shortcut" type="text" placeholder="الإختصار (إختياري)">
                    </div>


                    <div class="w-full md:w-1/5 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for=unit">
                            الوحده
                        </label>
                        <input autocomplete="off" wire:model="unit"
                               class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id=unit" type="text" placeholder="الإختصار (إختياري)">
                    </div>

                    <div class="w-full md:w-1/6 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for=price">
                            السعر
                        </label>
                        <input autocomplete="off" wire:model=price"
                               class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id=price" type="text" placeholder="السعر">
                    </div>


                    <div class="w-full md:w-1/12 px-2  flex items-center ">
                        @if(empty($currentPatient))
                            <button type="submit"
                                    class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{$id == 0 ? 'حفظ': 'تعديل'}}</button>
                        @else
                            <button type="button" wire:click="resetData()"
                                    class=" py-2.5 bg-red-800 hover:bg-red-700 w-full mt-2 rounded text-white"><i
                                    class="fa fa-close"></i></button>

                        @endif
                    </div>
                </div>

            </form>
        </div>

        <div class="px-5 py-1 text-cyan-800 bg-white flex font-extrabold border-2 border-dashed rounded-2xl mx-5">
            <div wire:click="changeLocation(-1)" class="mr-1 text-black cursor-pointer"><i class="fa fa-home"></i></div> /
            @foreach($currentLocation as $index => $location)
                <div wire:click="changeLocation({{$index}})" class="mr-1 text-black cursor-pointer">{{ $location }} </div> {{ !$loop->last ? "/" : '' }}
            @endforeach
        </div>

        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
            <div class="max-h-75 overflow-auto block max-h-96">
                <table class="table-fixed relative max-h-96 w-full overflow-auto">
                    <thead class="bg-cyan-700 text-white sticky top-0 ">
                    <tr>
                        <th class="py-2 rounded-r-2xl">#</th>
                        <th>إسم الفحص</th>
                        <th>الإختصار</th>
                        <th>الوحده</th>
                        <th class="rounded-l-2xl">التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">

                    @foreach($tests as $test)
                        <tr class="border-b-2">
                            <td class="py-2">{{ $test->id }}</td>
                            <td>{{ $test->testName }}</td>
                            <td>{{ $test->shortcut }}</td>
                            <td>{{ $test->unit }}</td>
                            <td>
                                <button class="py-1 px-2 rounded bg-blue-600 text-white" wire:click="chooseTest({{$test->id}})"><i class="fa fa-plus"></i></button>
                                <button class="py-1 px-2 rounded bg-gray-600 text-white" wire:click="editTest({{$test}})"><i class="fa fa-edit"></i></button>
                                <button class="py-1 px-2 rounded bg-red-600 text-white disabled:bg-red-300 disabled:cursor-not-allowed" @disabled($test->children->count() > 0) wire:click="deleteTestMassage({{$test->id}})"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @else
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl m-5">
            <input type="text" value="الأقسام" class="p-2 my-2 border-2 text-center font-extrabold" disabled>
            <div class="max-h-75 overflow-auto block max-h-96">
                <table class="table-fixed relative max-h-96 w-full overflow-auto">
                    <thead class="bg-cyan-700 text-white sticky top-0 ">
                    <tr>
                        <th class="py-2 rounded-r-2xl">#</th>
                        <th class="rounded-l-2xl">إسم القسم</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">

                    @foreach($categories as $category)
                        <tr class="border-b-2 cursor-pointer" wire:click="chooseCategory({{$category}})">
                            <td class="py-2">{{$category->id}}</td>
                            <td>{{$category->categoryName}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>


