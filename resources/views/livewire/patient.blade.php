<div wire:keydown.esc.window="resetData()" class="">
    <div wire:loading class="h-screen w-full fixed top-0 right-0 bg-gray-700 opacity-25 z-10 absolute text-center justify-items-center">
        <div class="flex items-center h-screen">
            <div class="w-full">
                <i class="fa-solid fa-circle-notch fa-spin text-red-900 " style="font-size: xxx-large"></i>

            </div>
        </div>
    </div>
    <livewire:header :$header/>

    <!-- component -->
    <!-- Code block starts -->

    <div class="print:w-full">
        <div wire:ignore.self
             class="print:p-0 py-12 bg-gray-700 print:w-min-full print:block print:m-0 print:bg-white opacity-5 hidden transition duration-150 ease-in-out z-10 absolute top-0 right-0 bottom-0 left-0"
             id="modal">
            <div role="alert" class="container print:w-min-full print:block print:p-0  print:m-0  mx-auto w-11/12">
                <div dir="rtl"
                     class=" invoice relative print:p-0 print:w-min-full print:m-0 py-8 print:block px-5 print:shadow-none print:border-none  md:px-10 bg-white shadow-md rounded border border-gray-400">
                    <div class="h-80 print:h-full print:block print:w-full overflow-auto">
                        @if(!empty($results))
                            @php $count = 0; @endphp
                            @foreach($results as $key => $printAnalyses)
                                @foreach($printAnalyses as $index => $analysis)
                                    <div
                                        class="header  hidden {{ $count == 0 ? "print:block print:break-before-auto" : "" }}  {{ $count >= 10 && count($analysis) > 2 && $index != "URINE GENERAL - Microscopy" ? "print:block print:break-before-page" : '' }} text-center">
                                        <img src="{{ asset('js/header.jpg') }}" style="width: 100%; height: 150px"
                                             alt="">
                                        <div
                                            class="hidden print:block text-right">
                                            @if(!empty($currentVisit))
                                                التاريخ : {{$currentVisit['visit_date']}}
                                            @endif
                                        </div>
                                        @if(!empty($currentPatient))
                                            <div class="flex flex-wrap text-right border-2 border-black">

                                                <div class="w-1/3 px-2">
                                                    الإسم: {{$currentPatient['patientName']}}
                                                </div>

                                                <div class="w-2/3 px-2">
                                                    العمر: {{$currentPatient['age'] . $durations[$currentPatient['duration']]}}
                                                </div>

                                                <div class="w-1/3 px-2">
                                                    د/ {{$currentVisit['doctor'] ?? ""}}
                                                </div>

                                                <div class="w-2/3 px-2">
                                                    الرقم: {{$currentVisit['id'] ?? ""}}
                                                </div>

                                                @if($insurance_id != null)
                                                    <div class="w-1/2 px-2">
                                                        التأمين: {{ \App\Models\Insurance::where("id", $insurance_id)->first()->insuranceName }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>


                                    <div class="body " dir="ltr">
                                        <div
                                            class=" font-extrabold text-left {{ $index == "URINE GENERAL - Microscopy" ? " bg-white" : "" }}">
                                            <span
                                                class="{{ $index == "URINE GENERAL - Microscopy" ? " bg-gray-700 w-25 text-white" : "" }}"> <i
                                                    class="fa fa-square {{$index == "URINE GENERAL - Microscopy" ? "hidden" : ""}}"></i> {{$index == "URINE GENERAL - Microscopy" ? "Microscopy" : $index}}</span>
                                        </div>

                                        <table
                                            class="table-fixed w-full  {{ $index == "URINE GENERAL" ? "" : "border-b-2 border-gray-500" }} ">
                                            <thead class="bg-gray-700 text-white">
                                            <tr class="{{ $index == "URINE GENERAL - Microscopy" ? "hidden" : "" }}">
                                                <th class="py-2 text-xs">Test</th>
                                                <th>Result</th>
                                                <th>N/H</th>
                                                <th>Ref. Range</th>
                                            </tr>
                                            </thead>
                                            <tbody class="text-center">
                                            @foreach($analysis as $subAnalysis)
                                                <tr>
                                                    <td class="font-extrabold py-1 px-2 text-xs text-left">{{ $subAnalysis->subAnalysis->subAnalysisName }}</td>
                                                    <td class="text-xs">{{ $subAnalysis->result . " " . $subAnalysis->result_choice }}</td>
                                                    <td class="font-extrabold text-xs {{ $subAnalysis["N/H"] == "L" || $subAnalysis["N/H"] == "H" ? 'bg-gray-400' : '' }}">{{ $subAnalysis["N/H"] }}</td>
                                                    <td class="text-xs">
                                                        {{$subAnalysis->range . " " . $subAnalysis->subAnalysis->unit }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @php $count += count($analysis) @endphp
                                @endforeach

                            @endforeach
                        @endif
                    </div>
                    <div class="print:hidden flex items-center justify-start w-full">
                        <button id="print"
                                class="focus:outline-none ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-8 py-2 text-sm">
                            طباعه
                        </button>
                        <button
                            class="focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-gray-400 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm"
                            onclick="modalHandler()">إلغاء
                        </button>
                    </div>
                    <button
                        class="print:hidden cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600"
                        onclick="modalHandler()" aria-label="close modal" role="button">
                        <i class="fa fa-x"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>
    <!--
    <div class="w-full flex justify-center py-12" id="button">
        <button
            class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 mx-auto transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-4 sm:px-8 py-2 text-xs sm:text-sm"
            onclick="modalHandler(true)">Open Modal
        </button>
    </div>

-->
    <!-- Code block ends -->

    <div class="print:hidden">
        <div class="p-5 text-cyan-800 bg-white font-extrabold max-w-full border-2 border-dashed rounded-2xl my-2 mx-5">
            <form class="w-full" wire:submit="save()">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="patientName">
                            إسم المريض
                        </label>
                        <input autocomplete="off" required @disabled(!empty($currentPatient)) wire:model="patientName"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="patientName" type="text" placeholder="إسم المريض">
                        <span class="text-red-500">@error('patientName') {{ $message }} @enderror</span>
                    </div>

                    <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="gender">
                            النوع
                        </label>
                        <select wire:model="gender"
                                @disabled(!empty($currentPatient)) class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="gender">
                            <option value="male">ذكر</option>
                            <option value="female">أنثى</option>
                        </select>

                    </div>

                    <div class="w-full md:w-1/6 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="age">
                            العمر
                        </label>
                        <input autocomplete="off" wire:model="age"
                               @disabled(!empty($currentPatient)) class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="age" type="text" placeholder="العمر">
                    </div>

                    <div class="w-full md:w-1/6 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="gender">
                            الفتره
                        </label>
                        <select wire:model="duration"
                                @disabled(!empty($currentPatient)) class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="gender">
                            @foreach($durations as $key => $time)
                                <option value="{{$key}}">{{$time}}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="w-full md:w-1/6 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="phone">
                            الهاتف
                        </label>
                        <input autocomplete="off" wire:model="phone"
                               @disabled(!empty($currentPatient)) class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="phone" type="text" placeholder="الهاتف">
                    </div>

                    <div class="w-full md:w-1/12 px-2  flex items-center ">
                        @if(empty($currentPatient))
                            <button type="submit"
                                    class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{$id == 0 ? 'حفظ': 'تعديل'}}</button>
                        @else
                            <button type="button" wire:click="resetPatientData()"
                                    class=" py-2.5 bg-red-800 hover:bg-red-700 w-full mt-2 rounded text-white"><i
                                    class="fa fa-close"></i></button>

                        @endif
                    </div>
                </div>

            </form>
        </div>

        @if(empty($currentPatient))
            <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

                <div class="overflow-auto h-80">
                    <table class="table-fixed relative max-h-96 w-full overflow-auto">
                        <thead class="bg-cyan-700 text-white sticky top-0 ">
                        <tr>
                            <th class="py-2 rounded-r-2xl">#</th>
                            <th>إسم المريض</th>
                            <th>النوع</th>
                            <th>العمر</th>
                            <th>الفتره</th>
                            <th>الهاتف</th>
                            <th class="rounded-l-2xl">التحكم</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <tr>
                            <td class="py-2 rounded-r-2xl">
                            </td>
                            <td class="py-2 rounded-r-2xl">
                                <input autocomplete="off" type="text" wire:model.live="searchName"
                                       wire:keydown="search()"
                                       class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                       placeholder="إسم المريض">
                            </td>
                            <td class="py-2 rounded-r-2xl">
                            </td>
                            <td class="py-2 rounded-r-2xl">
                            </td>
                            <td class="py-2 rounded-r-2xl">
                            </td>
                            <td class="py-2 rounded-r-2xl">
                            </td>
                            <th class="rounded-l-2xl"></th>
                        </tr>

                        @foreach($patients as $patient)
                            <tr class="border-b-2">
                                <td class="py-2">{{$patient->id}}</td>
                                <td>{{$patient->patientName}}</td>
                                <td>{{$patient->gender == 'male' ? 'ذكر' : 'أنثى'}}</td>
                                <td>{{$patient->age}}</td>
                                <td>{{$durations[$patient->duration]}}</td>
                                <td>{{$patient->phone}}</td>
                                <td>
                                    <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                            wire:click="edit({{$patient}})">
                                        <i class="fa fa-pen"></i></button>
                                    <button class="bg-red-400 p-2 rounded text-xs text-white"
                                            wire:click="deletePatientMessage({{$patient->id}})"><i
                                            class="fa fa-trash"></i></button>
                                    <button class="bg-yellow-400 p-2 rounded text-xs text-white"
                                            wire:click="choosePatient({{$patient}})"><i class="fa fa-eye"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        @else

            <div
                class="p-5 text-cyan-800 bg-white font-extrabold max-w-full border-2 border-dashed rounded-2xl my-2 mx-5">
                <form class="w-full" wire:submit="saveVisit()">
                    <div class="flex flex-wrap -mx-3">
                        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="visitId">
                                رقم زيارة المريض
                            </label>
                            <input autocomplete="off" disabled wire:model="visitId"
                                   class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                   id="visitId" type="text">
                            <span class="text-red-500">@error('visitId') {{ $message }} @enderror</span>
                        </div>

                        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="visit_date">
                                تاريخ الزيارة
                            </label>
                            <input autocomplete="off" required wire:model="visit_date"
                                   class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                   id="patientName" type="date">
                            <span class="text-red-500">@error('patientName') {{ $message }} @enderror</span>
                        </div>

                        <div class="w-full md:w-1/4 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="doctor">
                                الدكتور
                            </label>
                            <input autocomplete="off" wire:model="doctor"
                                   class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="doctor" type="text" placeholder="الدكتور">
                        </div>

                        <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="gender">
                                التأمين
                            </label>
                            <select wire:model="insurance_id"
                                    class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="insurance_id">
                                <option>--------------</option>
                                @foreach($insurances as $insurance)
                                    <option value="{{$insurance->id}}">{{$insurance->insuranceName}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="w-full md:w-1/4 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="amount">
                                الجمله
                            </label>
                            <input autocomplete="off" wire:model.live="amount" disabled
                                   class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="amount" type="text" placeholder="الجمله">
                        </div>

                        <div class="w-full md:w-1/4 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="discount">
                                التخفيض
                            </label>
                            <input wire:keydown="calcDiscount()" autocomplete="off" wire:model.live="discount"
                                   class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="discount" type="text" placeholder="التخفيض">
                        </div>

                        <div class="w-full md:w-1/4 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="total_amount">
                                الصافي
                            </label>
                            <input autocomplete="off" wire:model="total_amount" disabled
                                   class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="total_amount" type="text" placeholder="الصافي">
                        </div>

                        <div class="w-full md:w-1/4 px-2  flex items-end ">
                            @if(empty($currentVisit))
                                <button type="submit"
                                        class=" py-2.5 px-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">
                                    حفظ
                                </button>
                            @else
                                <button type="button" wire:click="resetVisitData()"
                                        class=" py-2.5 bg-red-800 hover:bg-red-700 w-full mt-2 rounded text-white"><i
                                        class="fa fa-close"></i></button>

                            @endif
                        </div>
                    </div>

                </form>
            </div>

            @if(empty($currentVisit))
                <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

                    <div class="overflow-auto h-80">
                        <table class="table-fixed relative max-h-96 w-full overflow-auto">
                            <thead class="bg-cyan-700 text-white sticky top-0 ">
                            <tr>
                                <th class="py-2 rounded-r-2xl">#</th>
                                <th>تاريخ الزيارة</th>
                                <th>الدكتور</th>
                                <th>التأمين</th>
                                <th>نسبة التحمل</th>
                                <th>المبلغ</th>
                                <th>التخفيض</th>
                                <th>الصافي</th>
                                <th class="rounded-l-2xl">التحكم</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">

                            @foreach($visits as $visit)
                                <tr class="border-b-2">
                                    <td class="py-2">{{$visit->id}}</td>
                                    <td>{{$visit->visit_date}}</td>
                                    <td>{{$visit->doctor}}</td>
                                    <td>{{$visit->insurance_id ? $visit->insurance->insuranceName : ""}}</td>
                                    <td>  {{$visit->patientEndurance}} %</td>
                                    <td>{{number_format($visit->amount, 2)}}</td>
                                    <td>{{number_format($visit->discount, 2)}}</td>
                                    <td>{{number_format($visit->total_amount * ($visit->patientEndurance / 100), 2)}}</td>
                                    <td>
                                        <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                                wire:click="editVisit({{$visit}})">
                                            <i class="fa fa-pen"></i></button>
                                        <button class="bg-red-400 p-2 rounded text-xs text-white"
                                                wire:click="deleteVisitMessage({{$visit->id}})"><i
                                                class="fa fa-trash"></i></button>
                                        <button class="bg-yellow-400 p-2 rounded text-xs text-white"
                                                wire:click="chooseVisit({{$visit}})"><i class="fa fa-eye"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            @else
                <div class="flex">
                    <div class="p-5 w-2/3 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
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
                                        <tr class="border-b-2 cursor-pointer" wire:click="chooseCategory({{$category}})">
                                            <td class="py-2">{{$category->categoryName}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class=" py-1 text-cyan-800 bg-gray-300 flex font-extrabold rounded mb-2">
                                <div wire:click="changeLocation(-1)" class="mr-1 text-black cursor-pointer"><i class="fa fa-home"></i>
                                </div>
                                @foreach($currentLocation as $index => $location)
                                    {{ $loop->first ? "/" : '' }} <div wire:click="changeLocation({{$index}})"
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
                                        <tr class="border-b-2 cursor-pointer"  wire:click="addTest({{$test}})" >
                                            <td class="py-2">{{$test->testName}}</td>
                                            <td class="py-2">{{$test->price}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    <div class="p-5 w-1/3 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
                            @foreach($cart as $key => $item)
                                <button wire:loading.attr="disabled" wire:click="deleteFromCart({{$key}})" class="py-1 hover:bg-red-500 hover:text-white hover:border-none transition-all px-2.5 rounded border-2 border-cyan-600 text-cyan-800">{{$item}}</button>
                            @endforeach
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
