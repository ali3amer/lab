<div class="flex">
    <div
        class="p-5 w-1/2 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

        <form wire:submit="save()">
            <div class="flex flex-wrap">
                <div class="w-full px-3 ">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="text">
                        النص
                    </label>
                    <input autocomplete="off"
                           wire:model="text"
                           class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="text" type="text" placeholder="النص">
                    <span class="text-red-500">@error('النص') {{ $message }} @enderror</span>
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
                    <th class="py-2 rounded-r-2xl">النص</th>
                    <th class="rounded-l-2xl">التحكم</th>
                </tr>
                </thead>
                <tbody>
                @foreach($texts as $text)
                    <tr class="border-b-2 text-center">
                        <td class="py-2">{{$text->text}}</td>
                        <td class="py-2">
                            <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                    wire:click="edit({{$text}})"><i
                                    class="fa fa-pen"></i>
                            </button>
                            <button class="bg-red-400 p-2 rounded text-xs text-white"
                                    wire:click="deleteMassage({{$text->id}})"><i
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
