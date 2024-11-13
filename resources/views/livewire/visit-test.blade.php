<div>
    @if($user->hasPermission("visits-create"))
        <div class="flex">
            <div
                class="p-5 w-1/2 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
                @if(empty($currentCategory))
                    <div class="overflow-auto block max-h-96">
                        <table class="table-fixed relative max-h-96 w-full overflow-auto">
                            <thead class="bg-cyan-700 text-white sticky top-0 ">
                            <tr>
                                <th class=" rounded-l-2xl rounded-r-2xl py-2">إسم القسم</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">

                            @foreach($categories as $category)
                                <tr class="border-b-2 cursor-pointer"
                                    wire:click="chooseCategory({{$category}})">
                                    <td class="py-2">{{$category->categoryName}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class=" py-1 text-cyan-800 bg-gray-300 flex font-extrabold rounded mb-2">
                        <div wire:click="changeLocation(-1)" class="mr-1 text-black cursor-pointer"><i
                                class="fa fa-home"></i>
                        </div>
                        @foreach($currentLocation as $index => $location)
                            {{ $loop->first ? "/" : '' }}
                            <div wire:click="changeLocation({{$index}})"
                                 class="mr-1 text-black cursor-pointer">{{ $location }} </div> {{ !$loop->last ? "/" : '' }}
                        @endforeach
                    </div>
                    <div class="overflow-auto block max-h-96">
                        <table class="table-fixed relative max-h-96 w-full overflow-auto">
                            <thead class="bg-cyan-700 text-white sticky top-0 ">
                            <tr>
                                <th class=" rounded-r-2xl py-2">إسم الفحص</th>
                                <th class=" rounded-l-2xl py-2">السعر</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @foreach($tests as $test)
                                <tr class="border-b-2 cursor-pointer" wire:click="addTest({{$test}})">
                                    <td class="py-2">{{$test->testName}}</td>
                                    <td class="py-2">{{number_format($test->price, 2)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div
                class="p-5 w-1/2 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

                <table class="table-fixed relative max-h-96 w-full overflow-auto">
                    <thead class="bg-cyan-700 text-white sticky top-0 ">
                    <tr>
                        <th class=" rounded-r-2xl py-2">إسم الفحص</th>
                        <th class=" rounded-l-2xl py-2">السعر</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @php $total = 0 @endphp
                    @foreach($cart as $key => $item)
                        @if(isset($item['price']))
                            @php $total += floatval($item['price']) @endphp
                        @endif
                        <tr class="border-b-2 cursor-pointer" wire:click="deleteFromCart({{$key}})">
                            <td class="py-2">{{$item['testName']}}</td>
                            <td class="py-2">{{number_format($item['price'], 2)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="bg-cyan-700 text-white sticky top-0 ">
                    <tr>
                        <th class=" rounded-r-2xl py-2">التخفيض</th>
                        <th class=" rounded-l-2xl py-2">
                            <input autocomplete="off" type="text" wire:model.live="discount"
                                   class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                   placeholder="التخفيض">
                        </th>
                    </tr>
                    <tr>
                        <th class=" rounded-r-2xl py-2">الجمله</th>
                        <th class=" rounded-l-2xl py-2">{{ number_format($total - $discount, 2) }}</th>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    @endif
</div>
