<div class="">
    <livewire:header :$header/>

    <!-- component -->
    <!-- Code block starts -->
    <div wire:igonre class="">
        <div
            class="py-12 bg-gray-700 opacity-5 hidden transition duration-150 ease-in-out z-10 absolute top-0 right-0 bottom-0 left-0"
            id="modal">
            <div role="alert" class="container mx-auto w-11/12 md:w-2/3 max-w-lg">
                <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
                    <h1 class="text-gray-800 font-lg font-bold tracking-normal leading-tight mb-4">Enter Billing
                        Details</h1>
                    <label for="name" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Owner
                        Name</label>
                    <input id="name"
                           class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 text-center rounded border"
                           placeholder="James"/>
                    <label for="email2" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Card
                        Number</label>
                    <div class="relative mb-5 mt-2">
                        <input id="email2"
                               class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-16 text-sm border-gray-300 text-center rounded border"
                               placeholder="XXXX - XXXX - XXXX - XXXX"/>
                    </div>
                    <label for="expiry" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Expiry
                        Date</label>
                    <div class="relative mb-5 mt-2">
                        <input id="expiry"
                               class="text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 text-center rounded border"
                               placeholder="MM/YY"/>
                    </div>
                    <label for="cvc" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">CVC</label>
                    <div class="relative mb-5 mt-2">
                        <input id="cvc"
                               class="mb-8 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 text-center rounded border"
                               placeholder="MM/YY"/>
                    </div>
                    <div class="flex items-center justify-start w-full">
                        <button
                            class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-8 py-2 text-sm">
                            Submit
                        </button>
                        <button
                            class="focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-gray-400 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm"
                            onclick="modalHandler()">Cancel
                        </button>
                    </div>
                    <button
                        class="cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600"
                        onclick="modalHandler()" aria-label="close modal" role="button">
                        <i class="fa fa-x"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>
    <div class="w-full flex justify-center py-12" id="button">
        <button
            class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 mx-auto transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm"
            onclick="modalHandler(true)">Open Modal
        </button>
    </div>

    <!-- Code block ends -->
    <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl m-5">
        <form class="w-full" wire:submit="saveCategory()">
            <div class="flex flex-wrap -mx-3">
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="patientName">
                        إسم القسم
                    </label>
                    <input autocomplete="off" required
                           @disabled(!empty($currentCategory)) wire:model.live="categoryName"
                           class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="categoryName" type="text" placeholder="إسم القسم">
                    <span class="text-red-500">@error('categoryName') {{ $message }} @enderror</span>
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
                    <th>إسم القسم</th>
                    <th class="rounded-l-2xl">التحكم</th>
                </tr>
                </thead>
                <tbody class="text-center">
                <tr>
                    <td class="py-2 rounded-r-2xl">
                    </td>
                    <td class="py-2 rounded-r-2xl">
                        <input autocomplete="off" type="text" wire:model.live="searchCategoryName"
                               wire:keydown="searchCategory()"
                               class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                               placeholder="إسم القسم">
                    </td>
                    <th class="rounded-l-2xl"></th>
                </tr>

                @if(!empty($categories))
                    @foreach($categories as $category)
                        <tr class="border-b-2">
                            <td class="py-2">{{$category->id}}</td>
                            <td>{{$category->categoryName}}</td>
                            <td>
                                <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                        wire:click="editCategory({{$category}})"><i class="fa fa-pen"></i></button>
                                <button class="bg-red-400 p-2 rounded text-xs text-white"
                                        wire:click="deleteCategory({{$category->id}})"><i class="fa fa-trash"></i>
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
