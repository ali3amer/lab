<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @livewireStyles
{{--    <link rel="stylesheet" href="{{asset('icons/icons.css')}}">--}}
    <link rel="stylesheet" href="{{asset("fontawesome-free-6.4.2-web\css\all.min.css")}}">
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">--}}
    @vite('resources/css/app.css')
    <title>{{ $title ?? 'Page Title' }}</title>
</head>
<body dir="rtl">

<div class="relative flex min-h-screen bg-gray-100">
    <livewire:navbar/>
    <div class="flex-1">
        {{ $slot }}
    </div>
</div>

<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/printThis.js')}}"></script>
<script src="{{asset('js/scripts.js')}}"></script>
<script>
    let modal = document.getElementById("modal");

    function modalHandler(val) {
        if (val) {
            fadeIn(modal);
        } else {
            fadeOut(modal);
        }
    }

    function fadeOut(el) {
        el.style.opacity = 1;
        (function fade() {
            if ((el.style.opacity -= 0.1) < 0) {
                el.style.display = "none";
            } else {
                requestAnimationFrame(fade);
            }
        })();
    }

    function fadeIn(el, display) {
        el.style.opacity = 0;
        el.style.display = display || "flex";
        (function fade() {
            let val = parseFloat(el.style.opacity);
            if (!((val += 0.2) > 1)) {
                el.style.opacity = val;
                requestAnimationFrame(fade);
            }
        })();
    }
</script>

@livewireScripts
<script src="{{asset('js/sweetalert2.js')}}"></script>
<x-livewire-alert::scripts />
{{--<script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>--}}
<x-livewire-alert::flash />
</body>
</html>
