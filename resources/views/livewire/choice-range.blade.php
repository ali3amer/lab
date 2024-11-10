<div>
    <div class="px-5 py-1 text-cyan-800 bg-white flex font-extrabold border-2 border-dashed rounded-2xl mx-5">
        <div wire:click="changeLocation(-1)" class="mr-1 text-black cursor-pointer"><i class="fa fa-home"></i>
        </div>
        /
        @foreach($currentLocation as $index => $location)
            <div wire:click="changeLocation({{$index}})"
                 class="mr-1 text-black cursor-pointer">{{ $location }} </div> {{ !$loop->last ? "/" : '' }}
        @endforeach
    </div>

    <div class="flex">
        <div
            class="p-5 w-1/2 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
            <form wire:submit="save()">
                <div class="flex flex-wrap">
                    <div class="w-full px-3 ">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="choiceName">
                            الخيار
                        </label>
                        <input autocomplete="off"
                               wire:model="choiceName"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="choiceName" type="text" placeholder="الخيار">
                        <span class="text-red-500">@error('choiceName') {{ $message }} @enderror</span>
                    </div>

                    <div class="w-1/12 px-3 flex items-center">
                        <input checked id="default" wire:model="default"  type="checkbox"
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default"
                               class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            إفتراضي</label>
                    </div>

                    <div class="w-full flex px-3 items-center">
                        <button type="submit"
                                class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{ $id == 0 ? "حفظ" : "تعديل" }}
                        </button>

                    </div>
                </div>
            </form>

        </div>

        <div
            class="p-5 w-1/2 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

            <div class="w-full block max-h-96 overflow-auto mt-2">
                <table class="table-fixed relative max-h-96 w-full overflow-auto">
                    <thead class="bg-cyan-700 text-white sticky top-0">
                    <tr>
                        <th class="py-2 rounded-r-2xl">الإختيار</th>
                        <th>إفتراضي</th>
                        <th class="rounded-l-2xl">التحكم</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($choiceRanges as $choiceRange)
                        <tr class="border-b-2 text-center">
                            <td class="py-2">{{$choiceRange->choiceName}}</td>
                            <td class="py-2">{{$choiceRange->default ? "نعم" : "لا"}}</td>
                            <td class="py-2">
                                <button class="bg-blue-600 p-2 rounded text-xs text-white"
                                        wire:click="chooseRange({{$choiceRange->id}})"><i
                                        class="fa fa-plus"></i>
                                </button>

                                <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                        wire:click="edit({{$choiceRange}})"><i
                                        class="fa fa-pen"></i>
                                </button>

                                <button class="bg-red-400 p-2 rounded text-xs text-white"
                                        wire:click="deleteMassage({{$choiceRange->id}})"><i
                                        class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
