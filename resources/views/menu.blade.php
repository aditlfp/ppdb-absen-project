<x-app-layout>
	
<div class="flex flex-col w-full h-screen justify-center items-center px-10 bg-slate-700">
		<div class="sm:w-[40%] w-full bg-sky-500 flex flex-col justify-center items-center rounded-lg shadow-sm">
			<div class="my-10">
				<span class="text-lg font-semibold uppercase">Menu</span>
			</div>

			<div onclick="siswaNew()" class="my-2 btn bg-amber-500 border-0 w-[90%]">
				<span>Daftar Siswa Baru</span>
			</div>

			<div class="my-2 btn bg-amber-500 border-0 w-[90%]">
				<span>Info Absensi</span>
			</div>

			<!-- Cek Role 1 atau 2 dan tampilkan menu -->
			@if(Auth::user()->role_id == 1)
				<div class="my-2 btn bg-amber-500 border-0 w-[90%]">
					<span>Absensi</span>
				</div>

			@elseif(Auth::user()->role_id == 2)
				<div class="my-2 btn bg-amber-500 border-0 w-[90%]">
					<span>Admin Panel</span>
				</div>
			@endif
				<span class="text-xs italic text-sky-700 mb-5">Creted By <a href="https://github.com/aditlfp" target="_blank">@aditlfp</a></span>
		</div>
	</div>

	<script type="text/javascript">
		

		function siswaNew()
		{
			window.location.href = "teacher/siswa-new"
		}
		


	</script>

</x-app-layout>
   		

	
