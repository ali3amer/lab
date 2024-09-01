<div class="">
    <livewire:header :$header/>
    @if( $user->hasPermission("categories-create") || $user->hasPermission("categories-update"))
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl m-5">
            <form class="w-full" wire:submit="saveCategory()">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="patientName">
                            إسم القسم
                        </label>
                        <input autocomplete="off" required
                               @disabled(!empty($currentCategory)) wire:model.live="categoryName"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="categoryName" type="text" placeholder="إسم القسم">
                        <span class="text-red-500">@error('categoryName') {{ $message }} @enderror</span>
                    </div>

                    <div class="w-full md:w-1/6 px-2  flex items-center ">
                        @if($user->hasPermission("categories-create") || $user->hasPermission("categories-update"))
                            <button type="submit"
                                    class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{$id == 0 ? 'حفظ': 'تعديل'}}</button>
                        @endif

                    </div>
                </div>
            </form>
        </div>
    @endif

    @if( $user->hasPermission("categories-read"))
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
                                    @if($user->hasPermission("categories-update"))
                                    <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                            wire:click="editCategory({{$category}})"><i class="fa fa-pen"></i></button>
                                    @endif
                                        @if($user->hasPermission("categories-delete"))
                                        <button class="bg-red-400 p-2 rounded text-xs text-white"
                                            wire:click="deleteMessage({{$category->id}})"><i class="fa fa-trash"></i>
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
