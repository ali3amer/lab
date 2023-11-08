<div wire:keydown.esc.window="resetData()" class="">

    <livewire:header :$header/>

    <!-- component -->
    <!-- Code block starts -->

{{--    <div class="print:w-full">--}}
{{--        <div wire:ignore.self--}}
{{--             class="print:p-0 py-12 bg-gray-700 print:w-min-full print:block print:m-0 print:bg-white opacity-5 hidden transition duration-150 ease-in-out z-10 absolute top-0 right-0 bottom-0 left-0"--}}
{{--             id="modal">--}}
{{--            <div role="alert" class="container print:w-min-full print:block print:p-0  print:m-0  mx-auto w-11/12">--}}
{{--                <div dir="rtl"--}}
{{--                     class=" invoice relative print:p-0 print:w-min-full print:m-0 py-8 print:block px-5 print:shadow-none print:border-none  md:px-10 bg-white shadow-md rounded border border-gray-400">--}}
{{--                    <div class="h-80 print:h-full print:block print:w-full overflow-auto">--}}
{{--                        @if(!empty($results))--}}
{{--                            @php $count = 0; @endphp--}}
{{--                            @foreach($results as $key => $printAnalyses)--}}
{{--                                @foreach($printAnalyses as $index => $analysis)--}}
{{--                                    <div--}}
{{--                                        class="header  hidden {{ $count == 0 ? "print:block print:break-before-auto" : "" }}  {{ $count >= 10 && count($analysis) > 2 && $index != "URINE GENERAL - Microscopy" ? "print:block print:break-before-page" : '' }} text-center">--}}
{{--                                        <img src="{{ asset('js/header.jpg') }}" style="width: 100%; height: 150px"--}}
{{--                                             alt="">--}}
{{--                                        <div--}}
{{--                                            class="hidden print:block text-right">--}}
{{--                                            @if(!empty($currentVisit))--}}
{{--                                                التاريخ : {{$currentVisit['visit_date']}}--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                        @if(!empty($currentPatient))--}}
{{--                                            <div class="flex flex-wrap text-right border-2 border-black">--}}

{{--                                                <div class="w-1/3 px-2">--}}
{{--                                                    الإسم: {{$currentPatient['patientName']}}--}}
{{--                                                </div>--}}

{{--                                                <div class="w-2/3 px-2">--}}
{{--                                                    العمر: {{$currentPatient['age'] . $durations[$currentPatient['duration']]}}--}}
{{--                                                </div>--}}

{{--                                                <div class="w-1/3 px-2">--}}
{{--                                                    د/ {{$currentVisit['doctor'] ?? ""}}--}}
{{--                                                </div>--}}

{{--                                                <div class="w-2/3 px-2">--}}
{{--                                                    الرقم: {{$currentVisit['id'] ?? ""}}--}}
{{--                                                </div>--}}

{{--                                                @if($insurance_id != null)--}}
{{--                                                    <div class="w-1/2 px-2">--}}
{{--                                                        التأمين: {{ \App\Models\Insurance::where("id", $insurance_id)->first()->insuranceName }}--}}
{{--                                                    </div>--}}
{{--                                                @endif--}}
{{--                                            </div>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}


{{--                                    <div class="body " dir="ltr">--}}
{{--                                        <div--}}
{{--                                            class=" font-extrabold text-left {{ $index == "URINE GENERAL - Microscopy" ? " bg-white" : "" }}">--}}
{{--                                            <span--}}
{{--                                                class="{{ $index == "URINE GENERAL - Microscopy" ? " bg-gray-700 w-25 text-white" : "" }}"> <i--}}
{{--                                                    class="fa fa-square {{$index == "URINE GENERAL - Microscopy" ? "hidden" : ""}}"></i> {{$index == "URINE GENERAL - Microscopy" ? "Microscopy" : $index}}</span>--}}
{{--                                        </div>--}}

{{--                                        <table--}}
{{--                                            class="table-fixed w-full  {{ $index == "URINE GENERAL" ? "" : "border-b-2 border-gray-500" }} ">--}}
{{--                                            <thead class="bg-gray-700 text-white">--}}
{{--                                            <tr class="{{ $index == "URINE GENERAL - Microscopy" ? "hidden" : "" }}">--}}
{{--                                                <th class="py-2 text-xs">Test</th>--}}
{{--                                                <th>Result</th>--}}
{{--                                                <th>N/H</th>--}}
{{--                                                <th>Ref. Range</th>--}}
{{--                                            </tr>--}}
{{--                                            </thead>--}}
{{--                                            <tbody class="text-center">--}}
{{--                                            @foreach($analysis as $subAnalysis)--}}
{{--                                                <tr>--}}
{{--                                                    <td class="font-extrabold py-1 px-2 text-xs text-left">{{ $subAnalysis->subAnalysis->subAnalysisName }}</td>--}}
{{--                                                    <td class="text-xs">{{ $subAnalysis->result . " " . $subAnalysis->result_choice }}</td>--}}
{{--                                                    <td class="font-extrabold text-xs {{ $subAnalysis["N/H"] == "L" || $subAnalysis["N/H"] == "H" ? 'bg-gray-400' : '' }}">{{ $subAnalysis["N/H"] }}</td>--}}
{{--                                                    <td class="text-xs">--}}
{{--                                                        {{$subAnalysis->range . " " . $subAnalysis->subAnalysis->unit }}--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                            @endforeach--}}
{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                    @php $count += count($analysis) @endphp--}}
{{--                                @endforeach--}}

