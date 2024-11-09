@if($result_type == "number")
    <div class="w-1/6 px-3 ">
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

    <div class="w-1/6 px-3 ">
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
@elseif($result_type == "text")
    <div class="w-full px-3 ">
        <label
            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
            for="text">
            النص
        </label>
        <input autocomplete="off"
               wire:model="text"
               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
               id="text" type="text" placeholder="النص">
        <span class="text-red-500">@error('text') {{ $message }} @enderror</span>
    </div>
    {{--                            @elseif($result_type == "multiple_choice" || $result_type == "text_and_multiple_choice")--}}
    {{--                                <div class="w-full px-2  flex items-center ">--}}
    {{--                                    <button type="submit" @disabled($choicesMode)--}}
    {{--                                    class=" disabled:bg-cyan-400 disabled:cursor-not-allowed py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{ $range_id == 0 ? "إضافة خيارات" : "تعديل الخيارات" }}--}}
    {{--                                    </button>--}}
    {{--                                </div>--}}
@endif
