<x-app-layout>
<div class="flex flex-col w-full h-screen justify-center items-center px-10 bg-slate-300/50">
	<div  id="content"  class="sm:w-[40%] w-full bg-sky-500 flex flex-col justify-center items-center rounded-lg shadow-sm">
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
		</div>
		<!-- @if(Auth::user()->role_id != 2)
			<div class="flex w-full"><button onclick="back()" class="btn bg-red-500 w-full">Back</button></div>
		@endif -->
	</div>


	<script type="text/javascript">
		var originalContent = $('#content').html();

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


		function back()
		{
			$('#content').html(originalContent);
		}


	</script>

</x-app-layout>
   		

	
