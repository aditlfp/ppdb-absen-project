<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

     <div class="fixed top-0 bg-amber-500 w-full h-screen z-[9992]" id="modalE" style="display: block;"> <!-- Modal Filter Data -->
        <div class="flex justify-end items-end">
            <button class="btn btn-circle btn-error btn-sm m-2" onclick="$('#modalE').fadeOut();"><i class="ri-close-fill text-lg"></i></button>
        </div>
        <div class="flex flex-col gap-x-2 ml-2 my-2 justify-center items-center py-5">
            <h1 class="font-semibold text-lg">Data Absensi</h1>
        <div class="flex flex-col justify-center w-full px-10">
            <label for="jurusan_id" class="text-sm font-semibold">Jurusan :</label>
            <select id="jurusan_id" name="jurusan_id" class="select select-warning text-xs select-sm w-full">
                <option value="0" disabled selected>~Pilih Jurusan~</option>    
            </select>
        </div>
        <div class="flex flex-col justify-center w-full px-10">
            <label for="kelas" class="text-sm font-semibold">Kelas :</label>
             <select id="kelas" name="kelas" class="select select-warning text-xs select-sm w-full">
                <option value="0" disabled selected>~Pilih Kelas~</option>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option> <!-- Corrected value for Admin -->
            </select>
        </div>
        <div class="flex flex-col justify-center w-full px-10">
            <label for="abjat" class="text-sm font-semibold">Abjat :</label>
            <select id="abjat" default-value="0" name="abjat" class="select select-warning text-xs select-sm w-full">
                <option value="0" disabled selected>~Pilih Abjat~</option>  
            </select>
        </div>
        <div class="flex flex-col justify-center w-full px-10">
            <label for="abjat" class="text-sm font-semibold">Bulan Absen :</label>
            <input type="month" name="bulan" id="bulan" class="input input-bordered input-sm text-xs">
        </div>
        <div class="flex flex-col items-center">
            <div class="mt-4 mr-2">
                <button class="btn btn-sm btn-secondary" id="getdata">View Data</button>
                <button class="btn btn-sm btn-error" id="clear">Clear Filter</button>
            </div>
        </div>
    </div>
    </div>


    <div class="w-full h-full overflow-auto" data-simplebar>
        <div class="flex justify-end mr-2 my-2 gap-x-2">
            <button onclick=" $('#modalE').fadeIn();" class="btn btn-accent"><i class="ri-equalizer-line text-xl text-white font-normal"></i></button>
        </div>
     <table class="table table-xs table-zebra max-h-[50%]" >
         <thead>
             <tr>
                 <th>#</th>
                 <th>Kelas</th>
                 <th>Jurusan</th>
                 <th>Tidak Masuk</th>
             </tr>
         </thead>
         <tbody id="userList">
             <!-- User data will be dynamically added here -->
         </tbody>
     </table>    
     <div class="flex justify-center items-center">
         <span id="load" class="loading loading-infinity loading-lg" style="display: none;"></span>
     </div>
 </div>

 <script type="text/javascript">
//   location.reload(true);
   $(document).ready(function () {
        // Initial fetch without filters
        fetchdata();
        fetchJurusan();
        getAbjat();

        $('#getdata').on('click', function () {
            var jurusanId = $('#jurusan_id').val();
            var kelas = $('#kelas').val();
            var abjat = $('#abjat').val();
            var bulan = $('#bulan').val();
            $('#modalE').fadeOut();
            updateFetch(jurusanId, kelas, abjat, bulan); // Refresh data when filters change
        });
    });

    $('#clear').on('click', function() {
        $('#jurusan_id').val(0);
        $('#kelas').val(0);
        $('#abjat').val(0);
        fetchdata();
    })
    

    function updateFetch(jurusanId, kelas, abjat, bulan) {
    var noDataFound = true; // Flag to check if any matching data is found

    $('.data-siswa').each(function () {
        var optionJurusanId = $(this).data('jurusanData');
        var optionKelas = $(this).data('kelas');
        var optionAbjat = $(this).data('abjat') || '';
        var optionCreated = $(this).data('created');

        var jurusanMatch = jurusanId === '' || jurusanId == optionJurusanId;
        var kelasMatch = kelas === '' || kelas == optionKelas;
        var abjatMatch = abjat === undefined ? optionAbjat === '' : String(abjat) == optionAbjat;
        var createdMatch = bulan === '' || bulan == optionCreated;

        if (jurusanMatch && kelasMatch && abjatMatch && createdMatch) {
            $(this).show();
            noDataFound = false; // Matching data found
        } else {
            $(this).hide();
        }
    });

    // Display message if no matching data is found
    if (noDataFound) {
        $('#userList').append(`
            <tr class="text-center">
                <td colspan="5"><span>~ Data Tidak Tersedia ~</span></td>
            </tr>
        `);
    }
}


    function fetchdata() {
        $('#load').show();

        $.ajax({
            url: '{{ route("data-siswa-absen.index") }}',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#load').hide();

                if (response && Array.isArray(response.data)) {
                    $('#userList').empty()
                    var no = 1;

                    if (response.data.length != 0) {
                        response.data.forEach(function (siswa) {
                            const date = new Date(siswa.created_at);
                            const formattedDate = `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}`;


                            var tidakMasukHtml = '';
                    
                            if (typeof siswa.tidak_masuk === 'string') {
                                try {
                                    var tidakMasukArray = JSON.parse(siswa.tidak_masuk);

                                    if (Array.isArray(tidakMasukArray)) {
                                        tidakMasukArray.forEach(function (data) {
                                            tidakMasukHtml += `
                                                <div>
                                                    Nama: ${data.nama}, Keterangan: ${data.keterangan}
                                                </div>`;
                                        });
                                    } else {
                                        console.error('Invalid tidak_masuk data format:', tidakMasukArray);
                                        tidakMasukHtml = 'Invalid tidak_masuk data';
                                    }
                                } catch (error) {
                                    console.error('Error parsing tidak_masuk JSON:', siswa.tidak_masuk);
                                    tidakMasukHtml = 'Error parsing tidak_masuk JSON';
                                }
                            } else {
                                console.error('Invalid tidak_masuk data format:', siswa.tidak_masuk);
                                tidakMasukHtml = 'Invalid tidak_masuk data';
                            }

                            $('#userList').append(`
                                <tr class="data-siswa" 
                                data-jurusan-data = '${siswa.jurusan_id}'
						        data-kelas = '${siswa.kelas}'
						        data-abjat = '${siswa.abjat}'
                                data-created = '${formattedDate}'>
                                    <td>${no++}</td>
                                    <td>${siswa.kelas}</td>
                                    <td>${siswa.jurusan.name} - ${siswa.abjat}</td>
                                    <td>${tidakMasukHtml}</td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#userList').append(`
                                <tr class="text-center">
                                    <td colspan="5"><span>~ Data Kosong ~</span></td>
                                </tr>
                            `);
                    }

                } else {
                    alert('Invalid response format');
                }
            },
            error: function (error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    function fetchJurusan()
    	{
    		$.ajax({
    			url: '{{ route("siswa-jurusan.index") }}',
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