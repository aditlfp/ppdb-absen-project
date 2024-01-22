<x-app-layout>
    <div class="shadow-sm flex flex-col justify-content-center items-center w-full bg-slate-200">
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
		        <select id="abjat" default-value="0" name="abjat" class="select select-warning text-xs select-sm w-full max-w-xs">
		            <option value="0" disabled selected>~Pilih Abjat~</option>	
		        </select>
		    </div>
		    <div class="flex flex-col m-5">
		       <label for="tidak_masuk" class="text-sm font-semibold">Tidak Masuk :</label>
		       <div id='checkboxContainer' class="flex flex-col gap-y-2">
		       	
		       </div>
		    </div>
		    <div class="btn bg-sky-500 w-full" onclick="storeData()">
    			<button id="btnSave">Save</button>
    		</div>
    	</div>
    	    	
    </div>




    <script type="text/javascript">
    	fetchJurusan();
		getAbjat();
		fetchSiswa()

		$(document).ready(function() {
			  // Event listener for jurusan_id
			  $('#jurusan_id').on('change', function() {
			    var jurusanId = $(this).val();
				var kelas = $('#kelas').val();
				var abjat = $('#abjat').val();
			    updateCheckboxVisibility(jurusanId, kelas, abjat);
			  });

			  // Event listener for kelas
			  $('#kelas').on('change', function() {
			    var jurusanId = $('#jurusan_id').val();
			    var kelas = $(this).val();
				var abjat = $('#abjat').val()
			    updateCheckboxVisibility(jurusanId, kelas, abjat);
			  });

			  // Event listener for abjat
			  $('#abjat').on('change', function() {
			    var jurusanId = $('#jurusan_id').val();
			    var kelas = $('#kelas').val();
			    var abjat = $(this).val();
			    updateCheckboxVisibility(jurusanId, kelas, abjat);
			  });
			});


			// Function to update checkbox visibility based on selected values
				function updateCheckboxVisibility(jurusanId, kelas, abjat) {

				  $('.checkbox, .labels, .keterangan, .warp').each(function() {
				    var optionJurusanId = $(this).data('jurusanData');
				    var optionKelas = $(this).data('kelas');
				    var optionAbjat = $(this).data('abjat') || ''; // Treat undefined as empty string

				    // Check if the option matches the selected values or if the selected value is empty
				    var jurusanMatch = jurusanId === '' || jurusanId == optionJurusanId;
				    var kelasMatch = kelas === '' || kelas == optionKelas;
				    
				    // Explicitly handle undefined case
				    var abjatMatch = abjat === undefined ? optionAbjat === '' : String(abjat) == optionAbjat;

				    // Menyembunyikan atau menampilkan checkbox berdasarkan kondisi
				    if (jurusanMatch && kelasMatch && abjatMatch) {
				      $(this).show();
				    } else {
				      $(this).hide();
				    }
				  });
				}


				function renderCheckboxes(item) {
					var no = 1;
					var divWrapper = $('<div>', { 
						class: 'flex flex-row warp',
						'data-jurusan-data': item.jurusan_id,
						'data-kelas': item.kelas,
						'data-abjat': item.abjat, });

					// Create checkbox with unique ID
					var checkbox = $('<input>', {
						type: 'checkbox',
						id: `checkbox_${item.id}_${no}`,
						name: 'tidak_masuk',
						class: 'checkbox mx-2',
						'data-jurusan-data': item.jurusan_id,
						'data-kelas': item.kelas,
						'data-abjat': item.abjat,
						value: item.nama_lengkap
					});

					// Create label with unique 'for' attribute
					var label = $('<label>', {
						for: `checkbox_${item.id}_${no}`,
						class: 'mr-2 labels',
						'data-jurusan-data': item.jurusan_id,
						'data-kelas': item.kelas,
						'data-abjat': item.abjat,
						text: item.nama_lengkap
					});

					// Create a group of checkboxes for 'S,' 'I,' 'A'
					var keteranganGroup = $('<div>', { class: 'flex flex-row items-center gap-x-2' });

					// Iterate over ['S', 'I', 'A'] to create individual checkboxes
					['S', 'I', 'A'].forEach((option) => {
						var keteranganCheckbox = $('<input>', {
							type: 'checkbox',
							id: `keterangan_${item.id}_${no}_${option}`,
							name: `keterangan_${item.id}_${no}`,
							class: 'keterangan-checkbox',
							value: option
						});

						var keteranganLabel = $('<label>', {
							for: `keterangan_${item.id}_${no}_${option}`,
							text: option
						});

						// Append each keterangan checkbox and label to the group
						keteranganGroup.append(keteranganCheckbox, keteranganLabel);
					});

					// Append checkbox, label, and keteranganGroup to the div wrapper
					divWrapper.append(checkbox, label, keteranganGroup);

					return divWrapper;
				}



			// Fetch student data
			function fetchSiswa() {
			  $.ajax({
			    url: '/api/teacher/ppdb-siswa',
			    method: 'GET',
			    headers: {
			      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
			    success: function(res) {
			      // Render data ke dalam checkbox
			      var selectElement = $('#checkboxContainer');

			      $.each(res.data, function(index, item) {
					selectElement.append(renderCheckboxes(item));
			      });
			    }
			  });
			}



    	function fetchJurusan()
    	{
    		$.ajax({
    			url: '{{ route("data-jurusan.index") }}',
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

    	
    	function storeData() {
		  const jurusan_id = $('#jurusan_id').val();
		  const kelas = $('#kelas').val();
		  const abjat = $('#abjat').val();

		  // Initialize an array to store the selected data
		  var selectedData = [];
		  $('.checkbox:checked').each(function(index, checkbox) {
				var id = $(checkbox).attr('id').replace(/^checkbox_/, '');
				var nama = $(checkbox).val();

				// Retrieve keterangan by finding checked checkboxes within the corresponding group
				var keterangan = $(`input[name="keterangan_${id}"]:checked`).map(function() {
					return $(this).val();
				}).get().join(', ');

				var data = {
					id: id,
					nama: nama,
					keterangan: keterangan
				};

				selectedData.push(data);
			});
		  // Mengonversi array ke dalam format JSON
		  const tidak_masukJSON = JSON.stringify(selectedData);

		  // Ajax request
		  $.ajax({
		    url: '{{ route('absensi.store') }}',
		    method: 'POST',
		    headers: {
		      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
		    data: { jurusan_id, kelas, abjat, tidak_masuk: tidak_masukJSON },
		    success: function() {
		      // Setelah membuat data baru, ambil data yang diperbarui
		      toastr.success('Data Has Been Saved!', 'success')
		      $('#jurusan_id').val('');
		      $('#kelas').val('');
		      $('#abjat').val('');

		      // Reset nilai checkbox yang dicentang
		      $('.checkbox:checked').prop('checked', false);
		    },
		    error: function(error) {
		      toastr.error('Data Failed Saved!', 'error')
		      console.error('Error adding data:', error);
		    }
		  });
		}





    </script>
</x-app-layout>
