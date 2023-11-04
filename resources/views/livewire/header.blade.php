<div class="bg-white shadow py-4 font-extrabold flex text-cyan-800 px-3">
    <button class="inline-block mx-6" id="sideBarBtn">
        <i class="fa fa-bars"></i>
    </button>
    <span class="mx-6 text-3xl">{{$header}}</span>

    <div class="w-2/3 mx-6 text-3xl">{{ auth()->user()->name ?? "" }}</div>

    <div class="justify-self-end bg-red-500 hover:bg-red-400 text-white w-25 py-2 px-3 rounded-xl items-end">
        <a class="dropdown-item" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
            <i class="fa fa-door-open"></i>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>

</div>
