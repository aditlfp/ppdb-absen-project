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
                    <button class="btn btn-error" id="logout">Logout</button>
                </div>
            </header>
            <div class="w-full flex gap-4 h-[87svh] mt-2">
                {{-- sidebar --}}
                <div class="w-1/5 flex h-auto flex-col px-5 rounded-r-lg bg-slate-300/50">
                    <p class="p-2 bg-white rounded-lg my-4 font-bold">Menu Admin</p>
                    <ul class="menu gap-y-2">

                        {{-- Dashboard --}}
                        <li>
                            <button class="menu-btn active" id="menuDash" data-menu="menuDashboard" data-submenu="Dashboard">Dashboard</button>
                        </li>
                        {{-- menu A --}}
                        <li>
                            <button class="menu-btn" data-menu="menuA">Master Data</button>
                                <ul id="menuA" style="display: none;">
                                    <li id="subMenuA1" data-submenu="Aku Sub Menu A ke 1" onclick="userIndex()" class="mt-1"><button>Data User</button></li>
                                    <li id="subMenuA2" data-submenu="Aku Sub Menu A ke 2" onclick="siswaIndex()" class="my-1"><button>Data Siswa</button></li>
                                    <li id="subMenuA3" data-submenu="Aku Sub Menu A ke 2" onclick="jurusanIndex()"><button>Data Jurusan</button></li>
                                </ul>
                        </li>
                        {{-- menu B --}}
                        <li>
                            <button class="menu-btn" data-menu="menuB">Sub Data</button>
                                <ul id="menuB" style="display: none;">
                                    <li class="my-1"><button>Data Absen</button></li>
                                </ul>
                        </li>
                        {{-- menu C --}}
                        
                    </ul>
                    
                </div>
                {{-- menu --}}
                <div class="w-4/5 mr-5 bg-slate-300/50 p-4 rounded-md ">
                    <div id="menuContainer" class="bg-white rounded-lg h-full p-4">
                        <p id="def">Dashboard</p>
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
            $('#menuDash').click(function() {
                $('#menuContainer').text($(this).data('submenu'));
            })

            $('#logout').click(function() {
                logout();
            })
        })

        function userIndex() 
        {
            $.ajax({
                url: '/admin/user-data',
                method: 'GET',
                success: function (response, data)
                {
                    $('#def').hide()
                    $('#menuContainer').html(response);
                    $('#menuDash').removeClass('active');
                    $('#subMenuA1').addClass('active');
                }
            })
        }

        function siswaIndex() {

            $.ajax({
                url: '/admin/siswa-data',
                method: 'GET',
                success: function (response) {
                    $('#def').hide();
                    $('#menuContainer').html(response);
                    $('#menuDash').removeClass('active');
                    $('#subMenuA2').addClass('active');
                },
            });
        }

        function jurusanIndex()
        {
            $.ajax({
                url: '/admin/jurusan-data',
                method: 'GET',
                success: function(response) {
                    $('#def').hide();
                    $('#menuContainer').html(response);
                    $('#menuDash').removeClass('active');
                    $('#subMenuA3').addClass('active');
                }
            })
        }

        function logout()
        {
            $.ajax({
                url: `{{ route('logout') }}`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    toastr.info('Success Logout');
                    setTimeout(function() {
                        window.location.href('login');
                    }, 2000);
                }
            })
        }
    </script>
</x-app-layout>