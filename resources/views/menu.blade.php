<x-app-layout>
<div class=" flex flex-col w-full min-h-screen justify-center items-center p-3 pb-16 bg-slate-300/50">
<div id="load"></div>
	<div id="content" class="w-full bg-sky-500 flex flex-col justify-center items-center rounded-lg shadow-sm" >
		@if(Auth::user()->role_id != 3)
			<div class="my-10">
				<span class="text-lg font-semibold uppercase">Menu</span>
			</div>

			<div onclick="menuSiswa()" class="my-2 btn bg-amber-500 border-0 w-[90%]">
				<span>Daftar Siswa Baru</span>
			</div>

			<div class="my-2 btn bg-amber-500 border-0 w-[90%]" onclick="dataAbsensi()">
				<span>Info Absensi</span>
			</div>

			<!-- Cek Role 1 atau 2 dan tampilkan menu -->
			@if(Auth::user()->role_id == 1)
				<div class="my-2 btn bg-amber-500 border-0 w-[90%]" onclick="absen()">
					<span>Absensi</span>
				</div>

			@elseif(Auth::user()->role_id == 2)
				<div class="my-2 btn bg-amber-500 border-0 w-[90%]" onclick="adminPanel()">
					<span>Admin Panel</span>
				</div>
			@endif
			<span class="text-xs italic text-sky-700 mb-5">Creted By <a href="https://github.com/aditlfp" target="_blank">@aditlfp</a></span>
		@endif

				
		</div>
		 {{-- @if(Auth::user()->role_id != 2)
			<div class="flex w-full"><button onclick="back()" class="btn bg-red-500 btn-sm">Back</button></div>
		@endif  --}}
	</div>


	<script type="text/javascript">
		var originalContent = $('#content').html();
		var user = {{ Auth::user()->role_id}};

		$(document).ready(function() {
			back()

			user == 3 ? siswa() : ""

			// api/siswa/data-siswa-absen
			// siswa_absensi
		})

		function siswa()
		{
			$('#load').append('<span class="loading loading-bars loading-lg"></span>')
			$.ajax({
				url: '{{ route("siswa_absensi") }}',
				method: 'GET',
				success: function(res){
					$('#load').hide()
					$('#content').show()
					$('#content').html(res)
				}
			})
		}
		
		function back()
		{
			$('#content').html(originalContent);
		}
		
		function adminPanel()
		{
			$.ajax({
				url: 'admin/admin-panel',
				method: 'GET',
				success: function(res)
				{
					window.location.href = 'admin/admin-panel'
				}
			})
		}
		
		function menuSiswa()
		{
			$.ajax({
				url: 'teacher/siswa-new',
				method: 'GET',
				success: function(res)
				{
					$('#content').html(res)
				}
			})
		}

		function absen()
		{
			$.ajax({
				url: 'dashboard',
				method: 'GET',
				success: function(res)
				{
					$('#content').html(res)
				}
			})
		}

		function dataAbsensi()
		{
			$.ajax({
				url: 'teacher/absensi-siswa',
				method: 'GET',
				success: function(res)
				{
					$('#content').html(res)
				}
			})
		}


	</script>

</x-app-layout>
   		

	
