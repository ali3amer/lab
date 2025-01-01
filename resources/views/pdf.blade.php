<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>pdf</title>

    <style>
        body {
            font-family: DejaVu Sans, serif;
            direction: rtl;
        }

        .relative {
            position: relative;
        }
        .top-0 {
            top: 0px;
        }
        .mx-5 {
            margin-left: 1.25rem;
            margin-right: 1.25rem;
        }
        .my-1 {
            margin-top: 0.25rem;
            margin-bottom: 0.25rem;
        }
        .mb-1 {
            margin-bottom: 0.25rem;
        }
        .ml-2 {
            margin-left: 0.5rem;
        }
        .mt-2 {
            margin-top: 0.5rem;
        }
        .flex {
            display: flex;
        }
        .table {
            display: table;
        }
        .hidden {
            display: none;
        }
        .w-1\/2 {
            width: 50%;
        }
        .w-1\/4 {
            width: 25%;
        }
        .w-1\/5 {
            width: 20%;
        }
        .w-1\/6 {
            width: 16.666667%;
        }
        .w-3\/5 {
            width: 60%;
        }
        .w-5\/6 {
            width: 83.333333%;
        }
        .w-fit {
            width: fit-content;
        }
        .w-full {
            width: 100%;
        }
        .break-before-page {
            break-before: page;
        }
        .flex-wrap {
            flex-wrap: wrap;
        }
        .items-center {
            align-items: center;
        }
        .rounded-xl {
            border-radius: 0.75rem;
        }
        .border-2 {
            border-width: 2px;
        }
        .border-b {
            border-bottom-width: 1px;
        }
        .border-solid {
            border-style: solid;
        }
        .border-cyan-600 {
            border: 2px solid #0791b2;
        }
        .border-gray-100 {
            border-color: rgb(243 244 246 / var(--tw-border-opacity, 1));
        }
        .border-b-black {
            --tw-border-opacity: 1;
            border-bottom-color: rgb(0 0 0 / var(--tw-border-opacity, 1));
        }
        .bg-gray-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(243 244 246 / var(--tw-bg-opacity, 1));
        }
        .bg-gray-300 {
            --tw-bg-opacity: 1;
            background-color: rgb(209 213 219 / var(--tw-bg-opacity, 1));
        }
        .px-1 {
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }
        .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        .text-left {
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .font-serif {
            font-family: ui-serif, Georgia, Cambria, "Times New Roman", Times, serif;
        }
        .font-extrabold {
            font-weight: 800;
        }
        .font-thin {
            font-weight: 100;
        }
        .text-white {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity, 1));
        }
        .underline {
            text-decoration-line: underline;
        }
        .decoration-double {
            text-decoration-style: double;
        }
        @media print {
            .print\:block {
                display: block;
            }
        }

    </style>



</head>
<body>
<div class="invoice print:block">

    @if(!empty($printResults))
        <div class="body relative">
            @php $count = 0; @endphp
            @php $limit = 30; @endphp

            @foreach($printResults as $key => $items)
                @if($loop->first || $count > $limit || $key == "URINE GENERAL" || $key == "STOOL GENERAL" || $key == "CBC")
                    <div class="header top-0 break-before-page">
                        <div dir="rtl" class="info mx-5 mb-1">
                            <div class="flex items-center border-2 rounded-xl px-1 border-cyan-600"
                                 style="height: 90px;">
                                <div class="w-1/5 rounded-xl">
                                    <img src="{{asset("js/newheader.jpg")}}" style="width: 100%;">
                                </div>
                                <div class="w-3/5 items-center text-center">
                                    <h2 class="result-header">معمل النخبة للتحاليل الطبيه</h2>
                                </div>
                                <div class="w-1/5 rounded-xl">
                                    <img src="{{asset("js/newheader.jpg")}}" style="width: 100%;">
                                </div>
                            </div>

                            <span class="my-1"
                                  style="font-family: 'lateef', sans-serif"> التاريخ : {{ $currentVisit['visit_date'] }} </span>
                            <div class="flex flex-wrap" style="font-family: 'lateef', sans-serif;">

                                <div class="w-1/2 mt-2">
                                    <div class="border-2 border-gray-100 ml-2">
                                        <div class="flex">
                                            <div class="w-1/6 px-2 bg-gray-100">الإسم</div>
                                            <div
                                                class="w-5/6 px-3">{{ $currentPatient["patientName"] }}</div>
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
                                            <div
                                                class="w-5/6 px-3">{{ number_format($currentPatient['age'], 0) }}</div>
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
                    <h2 class="px-2 w-fit underline decoration-double mb-1"
                        style="font-size: 14px">{{ $key }}</h2>
                    @foreach($items as $index => $item)
                        @if(count($items) != 1)
                            <h1 class="px-2 w-fit mb-1" style="font-size: 12px">{{$index}}</h1>
                        @endif
                        <table
                            class="w-full text-center {{ $index != 'MACRO' && $index != 'MICRO' ? 'mb-1' : 'mb-1' }} "
                            style="font-size: 10px">
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
                                    <td class="text-left px-2"
                                        style="font-weight: bold">{{ $result["testName"] }}</td>
                                    <td dir="ltr" style="font-weight: bold; font-size: 10px">
                                        @if($result["result_type"] == "number" || $result["result_type"] == "text")
                                            {{ $result["result"] }}
                                        @else
                                            @if(isset($result["choices"][$result["result_choice"]]))
                                                {{ $result["choices"][$result["result_choice"]]['choiceName'] . " " }}
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
                                            @if (floatval($result["result"]) < floatval($result['numeric_ranges']["min_value"]))
                                                <i class="fa fa-arrow-down"></i>
                                            @elseif(floatval($result["result"]) > floatval($result['numeric_ranges']["max_value"]))
                                                <i class="fa fa-arrow-up"></i>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="font-thin text-right" style="font-size: x-small">
                                        @if($result["result_type"] == "number")
                                            {{ $result['numeric_ranges']["min_value"] . " - " . $result['numeric_ranges']["max_value"] . " " . $result["test"]["unit"] }}
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

</body>
</html>
