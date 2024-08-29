<div>
    <div wire:loading class="h-screen w-full fixed top-0 right-0 bg-gray-700 opacity-25 z-10 absolute text-center justify-items-center">
        <div class="flex items-center h-screen">
            <div class="w-full">
                <i class="fa-solid fa-circle-notch fa-spin text-red-900 " style="font-size: xxx-large"></i>

            </div>
        </div>
    </div>
    <livewire:header :$header/>
    @if(empty($currentVisit))
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
            <input type="text" placeholder="بحث ..." wire:model.live="patientSearch" wire:keydown="search()"
                   class="p-2 my-2 border-2 text-center font-extrabold">
            <div class="overflow-auto block max-h-96">
                <table class="table-fixed relative max-h-96 w-full overflow-auto">
                    <thead class="bg-cyan-700 text-white sticky top-0 ">
                    <tr>
                        <th class=" rounded-r-2xl py-2">رقم الزيارة</th>
                        <th class=" py-2">إسم المريض</th>
                        <th class=" rounded-l-2xl py-2">المبلغ</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($visits as $visit)
                        <tr class="border-b-2 cursor-pointer" wire:click="chooseVisit({{$visit}})">
                            <td class="py-2">{{$visit->id}}</td>
                            <td class="py-2">{{$visit->patient->patientName ?? ""}}</td>
                            <td class="py-2">{{number_format($visit->amount, 2)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

            <input type="text" wire:model.live="currentPatient.patientName" disabled class="p-2 my-2 border-2 text-center font-extrabold">

            <button wire:click="save(true)" class="py-1.5 px-2.5 bg-cyan-700 text-white rounded"><i
                        class="fa fa-save"></i></button>
            <button id="printInvoiceResult" @click="$('.invoice').printThis()"
                    class="py-1.5 px-2.5 bg-cyan-700 text-white rounded"><i class="fa fa-print"></i></button>
            <button id="resetData" wire:click="resetData()"
                    class="py-1.5 px-2.5 bg-red-700 text-white rounded"><i class="fa fa-close"></i></button>
            <div class="invoice hidden print:block">
                @if(!empty($printResults))
                    <div class="body relative">
                        @php $count = 0; @endphp
                        @php $limit = 30; @endphp

                        @foreach($printResults as $key => $items)

                            @if($loop->first || $count > $limit || $key == "URINE GENERAL" || $key == "STOOL GENERAL" || $key == "CBC")
                                <div class="header top-0 break-before-page">
                                    <div dir="rtl" class="info mx-5 mb-1">
                                        <div class="flex items-center border-2 rounded-xl px-1 border-cyan-600" style="height: 90px;">
                                            <div class="w-1/5 rounded-xl">
                                                <img src="{{asset("js/newheader.jpg")}}" style="width: 100%;">
                                            </div>
                                            <div class="w-3/5 items-center text-center">
                                                <h2  class="result-header">معمل النخبة للتحاليل الطبيه</h2>
                                            </div>
                                            <div class="w-1/5 rounded-xl">
                                                <img src="{{asset("js/newheader.jpg")}}" style="width: 100%;">
                                            </div>
                                        </div>

                                        <span class="my-1" style="font-family: 'lateef', sans-serif"> التاريخ : {{ date("Y/m/d") }} </span>
                                        <div class="flex flex-wrap"  style="font-family: 'lateef', sans-serif;">

                                            <div class="w-1/2 mt-2">
                                                <div class="border-2 border-gray-100 ml-2">
                                                    <div class="flex">
                                                        <div class="w-1/6 px-2 bg-gray-100">الإسم</div>
                                                        <div class="w-5/6 px-3">{{ $currentPatient["patientName"] }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="w-1/2 mt-2">
                                                <div class="border-2 border-gray-100 ml-2">
                                                    <div class="flex">
                                                        <div class="w-1/6 px-2  bg-gray-100">د/</div>
                                                        <div class="w-5/6 px-3">{{ $currentVisit['doctor'] }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="w-1/2 mt-2">
                                                <div class="border-2 border-gray-100 ml-2">
                                                    <div class="flex">
                                                        <div class="w-1/6 px-2  bg-gray-100">العمر</div>
                                                        <div class="w-5/6 px-3">{{ number_format($currentPatient['age'], 0) }}</div>
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
                                @php $count = 1; @endphp
                            @endif
                            <div class="mx-5">
                                <h2 class="px-2 w-fit underline decoration-double mb-1" style="font-size: 14px">{{ $key }}</h2>
                                @foreach($items as $index => $item)
                                    @if(count($items) != 1)
                                        <h1 class="px-2 w-fit mb-1" style="font-size: 12px">{{$index}}</h1>
                                    @endif
                                    <table class="w-full text-center {{ $index != 'MACRO' && $index != 'MICRO' ? 'mb-1' : 'mb-1' }} " style="font-size: 10px">
                                        <thead>
                                        <tr class="bg-gray-300 text-white font-extrabold">
                                            <th class="text-left px-2 w-1/4">Test</th>
                                            <th class="w-1/4">Result</th>
                                            <th class="w-1/4">N/H</th>
                                            <th class="text-right w-1/4">Ref.Range</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($item as $result)
                                            @php $count++; @endphp
                                            <tr class="border-b border-b-1 border-b-black border-solid">
                                                <td class="text-left px-2" style="font-weight: bold">{{ $result["testName"] }}</td>
                                                <td dir="ltr"  style="font-weight: bold; font-size: 10px">
                                                    @if($result["result_type"] == "number" || $result["result_type"] == "text")
                                                        {{ $result["result"] }}
                                                    @else
                                                        @if(isset($result["choices"][$result["result_choice"]]))
                                                            {{ $result["choices"][$result["result_choice"]]["choiceName"] . " " }}
                                                        @endif
                                                        @if(isset($nestedChoices[$result["id"]]))
                                                            @foreach ($nestedChoices[$result["id"]] as $choice)
                                                                {{ $choice . " " }}
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="font-extrabold" style="font-weight: bold">
                                                    @if($result["result_type"] == "number")
                                                        @if (floatval($result["result"]) < $result["min_value"])
                                                            <i class="fa fa-arrow-down"></i>
                                                        @elseif(floatval($result["result"]) > $result["max_value"])
                                                            <i class="fa fa-arrow-up"></i>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="font-thin text-right" style="font-size: x-small">
                                                    @if($result["result_type"] == "number")
                                                        {{ $result["min_value"] . " - " . $result["max_value"] . " " . $result["test"]["unit"] }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endforeach
                            </div>
                            <div class="footer w-full">
                                <div class="flex">
                                    <div class="w-1/4 text-center font-serif">Dr.Kamal Magalad</div>
                                    <div class="w-1/4 "></div>
                                    <div class="w-1/4 "></div>
                                    <div class="w-1/4 text-center font-serif">Dr.Sami Hashim</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="flex">
            <div class="p-5 w-1/3 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
                <div class="overflow-auto block max-h-96">
                    <table class="table-fixed relative max-h-96 w-full overflow-auto">
                        <thead class="bg-cyan-700 text-white sticky top-0 ">
                        <tr>
                            <th class=" rounded-r-2xl rounded-l-2xl py-2">إسم الفحص</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <tr class="border-b-2 cursor-pointer">
                        @foreach($visitTests as $visitTest)
                            <tr class="cursor-pointer" wire:click="changeOption({{$visitTest->test}})">
                                <td>{{ $visitTest->test->testName }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-2/3">
                <div class=" flex flex-wrap">
                    @if($option != "")
                        @foreach($cart as $cartIndex => $items)
                            @foreach($items as $key => $item)
                                <div
                                        class="p-5 {{ $option != $cartIndex ? 'hidden' : '' }} w-full text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
                                    <h1>{{$item}}</h1>
                                    <div class="overflow-auto block max-h-96">
                                        <table class="table-fixed relative max-h-96 w-full overflow-auto">
                                            <thead class="bg-cyan-700 text-white sticky top-0 ">
                                            <tr>
                                                <th class=" rounded-r-2xl py-2">إسم الفحص</th>
                                                <th class=" rounded-l-2xl py-2">النتيجه</th>
                                            </tr>
                                            </thead>
                                            <tbody class="text-center">
                                            <tr class="border-b-2 cursor-pointer">
                                            @foreach($results as $index => $result)
                                                @if($result['visit_test_id'] == $key)
                                                    <tr>
                                                        <td>{{ $result['testName'] }}</td>
                                                        <td>
                                                            @if($result["result_type"] == "number" || $result["result_type"] == "text")
                                                                <input autocomplete="off"
                                                                       wire:model="results.{{$index}}.result"
                                                                       class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                                       id="result" type="text" placeholder="النتيجة">
                                                            @else
                                                                <div class="flex">
                                                                    <div class="w-1/2">
                                                                        <div wire:click="getParentChoice({{$index}})">
                                                                            @if (!empty($nestedChoices[$index]))
                                                                                @foreach ($nestedChoices[$index] as $choice)
                                                                                    {{ $choice . " " }}
                                                                                @endforeach
                                                                            @endif
                                                                        </div>

                                                                    </div>

                                                                    <div class="w-1/2">
                                                                        <select wire:change="chooseChoice({{$index}})"
                                                                                wire:model="results.{{ $index }}.result_choice"
                                                                                class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                                                id="result_choice">
                                                                            @foreach ($result["choices"] as $choice)
                                                                                <option @selected($choice["default"])
                                                                                        value="{{$choice["id"]}}">{{$choice["choiceName"]}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    @endif


</div>
