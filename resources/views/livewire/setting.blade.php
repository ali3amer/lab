<div class="grid-cen">
    <livewire:header :$header/>

    <div class="content-end">
        <div
            class="p-5 w-1/2 text-cyan-800 self-center bg-white font-extrabold border-2 border-dashed rounded-2xl my-2 mx-5">

            <form wire:submit="save()">
                <div class="flex flex-wrap">
                    <div class="w-full px-3 ">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="name">
                            إسم المختبر
                        </label>
                        <input autocomplete="off"
                               wire:model="name"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="name" type="text" placeholder="إسم المختبر">
                    </div>

                    <div class="w-full px-3 ">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="first_name">
                            إسم الطبيب الاول
                        </label>
                        <input autocomplete="off"
                               wire:model="first_name"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="first_name" type="text" placeholder="إسم الطبيب الاول">
                    </div>

                    <div class="w-full px-3 ">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="second_name">
                            إسم الطبيب الثاني
                        </label>
                        <input autocomplete="off"
                               wire:model="second_name"
                               class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                               id="second_name" type="text" placeholder="إسم الطبيب الثاني">
                    </div>

                    <div class="w-full flex px-3 items-center">
                        <button type="submit"
                                class=" py-2.5 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white" @disabled($name == null || $name == "") @disabled($first_name == null || $first_name == "") @disabled($second_name == null || $second_name == "") >حفظ</button>

                    </div>

                    <div class="w-full flex px-3 items-center">
                        <button wire:loading.attr="disabled" type="button" wire:click="collectFromAnotherDatabase"
                                class=" py-2.5 disabled:bg-cyan-200 bg-cyan-800 hover:bg-cyan-700 w-full mt-2 rounded text-white" @disabled($name == null || $name == "") @disabled($first_name == null || $first_name == "") @disabled($second_name == null || $second_name == "") >سحب بيانات</button>

                    </div>
                </div>
            </form>

        </div>
    </div>


</div>