{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    <div class="print:hidden flex items-center justify-start w-full">--}}
{{--                        <button id="print"--}}
{{--                                class="focus:outline-none ml-2 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-8 py-2 text-sm">--}}
{{--                            طباعه--}}
{{--                        </button>--}}
{{--                        <button--}}
{{--                            class="focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-gray-400 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm"--}}
{{--                            onclick="modalHandler()">إلغاء--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    <button--}}
{{--                        class="print:hidden cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600"--}}
{{--                        onclick="modalHandler()" aria-label="close modal" role="button">--}}
{{--                        <i class="fa fa-x"></i>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}
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
                            <button type="button" wire:click="resetData()"
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
                    <table class="table-fixed w-full">
                        <thead class="bg-cyan-700 text-white">
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
                                <select wire:model.live="searchGender" wire:change="search()"
                                        class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-1.5 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="gender">
                                    <option value="choose">---</option>
                                    <option value="male">ذكر</option>
                                    <option value="female">أنثى</option>
                                </select>
                            </td>
                            <td class="py-2 rounded-r-2xl">
                                <input autocomplete="off" type="text" wire:model.live="searchAge"
                                       wire:keydown="search()"
                                       class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                       placeholder="العمر">
                            </td>
                            <td class="py-2 rounded-r-2xl">
                                <select wire:model.live="searchDuration" wire:change="search()"
                                        class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-1.5 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        id="gender">
                                    <option value="choose">---</option>
                                    @foreach($durations as $key => $time)
                                        <option value="{{$key}}">{{$time}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="py-2 rounded-r-2xl">
                                <input autocomplete="off" type="text" wire:model.live="searchPhone"
                                       wire:keydown="search()"
                                       class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                       placeholder="الهاتف">
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
                        <div class="w-1/3 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="visit_date">
                                التاريخ
                            </label>
                            <input autocomplete="off" @disabled(!empty($currentVisit)) required wire:model="visit_date"
                                   class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                                   id="visit_date" type="date" placeholder="تاريخ الزيارة">
                            <span class="text-red-500">@error('visit_date') {{ $message }} @enderror</span>
                        </div>

                        <div class="w-1/3 px-3 mb-6 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="insurance_id">
                                التأمين
                            </label>
                            <select wire:model="insurance_id" @disabled(!empty($currentVisit))
                            class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="insurance_id">
                                <option value={{null}}>لايوجد تأمين</option>
                                @foreach($insurances as $insurance)
                                    <option value="{{$insurance->id}}">{{$insurance->insuranceName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-1/3 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="doctor">
                                الدكتور
                            </label>
                            <input autocomplete="off" @disabled(!empty($currentVisit)) wire:model="doctor"
                                   class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="doctor" type="text" placeholder="الدكتور">
                        </div>

                        <div class="w-1/4 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="amount">
                                المبلغ
                            </label>
                            <input autocomplete="off" disabled wire:model.live="amount"
                                   class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="amount" type="text" placeholder="المبلغ ...">
                        </div>

                        <div class="w-1/4 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="discount">
                                التخفيض
                            </label>
                            <input autocomplete="off" wire:model.live="discount" wire:keydown="calcDiscount()"
                                   class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="discount" type="text" placeholder="التخفيض ...">
                        </div>

                        <div class="w-1/4 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                   for="total_amount">
                                الصافي
                            </label>
                            <input autocomplete="off" disabled wire:model.live="total_amount"
                                   class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="total_amount" type="text" placeholder="الصافي ...">
                        </div>


                        @if(empty($currentVisit))
                            <div class="w-1/4 px-2  flex items-end ">
                                <button type="submit"
                                        class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{$visitId == 0 ? 'حفظ': 'تعديل'}}</button>
                            </div>
                        @else
                            <div class="w-1/4 flex">
                                <div wire:loading.attr="disabled" class="w-1/3 px-2  flex items-end ">
                                    <button type="button" wire:click="saveVisitAnalyses()"
                                            class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">
                                        <i
                                            class="fa fa-save"></i></button>
                                </div>
                                <div class="w-1/3 px-2  flex items-end ">
                                    <button wire:loading.attr="disabled" type="button" wire:click="resetVisitData()"
                                            class=" py-2.5 bg-red-800 hover:bg-red-700 w-full mt-2 rounded text-white">
                                        <i
                                            class="fa fa-close"></i></button>
                                </div>
                                <div class="w-1/3 px-2  flex items-end ">
                                    <button wire:loading.attr="disabled" type="button"

                                            class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white"
                                            onclick="modalHandler(true)"><i
                                            class="fa fa-print"></i></button>
                                </div>
                            </div>
                        @endif

                    </div>

                </form>
            </div>
            @if(empty($currentVisit))
                <div class="p-5 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

                    <div class="overflow-auto h-80">
                        <table class="table-fixed w-full">
                            <thead class="bg-cyan-700 text-white">
                            <tr>
                                <th class="py-2 rounded-r-2xl">#</th>
                                <th>التاريخ</th>
                                <th>الدكتور</th>
                                <th>التأمين</th>
                                <th class="rounded-l-2xl">التحكم</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(!empty($visits))
                                @foreach($visits as $visit)
                                    <tr class="border-b-2">
                                        <td class="py-2">{{$visit->id}}</td>
                                        <td>{{$visit->visit_date}}</td>
                                        <td>{{$visit->doctor}}</td>
                                        <td>{{$visit->insurance_id}}</td>
                                        <td>
                                            <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                                    wire:click="editVisit({{$visit}})"><i class="fa fa-pen"></i>
                                            </button>
                                            {{--                                            <button class="bg-red-400 p-2 rounded text-xs text-white"--}}
                                            {{--                                                    wire:click="deleteVisit({{$visit->id}})"><i class="fa fa-trash"></i>--}}
                                            {{--                                            </button>--}}
                                            <button class="bg-yellow-400 p-2 rounded text-xs text-white"
                                                    wire:click="chooseVisit({{$visit}})"><i class="fa fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            @else
                <div class="flex">
                    <div
                        class="p-5 w-1/3 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

                        @if(!empty($currentCategory))
                            @if(!empty($currentAnalysis))
                                <div class="overflow-auto h-80">
                                    <table class="table-fixed w-full">
                                        <thead class="bg-cyan-700 text-white">
                                        <tr>
                                            <th class="py-2 rounded-r-2xl">إسم الفحص الفرعي</th>
                                            <th class="py-2 rounded-l-2xl">سعر</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        <tr>
                                            <td>
                                                <input autocomplete="off" type="text"
                                                       wire:model.live="searchSubAnalysis"
                                                       wire:keydown="searchSubAnalyses()"
                                                       class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                       placeholder="إسم الفحص الفرعي ...">
                                            </td>
                                            <td wire:click="resetAnalysisData()"><i class="fa fa-backward"></i></td>
                                        </tr>
                                        <tr class="border-b-2 cursor-pointer"
                                            wire:click="addAllAnalysis({{$subAnalyses}})">
                                            <td class="py-2">{{ "all " . $currentAnalysis["analysisName"]}}</td>
                                            <td class="py-2">{{\App\Models\SubAnalysis::where("analysis_id", $currentAnalysis['id'])->sum("price")}}</td>
                                        </tr>
                                        @foreach($subAnalyses as $analysis)
                                            <tr class="border-b-2 cursor-pointer"
                                                wire:click="addSubAnalysis({{$analysis}})">
                                                <td class="py-2">{{$analysis->subAnalysisName}}</td>
                                                <td class="py-2">{{$analysis->price}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="overflow-auto h-80">
                                    <table class="table-fixed w-full">
                                        <thead class="bg-cyan-700 text-white">
                                        <tr>
                                            <th class="py-2 rounded-l-2xl rounded-r-2xl">إسم الفحص</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        <tr>
                                            <td>
                                                <input autocomplete="off" type="text" wire:model.live="searchAnalysis"
                                                       wire:keydown="searchAnalyses()"
                                                       class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                       placeholder="إسم الفحص ...">
                                            </td>
                                            <td wire:click="resetCategoryData()"><i class="fa fa-backward"></i></td>
                                        </tr>
                                        @foreach($analyses as $analysis)
                                            <tr class="border-b-2 cursor-pointer"
                                                wire:click="chooseAnalysis({{$analysis}})">
                                                <td class="py-2">{{$analysis->analysisName}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @else
                            <div class="overflow-auto h-80">
                                <table class="table-fixed w-full">
                                    <thead class="bg-cyan-700 text-white">
                                    <tr>
                                        <th class="py-2 rounded-l-2xl rounded-r-2xl">إسم القسم</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    <tr>
                                        <td>
                                            <input autocomplete="off" type="text" wire:model.live="searchCategory"
                                                   wire:keydown="searchCategories()"
                                                   class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                   placeholder="إسم القسم ...">
                                        </td>
                                    </tr>
                                    @if(!empty($categories))
                                        @foreach($categories as $category)
                                            <tr class="border-b-2 cursor-pointer"
                                                wire:click="chooseCategory({{$category}})">
                                                <td class="py-2">{{$category->categoryName}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>

                    <div
                        class="p-5 w-2/3 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">
                        <select wire:model.live="option"
                                class="block appearance-none w-1/3 mb-2 text-center border border-gray-200 text-gray-700 py-1.5 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                id="result">
                            @foreach($analysesSelectArray as $key => $optionSelected)
                                <option value="{{$key}}">{{$optionSelected}}</option>
                            @endforeach
                        </select>
                        <div class="overflow-auto h-80">
                            <table class="table-fixed w-full">
                                <thead class="bg-cyan-700 text-white">
                                <tr>
                                    <th class="py-2 rounded-r-2xl">الفحص</th>
                                    <th>النتيجه</th>
                                    <th>السعر</th>
                                    <th class="rounded-l-2xl">التحكم</th>
                                </tr>
                                </thead>
                                <tbody class="text-center">
                                @if(!empty($visitAnalyses))
                                    @foreach($visitAnalyses[$option] as $analysis)
                                        <tr class="border-b-2">
                                            <td>{{$analysis["subAnalysisName"]}}</td>
                                            <td class="flex">
                                                @php $result_type = \App\Models\ReferenceRange::where('sub_analysis_id', $analysis['sub_analysis_id'])->first() @endphp
                                                @if(isset($result_type->result_types))
                                                    @if($result_type->result_types == 'number' || $result_type->result_types == 'text')
                                                        <input autocomplete="off" type="text"
                                                               wire:model.live="visitAnalyses.{{$option}}.{{$analysis['id']}}.result"
                                                               class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                               placeholder="النتيجه ...">
                                                    @elseif($result_type->result_types == 'multable_choice')
                                                        <select
                                                            wire:model.live="visitAnalyses.{{$option}}.{{$analysis['id']}}.result_choice"
                                                            class="block appearance-none text-center w-full border border-gray-200 text-gray-700 py-1.5 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                            id="result">
                                                            @foreach($result_type->result_multable_choice as $key => $choice)
                                                                <option value="{{$key}}">{{$choice}}</option>
                                                            @endforeach
                                                        </select>
                                                    @elseif($result_type->result_types == 'text_and_multable_choice')
                                                        <input autocomplete="off" type="text"
                                                               wire:model="visitAnalyses.{{$option}}.{{$analysis['id']}}.result"
                                                               class=" w-1/2 rounded-md text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                               placeholder="النتيجه ...">
                                                        <select
                                                            wire:model.live="visitAnalyses.{{$option}}.{{$analysis['id']}}.result_choice"
                                                            class="block w-1/2 appearance-none text-center border border-gray-200 text-gray-700 py-1.5 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                                            id="result">

                                                            @foreach($result_type->result_multable_choice as $key => $choice)
                                                                <option value="{{$key}}" selected>{{$choice}}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                @else
                                                    <input autocomplete="off" type="text"
                                                           wire:model.live="visitAnalyses.{{$option}}.{{$analysis['id']}}.result"
                                                           class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                           placeholder="النتيجه ...">
                                                @endif
                                            </td>
                                            <td>{{$analysis['price']}}</td>
                                            <td>
                                                <button class="bg-red-400 p-2 rounded text-xs text-white"
                                                        wire:click="deleteAnalysis({{$analysis['sub_analysis_id']}})"><i
                                                        class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            @endif
        @endif
    </div>
</div>
