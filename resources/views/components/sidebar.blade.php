<div class="w-[25%] h-screen">
    <div class="bg-[#52D3D8] w-full h-full rounded-tr-2xl rounded-br-2xl shadow-md">
        <span id="header" class="flex justify-center items-center">
            <div class="bg-[#3887BE] my-5 px-10 shadow-sm rounded-md">
                <p class="m-2 font-semibold text-[#F3F8FF]">{{ Auth::user()->role->name }}</p>
            </div>
        </span>
    </div>
</div>