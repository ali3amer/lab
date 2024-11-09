<div
    class="modal w-full h-screen fixed left-0 z-10 top-0 flex justify-center bg-black bg-opacity-75">
    <div class="bg-gray-100 relative mt-14 h-96 rounded z-20 shadow-lg w-2/3">
        <div class="border-b px-4 flex justify-between items-center py-2">
            <h2>{{ $currentTest["testName"] ?? ""}}</h2>
            <button class="text-black close-modal" wire:click="closeModal('rangeModal')">&cross;</button>
        </div>

        <div class="w-full px-3">
            <div class="flex flex-wrap my-1 bg-white rounded-2xl -mx-3">
                <div class="w-full md:w-1/3 px-3 py-1">
                    <input
                        autocomplete="off"
                        wire:model.live="choiceName"
                        class="appearance-none text-center block w-full text-gray-700 border rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                        id="main-choice"
                        type="text"
                        placeholder="أدخل واضغط Enter"
                    >
                </div>

                <div class="w-full mt-2 md:w-1/12 px-2">
                    <button type="button" wire:click="addChoice"
                            class="bg-cyan-800 hover:bg-cyan-700 w-full py-2 rounded text-white"><i
                            class="fa fa-plus"></i></button>
                </div>
            </div>
        </div>

        <div class="flex justify-end item-center w-100 border-t absolute w-full bottom-0 p-3">
            <button class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white ml-1">حفظ</button>
            <button class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white close-modal">إلغاء</button>
        </div>
    </div>
</div>
