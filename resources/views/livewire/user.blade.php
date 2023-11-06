<div class="">
    <livewire:header :$header/>

<div class="flex">
    <div class="p-5 w-1/3 text-cyan-800 bg-white font-extrabold border-2 border-dashed rounded-2xl m-5">
        <form class="w-full" wire:submit="saveUser()">
            <div class="flex flex-wrap -mx-3">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                        الاسم الكامل
                    </label>
                    <input autocomplete="off" required
                           @disabled(!empty($currentUser)) wire:model.live="name"
                           class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="name" type="text" placeholder="الإسم الكامل">
                    <span class="text-red-500">@error('name') {{ $message }} @enderror</span>
                </div>

                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="username">
                        إسم الدخول
                    </label>
                    <input autocomplete="off" required
                           @disabled(!empty($currentUser)) wire:model.live="username"
                           class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="username" type="text" placeholder="إسم الدخول">
                    <span class="text-red-500">@error('username') {{ $message }} @enderror</span>
                </div>


                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="password">
                        كلمة المرور
                    </label>
                    <input autocomplete="off" required
                           @disabled(!empty($currentUser)) wire:model.live="password"
                           class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                           id="password" type="password" placeholder="كلمة المرور">
                    <span class="text-red-500">@error('password') {{ $message }} @enderror</span>
                </div>
                <div class="w-full px-2  flex items-center ">
                    <button type="submit"
                            class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white">{{$id == 0 ? 'حفظ': 'تعديل'}}</button>
                </div>

                <table class="table-fixed w-full text-center">
                    <thead>
                    <tr>
                        <th>الصلاحية</th>
                        <th>عرض</th>
                        <th>إنشاء</th>
                        <th>تعديل</th>
                        <th>حذف</th>
                    </tr>
                    </thead>
                    @foreach($permissionsList as $permission)
                        <tr class="border-2 border-b-gray-500">
                            <td>{{$permission[1]}}</td>
                            <td><input class="form-check-input" type="checkbox" wire:model="permissions" value="{{$permission[0] . '-read'}}" value="" aria-label="..."></td>
                            <td><input class="form-check-input" type="checkbox" wire:model="permissions" value="{{$permission[0] . '-create'}}" value="" aria-label="..."></td>
                            <td><input class="form-check-input" type="checkbox" wire:model="permissions" value="{{$permission[0] . '-update'}}" value="" aria-label="..."></td>
                            <td><input class="form-check-input" type="checkbox" wire:model="permissions" value="{{$permission[0] . '-delete'}}" value="" aria-label="..."></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </form>
    </div>

    <div class="p-5 text-cyan-800 bg-white w-2/3 font-extrabold border-2 border-dashed rounded-2xl m-5 mx-5">

        <div class="overflow-auto h-80">
            <table class="table-fixed  w-full ">
                <thead class="bg-cyan-700 text-white">
                <tr>
                    <th class="py-2 rounded-r-2xl">#</th>
                    <th>الإسم الكامل</th>
                    <th>إسم الدخول</th>
                    <th class="rounded-l-2xl">التحكم</th>
                </tr>
                </thead>
                <tbody class="text-center">
                <tr>
                    <td class="py-2 rounded-r-2xl">
                    </td>
                    <td class="py-2 rounded-r-2xl">
                        <input autocomplete="off" type="text" wire:model.live="searchUserName"
                               wire:keydown="searchUser()"
                               class=" rounded-md w-full text-center border-0 py-1.5 pr-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                               placeholder="بحث">
                    </td>
                    <th class="rounded-l-2xl"></th>
                </tr>

                @if(!empty($users))
                    @foreach($users as $user)
                        <tr class="border-b-2">
                            <td class="py-2">{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->username}}</td>
                            <td>
                                <button class="bg-cyan-400 p-2 rounded text-xs text-white"
                                        wire:click="editUser({{$user}})"><i class="fa fa-pen"></i></button>
                                <button class="bg-red-400 p-2 rounded text-xs text-white"
                                        wire:click="deleteUser({{$user->id}})"><i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>

    </div>

</div>
</div>
