<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>pdf</title>

    <style>

        body {
            font-family: DejaVu Sans, serif;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
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
            display: -webkit-box; /* wkhtmltopdf uses this one */
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center; /* wkhtmltopdf uses this one */
            -webkit-justify-content: center;
            justify-content: center;
        }

        .table {
            display: table;
        }

        .hidden {
            display: none;
        }

        .w-half {
            width: 50%;
        }

        .w-quarter {
            width: 25%;
        }

        .w-five {
            width: 20%;
        }

        .w-sixth {
            width: 16.666667%;
        }

        .w-three-five {
            width: 60%;
        }

        .w-five-sixth {
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
            border-bottom-width: 2px;
        }

        .border-solid {
            border-style: solid;
        }

        .border-cyan-600 {
            border: 2px solid #0791b2;
        }

        .border-gray-100 {
            border: 1px solid #F3F4F6;
        }

        .border-b-black {
            border-bottom: 1px solid #000;
        }

        .bg-gray-100 {
            --tw-bg-opacity: 1;
            background-color: #F3F4F6;
        }

        .bg-gray-300 {
            --tw-bg-opacity: 1;
            background-color: #D1D5DB;
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

        .image {
            display: inline-block;
        }

        .head {
            display: inline-block;
        }

        .text-white {
            --tw-text-opacity: 1;
            color: #fff;
        }

        .underline {
            text-decoration-line: underline;
        }

        .decoration-double {
            text-decoration-style: double;
        }

        @page {
            footer: page-footer;
            @top-center {
                content: element(pageHeader);
            }
            @bottom-center {
                margin-bottom: 20px;
            }
        }

        #pageHeader {
            position: running(pageHeader);
        }

        * {
            border: 1px solid red;
        }
    </style>


</head>
<body>

<div class="header top-0 break-before-page">
    <div dir="rtl" class="info mx-5 mb-1">
        <div class="flex items-center border-2 rounded-xl px-1 border-cyan-600"
             style="height: 90px;">
            <div class="w-five image rounded-xl" style="border: 1px solid red">
                <img src="{{asset("js/newheader.jpg")}}" style="width: 90%;">
            </div>
            <div class="w-three-five head items-center text-center" style="border: 1px solid red">
                <h2 class="result-header">معمل النخبة للتحاليل الطبيه</h2>
            </div>
            <div class="w-five image rounded-xl" style="border: 1px solid red">
                <img src="{{asset("js/newheader.jpg")}}" style="width: 90%;">
            </div>
        </div>
        <span class="my-1"
              style="font-family: 'lateef', sans-serif;"> التاريخ : {{ $currentVisit['visit_date'] }} </span>
        <div class="flex flex-wrap" style="font-family: 'lateef', sans-serif;">

            <div class="w-half mt-2">
                <div class="border-2 border-gray-100 ml-2">
                    <div class="flex">
                        <div class="w-sixth px-2 bg-gray-100">الإسم</div>
                        <div
                            class="w-five-sixth px-3">{{ $currentPatient["patientName"] }}</div>
                    </div>
                </div>
            </div>

            <div class="w-half mt-2">
                <div class="border-2 border-gray-100 ml-2">
                    <div class="flex">
                        <div class="w-sixth px-2  bg-gray-100">د/</div>
                        <div class="w-five-sixth px-3">{{ $currentVisit['doctor'] }}</div>
                    </div>
                </div>
            </div>

            <div class="w-half mt-2">
                <div class="border-2 border-gray-100 ml-2">
                    <div class="flex">
                        <div class="w-sixth px-2  bg-gray-100">العمر</div>
                        <div
                            class="w-five-sixth px-3">{{ number_format($currentPatient['age'], 0) }}</div>
                    </div>
                </div>
            </div>

            <div class="w-half mt-2">
                <div class="border-2 border-gray-100 ml-2">
                    <div class="flex">
                        <div class="w-sixth px-2  bg-gray-100">التأمين</div>
                        <div class="w-five-sixth px-3"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="invoice">
    @if(!empty($printResults))
        <div class="body relative">
            @php $count = 0; @endphp
            @php $limit = 30; @endphp

            @foreach($printResults as $key => $items)
                @if($loop->first || $count > $limit || $key == "URINE GENERAL" || $key == "STOOL GENERAL" || $key == "CBC")
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
                                <th class="text-left px-2 w-quarter">Test</th>
                                <th class="w-quarter">Result</th>
                                <th class="w-quarter">N/H</th>
                                <th class="text-right w-quarter">Ref.Range</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($item as $result)
                                @php $count++; @endphp
                                <tr>
                                    <td class="text-left px-2"
                                        style="font-weight: bold; border-bottom: 1px solid gray">{{ $result["testName"] }}</td>
                                    <td dir="ltr" style="font-weight: bold; font-size: 10px; border-bottom: 1px solid gray">
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
                                    <td class="font-extrabold" style="font-weight: bold; border-bottom: 1px solid gray">
                                        @if($result["result_type"] == "number")
                                            @if (floatval($result["result"]) < floatval($result['numeric_ranges']["min_value"]))
                                                <i class="fa fa-arrow-down"></i>
                                            @elseif(floatval($result["result"]) > floatval($result['numeric_ranges']["max_value"]))
                                                <i class="fa fa-arrow-up"></i>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="font-thin text-right" style="font-size: x-small; border-bottom: 1px solid gray">
                                        @if($result["result_type"] == "number")
                                            {{ $result['numeric_ranges']["min_value"] . " - " . $result['numeric_ranges']["max_value"] . " " . $result["test"]["unit"] }}
                                        @elseif($result["result_type"] == "text")
                                            @foreach($result['text_ranges'] as $text)
                                                {{ $text['text']  }} @if(!$loop->last)
                                                    <br/>
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </div>

            @endforeach
        </div>
    @endif
</div>

<htmlpagefooter name="page-footer">
    <div class="footer w-full">
        <div class="flex">
            <div class="w-quarter text-center font-serif" style="float:left;">Dr.Kamal Magalad</div>
            <div class="w-quarter "></div>
            <div class="w-quarter "></div>
            <div class="w-quarter text-center font-serif" style="float:right;">Dr.Sami Hashim</div>
        </div>
    </div>
</htmlpagefooter>

</body>
</html>
