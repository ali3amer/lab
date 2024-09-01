<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset("fontawesome-free-6.4.2-web\css\all.min.css")}}">

    @vite('resources/js/app.js')
    <title>{{ $title ?? 'نظام إدارة المعامل' }}</title>
</head>
<body dir="rtl">
<div class="w-full h-screen flex">
    <div class="m-auto w-1/3 border-1 bg-gradient-to-r from-cyan-600 to-cyan-800 px-3 py-24 shadow-2xl shadow-gray-500 rounded-2xl text-black border-red-300">
        <div class="text-center text-white mb-5 font-extrabold">تسجيل الدخول</div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="row mb-3">
                    <label for="username"
                           class="text-white">إسم المستخدم</label>

                    <div class="col-md-6">
                        <input id="username" autocomplete="off" type="text" placeholder="إسم المستخدم" class="w-full font-extrabold outline-0  bg-transparent text-center text-white py-1.5 pr-2 border-b-2 placeholder:text-gray-300 "
                               name="username" value="{{ old('username') }}" required autocomplete="off" autofocus>

                        @error('username')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password"
                           class="text-white">كلمة المرور</label>

                    <div class="col-md-6">
                        <input id="password" placeholder="كلمة المرور" autocomplete="off" type="password"
                               class="w-full font-extrabold text-white bg-transparent text-center  py-1.5 pr-2 border-b-2 border-white outline-0 placeholder:text-gray-300 sm:text-sm sm:leading-6" name="password"
                               required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="w-full font-extrabold bg-transparent border-white border-2 py-2 rounded-2xl text-white">
                            تسجيل الدخول
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
