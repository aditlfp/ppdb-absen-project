<x-app-layout>
    <div class="shadow-sm flex flex-col justify-content-center items-center w-full h-screen bg-slate-200">
    	<div class="mt-20 mx-2">
    		<div class="font-semibold text-center text-lg">
    			Absensi Siswa SMK Pemkab Ponorogo
	    	</div>

		    <div class="flex flex-col m-5">
		        <label for="jurusan_id" class="text-sm font-semibold required">Jurusan :</label>
		        <select id="jurusan_id" name="jurusan_id" class="select select-warning text-xs select-sm w-full max-w-xs">
		            <option value="0" disabled selected>~Pilih Jurusan~</option>	
		        </select>
		    </div>
		    <div class="flex flex-col m-5">
		        <label for="kelas" class="text-sm font-semibold required">Kelas :</label>
		         <select id="kelas" name="kelas" class="select select-warning text-xs select-sm w-full max-w-xs">
		            <option value="0" disabled selected>~Pilih Kelas~</option>
		            <option value="X">X</option>
		            <option value="XI">XI</option>
		            <option value="XII">XII</option> <!-- Corrected value for Admin -->
		        </select>
		    </div>
		    <div class="flex flex-col m-5">
		        <label for="abjat" class="text-sm font-semibold required">Abjat :</label>
		        <select id="abjat" name="abjat" class="select select-warning text-xs select-sm w-full max-w-xs">
		            <option value="0" disabled selected>~Pilih Abjat~</option>	
		        </select>
		    </div>
		    <div class="flex flex-col m-5">
		        <label for="tidak_masuk" class="text-sm font-semibold">Siswa Yang Tidak Masuk :</label>
		        <textarea name="tidak_masuk" id="tidak_masuk" class="textarea textarea-warning" placeholder="Siswa Yang Tidak Masuk"></textarea>
		    </div>
		    <div class="btn bg-sky-500 w-full" onclick="storeData()">
    			<button id="btnSave">Save</button>
    		</div>

    	</div>
    	    	
    </div>




    <script type="text/javascript">
    	fetchJurusan();
		getAbjat();

    	function fetchJurusan()
    	{
    		$.ajax({
    			url: '{{ route("data-jurusan.index") }}',
    			method: 'GET',
    			success: function(res)
    			{
    				console.log(res.data[0])
				    // Dapatkan elemen select berdasarkan ID
				    var selectElement = $('#jurusan_id');

				    // Loop melalui data dan tambahkan opsi ke elemen select
				    $.each(res.data, function (index, item) {
				      selectElement.append($('<option>', {
				        value: item.id,
				        text: item.name
				      }));
				    });
    			}
    		})
    	}

    	function getAbjat()
    	{
    		var selectElement = $('#abjat');

		    // Loop dari huruf A sampai Z
		    for (var i = 65; i <= 90; i++) {
		      // Konversi nilai ASCII menjadi karakter huruf
		      var letter = String.fromCharCode(i);

		      // Tambahkan opsi ke dalam elemen select
		      selectElement.append($('<option>', {
		        value: letter,
		        text: letter
		      }));
		    }
    	}

    	
    	function storeData()
    	{
    		const jurusan_id = $('#jurusan_id').val();
    		const kelas = $('#kelas').val();
    		const abjat = $('#abjat').val();
    		const tidak_masuk = $('#tidak_masuk').val();

	        $.ajax({
	            url: '{{ route('absensi.store') }}',
	            method: 'POST',
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            },
	            data: { jurusan_id, kelas, abjat, tidak_masuk },
	            success: function () {
	                // After creating a new user, fetch updated data
	                toastr.success('Data Has Been Saved !', 'success')
	                $('#jurusan_id').val('');
	                $('#kelas').val('');
	                $('#abjat').val('');
	                $('#tidak_masuk').val('');
	            },
	            error: function (error) {
	                console.error('Error adding data:', error);
	            }
        });
    	}


    </script>
</x-app-layout>
