<div wire:keydown.esc.window="resetData()" class="">

    <livewire:header :$header/>

    <!-- component -->
    <!-- Code block starts -->
    <!--
    <div class="">
        <div wire:ignore.self
             class="py-12 bg-gray-700 opacity-5 hidden transition duration-150 ease-in-out z-10 absolute top-0 right-0 bottom-0 left-0"
             id="modal">
            <div role="alert" class="container mx-auto w-11/12 md:w-2/3 max-w-lg">
                <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
                    <h1 class="text-gray-800 font-lg font-bold tracking-normal leading-tight mb-4">Enter Billing
                        Details</h1>
                    <label for="name" class="text-gray-800 text-sm font-bold leading-tight tracking-normal">Owner
                        Name</label>
                    <input id="name" wire:model.live="patientName"
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

-->
    <!-- Code block ends -->

    <div class="p-5 text-cyan-800 bg-white font-extrabold max-w-full border-2 border-dashed rounded-2xl my-2 mx-5">
        <form class="w-full" wire:submit="save()">
            <div class="flex flex-wrap -mx-3">
                <div class="w-full md:w-1/4 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="patientName">
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
                            <input autocomplete="off" type="text" wire:model.live="searchName" wire:keydown="search()"
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
                            <input autocomplete="off" type="text" wire:model.live="searchAge" wire:keydown="search()"
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
                            <input autocomplete="off" type="text" wire:model.live="searchPhone" wire:keydown="search()"
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
                                        wire:click="delete({{$patient->id}})"><i class="fa fa-trash"></i></button>
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

        <div class="p-5 text-cyan-800 bg-white font-extrabold max-w-full border-2 border-dashed rounded-2xl my-2 mx-5">
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
                            @foreach($insurances as $insurance)
                                <option value="{{$insurance->id}}">{{$insurance->insuranceName}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="doctor">
                            الدكتور
                        </label>
                        <input autocomplete="off" @disabled(!empty($currentVisit)) wire:model="doctor"
                               class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="doctor" type="text" placeholder="الدكتور">
                    </div>

                    <div class="w-1/4 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="amount">
                            المبلغ
                        </label>
                        <input autocomplete="off" disabled wire:model="amount"
                               class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="amount" type="text" placeholder="المبلغ ...">
                    </div>

                    <div class="w-1/4 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="discount">
                            التخفيض
                        </label>
                        <input autocomplete="off" wire:model="discount"
                               class="appearance-none text-center block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                               id="discount" type="text" placeholder="التخفيض ...">
                    </div>

                    <div class="w-1/4 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="total_amount">
                            الصافي
                        </label>
                        <input autocomplete="off" disabled wire:model="total_amount"
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
                            <div class="w-1/2 px-2  flex items-end ">
                                <button type="button" wire:click="saveVisitAnalyses()"
                                        class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white"><i
                                        class="fa fa-save"></i></button>
                            </div>
                            <div class="w-1/2 px-2  flex items-end ">
                                <button type="button" wire:click="resetVisitData()"
                                        class=" py-2.5 bg-red-800 hover:bg-red-700 w-full mt-2 rounded text-white"><i
                                        class="fa fa-close"></i></button>
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
                                                wire:click="editVisit({{$visit}})"><i class="fa fa-pen"></i></button>
                                        <button class="bg-red-400 p-2 rounded text-xs text-white"
                                                wire:click="deleteVisit({{$visit->id}})"><i class="fa fa-trash"></i>
                                        </button>
                                        <button class="bg-yellow-400 p-2 rounded text-xs text-white"
                                                wire:click="chooseVisit({{$visit}})"><i class="fa fa-eye"></i></button>
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

                    <div class="overflow-auto h-80">
                        <table class="table-fixed w-full">
                            <thead class="bg-cyan-700 text-white">
                            <tr>
                                <th class="py-2 rounded-r-2xl rounded-l-2xl">إسم الفحص</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            <tr>
                                <td>
                                    <input autocomplete="off" type="text" wire:model.live="searchAnalysis" wire:keydown="searchAnalyses()"
                                           class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                           placeholder="إسم الفحص ...">
                                </td>
                            </tr>
                            @foreach($subAnalyses as $analysis)
                                @if(!key_exists($analysis->id, $visitAnalyses))
                                    <tr class="border-b-2 cursor-pointer" wire:click="addAnalysis({{$analysis}})">
                                        <td class="py-2">{{$analysis->subAnalysisName}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

                <div
                    class="p-5 w-2/3 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

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

                            @foreach($visitAnalyses as $analysis)
                                <tr class="border-b-2">
                                    <td>{{$analysis['subAnalysisName']}}</td>
                                    <td>
                                        <input autocomplete="off" type="text" wire:model.live="visitAnalyses.{{$analysis['id']}}.result"
                                               class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                               placeholder="النتيجه ...">
                                    </td>
                                    <td>{{$analysis['price']}}</td>
                                    <td>
                                        <button class="bg-red-400 p-2 rounded text-xs text-white"
                                                wire:click="deleteAnalysis({{$analysis['id']}})"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        @endif

    @endif
</div>
