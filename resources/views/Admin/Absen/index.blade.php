<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="w-full h-full overflow-auto" data-simplebar>
    <div class="flex flex-row justify-end gap-x-3 mr-16 my-2 items-center">
		<x-filter-component />
   		<x-dropdown-download />
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
     <div class="join flex flex-row justify-center items-center m-2" id="pagination"></div>    
     <div class="flex justify-center items-center">
         <span id="load" class="loading loading-infinity loading-lg" style="display: none;"></span>
     </div>
 </div>

 <script type="text/javascript">
//   location.reload(true);
   $(document).ready(function () {
        // Initial fetch without filters
        fetchdata();

        $('#jurusan_id, #kelas, #abjat').change(function () {
            var jurusanId = $('#jurusan_id').val();
            var kelas = $('#kelas').val();
            var abjat = $('#abjat').val();
            updateFetch(jurusanId, kelas, abjat); // Refresh data when filters change
        });
    });

   	$('#pdf').on('click', function () {
    const jurusanId = $('#jurusan_id').val();
    const kelas = $('#kelas').val();
    const abjat = $('#abjat').val();
    // console.log(jurusanId, kelas, abjat);
    if (jurusanId === null || kelas === null || abjat === null) {
        toastr.error('Filter Export Must Be Insert!', 'Error')
    } else {
    var url = `absen-export/${jurusanId}/${kelas}/${abjat}`;

        $.ajax({
            url: url,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (res) {
                // Assuming the response contains a link to the generated PDF
                toastr.info('Data Absen Will Download!', 'Info')
                fetchdata()
                
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        });
    }
    });
    
    $('#csv').on('click', function() {
    const jurusanId = $('#jurusan_id').val();
    const kelas = $('#kelas').val();
    const abjat = $('#abjat').val();
    if (jurusanId === null || kelas === null || abjat === null) {
        toastr.error('Filter Export Must Be Insert!', 'Error')
    } else {
        var urls = `absensi-export-to-excel/${jurusanId}/${kelas}/${abjat}`
        $.ajax({
            url: urls,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (res) {
                // console.log(res)
                // Assuming the response contains a link to the generated PDF
                window.location.href = urls;
                toastr.info('Data Absen Will Download!', 'Info')
                
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        })
    }
   })

    function updateFetch(jurusanId, kelas, abjat) {

        $('.data-siswa').each(function() {
        var optionJurusanId = $(this).data('jurusanData');
        var optionKelas = $(this).data('kelas');
        var optionAbjat = $(this).data('abjat') || ''; // Treat undefined as empty string

        // Check if the option matches the selected values or if the selected value is empty
        var jurusanMatch = jurusanId === '' || jurusanId == optionJurusanId;
        var kelasMatch = kelas === '' || kelas == optionKelas;
        
        // Explicitly handle undefined case
        var abjatMatch = abjat === undefined ? optionAbjat === '' : String(abjat) == optionAbjat;

        // Menyembunyikan atau menampilkan data berdasarkan kondisi
            if (jurusanMatch && kelasMatch && abjatMatch) 
            {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }

     function paginate(meta)
    {
        var current = meta.current_page
        var totalPages = meta.last_page;
        $('#pagination').empty();


        for (var i = 1; i <= totalPages; i++) {
            i != current ? $('#pagination').append(`<button class="join-item btn" onclick="fetchdata(${i})">${i}</button>`) : $('#pagination').append(`<button class="join-item btn" disabled onclick="fetchdata(${i})">${i}</button>`)
        }

       
        current != totalPages ? $('#pagination').append(`<button class="join-item btn" onclick="fetchdata(${totalPages})">Last</button>`) : ""
    }

    function fetchdata() {
        $('#load').show();

        $.ajax({
            url: '/api/admin/absen',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#load').hide();

                if (response && Array.isArray(response.data)) {
                    $('#userList').empty();
                    var no = 1;
                    paginate(response.meta)

                    if (response.data.length != 0) {
                        response.data.forEach(function (siswa) {

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
						        data-abjat = '${siswa.abjat}'>
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

 </script>