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
                        <th class=" rounded-l-2xl py-2">السعر <i @click="$('.invoice').printThis()"
                                                                 class="fa fa-print cursor-pointer"></i></th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @php $total = 0 @endphp
                    @foreach($visitTests as  $visitTest)
                        @php $total += floatval($visitTest->price) @endphp
                        <tr class="border-b-2 cursor-pointer" wire:click="deleteMessage({{$visitTest->id}})">
                            <td class="py-2">{{$visitTest->test->testName}}</td>
                            <td class="py-2">{{number_format($visitTest->price, 2)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot class="bg-cyan-700 text-white sticky top-0 ">
                    <tr>
                        <th class=" rounded-r-2xl py-2">الجمله</th>
                        <th class=" rounded-l-2xl py-2">{{ number_format($total, 2) }}</th>
                    </tr>
                    </tfoot>
                </table>

            </div>

            <div class="invoice hidden print:block">

                <div class="body relative">
                    <div class="header top-0">
                        <div dir="rtl" class="info mx-5 mb-1">
                            <div class="flex items-center border-2 rounded-xl px-1 border-cyan-600"
                                 style="height: 90px;">
                                <div class="w-1/5 rounded-xl">
                                    <img src="{{asset("js/newheader.jpg")}}" style="width: 100%;">
                                </div>
                                <div class="w-3/5 items-center text-center">
                                    <h2 class="result-header">{{$setting->name}}</h2>
                                </div>
                                <div class="w-1/5 rounded-xl">
                                    <img src="{{asset("js/newheader.jpg")}}" style="width: 100%;">
                                </div>
                            </div>

                            <span class="my-1"
                                  style="font-family: 'lateef', sans-serif"> التاريخ : {{ $visit['visit_date'] }} </span>
                            <div class="flex flex-wrap" style="font-family: 'lateef', sans-serif;">

                                <div class="w-1/2 mt-2">
                                    <div class="border-2 border-gray-100 ml-2">
                                        <div class="flex">
                                            <div class="w-1/6 px-2 bg-gray-100">الإسم</div>
                                            <div
                                                class="w-5/6 px-3">{{ $visit->patient->patientName }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-1/2 mt-2">
                                    <div class="border-2 border-gray-100 ml-2">
                                        <div class="flex">
                                            <div class="w-1/6 px-2  bg-gray-100">د/</div>
                                            <div class="w-5/6 px-3">{{ $visit['doctor'] }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-1/2 mt-2">
                                    <div class="border-2 border-gray-100 ml-2">
                                        <div class="flex">
                                            <div class="w-1/6 px-2  bg-gray-100">العمر</div>
                                            <div
                                                class="w-5/6 px-3">{{ number_format($visit->patient->age, 0) }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-1/2 mt-2">
                                    <div class="border-2 border-gray-100 ml-2">
                                        <div class="flex">
                                            <div class="w-1/6 px-2  bg-gray-100">التأمين</div>
                                            <div class="w-5/6 px-3"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="mx-5">
                        <table style="direction: rtl"  class="table-fixed relative mt-3 max-h-96 w-full overflow-auto">
                            <thead class="bg-cyan-700 text-white sticky top-0 ">
                            <tr>
                                <th class="py-2">إسم الفحص</th>
                                <th class="py-2">السعر</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @php $total = 0 @endphp
                            @foreach($visitTests as  $visitTest)
                                @php $total += floatval($visitTest->price) @endphp
                                <tr class="border-b-2 cursor-pointer" wire:click="deleteMessage({{$visitTest->id}})">
                                    <td class="py-2">{{$visitTest->test->testName}}</td>
                                    <td class="py-2">{{number_format($visitTest->price, 2)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot class="bg-cyan-700 text-white sticky top-0 ">
                            <tr>
                                <th class="py-2">الجمله</th>
                                <th class="py-2">{{ number_format($total, 2) }}</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="footer w-full">
                        <div class="flex">
                            <div class="w-1/4 text-center font-serif">{{$setting->first_name}}</div>
                            <div class="w-1/4 "></div>
                            <div class="w-1/4 "></div>
                            <div class="w-1/4 text-center font-serif">{{$setting->second_name}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
