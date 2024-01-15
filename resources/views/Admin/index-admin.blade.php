<x-app-layout>
    <div class="min-h-screen">

        <div class="min-h-screen">
            {{-- navbar --}}
            <header class="flex justify-between py-2 px-5 h-[11svh] bg-amber-500 drop-shadow-md">
                <div class="flex items-center gap-2">
                    <span class="p-2 bg-white drop-shadow-md rounded-full">
                        icon
                    </span>
                    <p class="font-semibold">Admin Dashboard</p>
                </div>
                <div class="flex gap-4 items-center">
                    <span class="font-semibold">
                        {{ Auth::user()->name }}
                    </span>
                    <button class="btn btn-error">Logout</button>
                </div>
            </header>
            <div class="w-full flex gap-4 h-[87svh] mt-2">
                {{-- sidebar --}}
                <div class="w-1/5 flex h-auto flex-col px-5 rounded-r-lg bg-slate-300/50">
                    <p class="p-2 bg-white rounded-lg my-4 font-bold">Menu Admin</p>
                    <ul class="menu">
                        {{-- menu A --}}
                        <li>
                            <button class="menu-btn" data-menu="menuA">menu a</button>
                                <ul id="menuA" style="display: none;">
                                    <li id="subMenuA1" data-submenu="Aku Sub Menu A ke 1"><button>Submenu 1</button></li>
                                    <li id="subMenuA2" data-submenu="Aku Sub Menu A ke 2"><button>Submenu 2</button></li>
                                </ul>
                        </li>
                        {{-- menu B --}}
                        <li>
                            <button class="menu-btn" data-menu="menuB">menu b</button>
                                <ul id="menuB" style="display: none;">
                                    <li><a>Submenu 1</a></li>
                                    <li><a>Submenu 2</a></li>
                                </ul>
                        </li>
                        {{-- menu C --}}
                        <li>
                            <button class="menu-btn" data-menu="menuC">menu c</button>
                                <ul id="menuC" style="display: none;">
                                    <li><a>Submenu 1</a></li>
                                    <li><a>Submenu 2</a></li>
                                </ul>
                        </li>
                        
                    </ul>
                    
                </div>
                {{-- menu --}}
                <div class="w-4/5 mr-5 bg-slate-300/50 p-4 rounded-md ">
                    <div id="menuContainer" class="bg-white rounded-lg h-full p-4">
                        <p>Aku Menu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            // menu menu
            var subMenu = false;
            $('.menu-btn').click(function(){
                var menuId = $(this).data('menu');
                $('#' + menuId).slideToggle('fast');
            });
            $('#subMenuA1, #subMenuA2').click(function() {
                $('#menuContainer').text($(this).data('submenu'));
            })
           
        })
    </script>
</x-app-layout>