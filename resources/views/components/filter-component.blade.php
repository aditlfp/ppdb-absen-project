<div class="flex justify-center items-center gap-x-3">
     	<div class="flex flex-col justify-center ">
            <label for="jurusan_id" class="text-sm font-semibold required">Jurusan :</label>
            <select id="jurusan_id" name="jurusan_id" class="select select-warning text-xs select-sm w-full">
                <option value="0" disabled selected>~Pilih Jurusan~</option>    
            </select>
        </div>
        <div class="flex flex-col justify-center">
            <label for="kelas" class="text-sm font-semibold required">Kelas :</label>
             <select id="kelas" name="kelas" class="select select-warning text-xs select-sm w-full">
                <option value="0" disabled selected>~Pilih Kelas~</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option> <!-- Corrected value for Admin -->
            </select>
        </div>
        <div class="flex flex-col justify-center">
            <label for="abjat" class="text-sm font-semibold required">Abjat :</label>
            <select id="abjat" default-value="0" name="abjat" class="select select-warning text-xs select-sm w-full">
                <option value="0" disabled selected>~Pilih Abjat~</option>  
            </select>
        </div>
</div>

<script type="text/javascript">
	fetchJurusan()
	getAbjat()
	function fetchJurusan()
    	{
    		$.ajax({
    			url: '{{ route("jurusan.index") }}',
    			method: 'GET',
    			success: function(res)
    			{
    				// console.log(res.data[0])
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
</script>