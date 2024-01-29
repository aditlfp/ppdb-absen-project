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
     <div class="flex justify-end items-end w-full my-5 gap-x-3">
        <x-filter-component />
        <x-dropdown-download />
         <button id="btnCreate" class="btn bg-amber-500  transition-all ease-in-out duration-150 w-fit">Create New</button>
     </div>
     <section id="dataSiswa">
         <table class="table table-xs table-zebra max-h-[50%]">
             <thead>
                 <tr>
                     <th>#</th>
                     <th>Nama Lengkap</th>
                     <th>Kelas - Jurusan</th>
                     <th>Tlp</th>
                     <th>Alamat Lengkap</th>
                     <th>Org Tua / Wali</th>
                     <th>Tlp Org Tua</th>
                     <th>Action</th>
                 </tr>
             </thead>
             <tbody id="userList">
                 <!-- User data will be dynamically added here -->
             </tbody>
         </table>
         <div class="join flex flex-row justify-center items-center m-2" id="pagination"></div>    
    </section>
         <div id="modal" style="display: none">
             <div class="flex justify-end mt-5">
                 <button class="btn bg-red-500 mx-5" id="close">Close</button>
             </div>
             <div id="modalBody">

             </div>
         </div>

     <div class="flex justify-center items-center">
         <span id="load" class="loading loading-infinity loading-lg" style="display: none;"></span>
     </div>
 </div>
 
 <script>
     $(document).ready(function(){
         fetchdata()


         $('#close').on('click', function() {
                 $('#btnCreate').show()
                 $('#modal').hide()
                 $('#dataSiswa').show()
         })
     })
     // jurusan_id, kelas, abjat

     function paginate(meta)
    {
        var current = meta.current_page
        var totalPages = meta.last_page;
        $('#pagination').empty();
        // <div class="join flex flex-row justify-center items-center m-2" id="pagination"></div>    


        for (var i = 1; i <= totalPages; i++) {
            i != current ? $('#pagination').append(`<button class="join-item btn" onclick="fetchdata(${i})">${i}</button>`) : $('#pagination').append(`<button class="join-item btn" disabled onclick="fetchdata(${i})">${i}</button>`)
        }

       
        current != totalPages ? $('#pagination').append(`<button class="join-item btn" onclick="fetchdata(${totalPages})">Last</button>`) : ""
    }

    $('#jurusan_id').on('change', function() {
        var jurusanId = $(this).val()
        var kelas = $('#kelas').val()
        var abjat = $('#abjat').val()
        updateFetch(jurusanId, kelas, abjat)
    })

    $('#kelas').on('change', function() {
        var jurusanId = $('#jurusan_id').val()
        var kelas = $(this).val()
        var abjat = $('#abjat').val()
        updateFetch(jurusanId, kelas, abjat)


    })

    $('#abjat').on('change', function() {
        var jurusanId = $('#jurusan_id').val()
        var kelas = $('#kelas').val()
        var abjat = $(this).val()
        updateFetch(jurusanId, kelas, abjat)
    })

    function dataFound(noDataFound = true)
    {
        // Display message if no matching data is found
        if (noDataFound) {
            // Check if the message is not already added
            if ($('.data_notfound').length <= 0) {
                $('#userList').append(`
                    <tr class="text-center data_notfound">
                        <td colspan="8"><span>~ Data Tidak Tersedia ~</span></td>
                    </tr>
                `);
            }
        } else {
            // Hide the message if matching data is found
            $('.data_notfound').hide();
        }
    }

    function updateFetch(jurusanId, kelas, abjat) {
     // Initialize as true, assuming no data is found initially

        $('.data-siswa').each(function () {
            var optionJurusanId = $(this).data('jurusanData');
            var optionKelas = $(this).data('kelas');
            var optionAbjat = $(this).data('abjat') || '';

            var jurusanMatch = jurusanId === '' || jurusanId == optionJurusanId;
            var kelasMatch = kelas === '' || kelas == optionKelas;
            var abjatMatch = abjat === undefined ? optionAbjat === '' : String(abjat) == optionAbjat;

            if (jurusanMatch && kelasMatch && abjatMatch) {
                $(this).show();
                dataFound(false)
            } else {
                $(this).hide();
            }
        });
         dataFound()

    }

   $('#pdf').on('click', function () {
    const jurusanId = $('#jurusan_id').val();
    const kelas = $('#kelas').val();
    const abjat = $('#abjat').val();
    // console.log(jurusanId, kelas, abjat);
    if (jurusanId === null || kelas === null || abjat === null) {
        toastr.error('Filter Export Must Be Insert!', 'Error')
    } else {
    var url = `siswa-export/${jurusanId}/${kelas}/${abjat}`;

        $.ajax({
            url: url,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (res) {
                // Assuming the response contains a link to the generated PDF
                toastr.info('Data Siswa Will Download!', 'Info')
                fetchdata()
                // window.location.href = res;
                
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
        var urls = `export-to-excel/${jurusanId}/${kelas}/${abjat}`
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
                toastr.info('Data Siswa Will Download!', 'Info')
                
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        })
    }
   })



     function fetchdata() {
         $('#load').show()
         $.ajax({
             url: '/api/admin/siswa',
             type: 'GET',
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             success: function(response){
                //  console.log(response.data);
                 $('#load').hide()
                 if (response && Array.isArray(response.data)) {
                 // Clear existing content
                 $('#userList').empty();
                 var no = 1;
                 paginate(response.meta)
                 // Iterate through the response and append rows to the table
                 if (response.data.length != 0) {
                     response.data.forEach(function(siswa) {
                         $('#userList').append(`
                             <tr class="data-siswa" 
                                data-jurusan-data = '${siswa.jurusan_id}'
                                data-kelas = '${siswa.kelas}'
                                data-abjat = '${siswa.abjat}'>
                                 <td>${no++}</td>
                                 <td>${siswa.nama_lengkap}</td>
                                 <td>${siswa.kelas?siswa.kelas:'-'}  ${siswa.jurusan?siswa.jurusan.name:'-'}-${siswa.abjat?siswa.abjat:'-'}</td>
                                 <td>${siswa.no_tlp}</td>
                                 <td>Des.${siswa.desa} / RT ${siswa.rt}/ RW ${siswa.rw}, Kel.${siswa.kelurahan}, Kec.${siswa.kecamatan}, Kota.${siswa.kota}</td>
                                 <td>${siswa.nama_ortu}</td>
                                 <td>${siswa.no_tlp_ortu}</td>
                                 <td>
                                     <div class="flex gap-x-3">
                                         <button onclick="editUser(${siswa.id})" class="btn btn-xs bg-amber-500"><i class="ri-pencil-fill"></i></button>
                                         <button onclick="deleteUser(${siswa.id})" class="btn btn-xs bg-red-500"><i class="ri-close-line"></i></button>     
                                     </div>
                                 </td>
                             </tr>
                         `);
                     });
                }else{
                    $('#userList').append(`
                             <tr class="text-center">
                                 <td colspan="9"><span>~ Data Kosong ~</span></td>
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

     $('#btnCreate').on('click', function() {
         $.ajax({
             url: 'siswa-data/create',
             type: 'GET',
             success: function(response){
                 $('#modalBody').html(response + '<div class="flex justify-center"><button id="btnSave" type="button" class="btn bg-sky-500 w-full">Save</button></div>')
                 $('#btnCreate').hide()
                 $('#modal').show()
                 $('#dataSiswa').hide()
             }
         })
     });

     function deleteUser(userId)
     {
         $.ajax({
             url: `/api/admin/siswa/${userId}`,
             type: 'DELETE',
             headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             success: function(){
                 toastr.warning('Data Student Has Deleted!', 'Warning')
                 fetchdata()
             }
         })
     }

     function editUser(userId)
     {
         $.ajax({
             url: `/api/admin/siswa/${userId}`,
             type: 'GET',
             headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             success: function(response){
                 // console.log(response);
                $.ajax({
                     url: `siswa-data/${response.data.id}/edit`,
                     type: 'GET',
                     success: function(res)
                     {
                         // console.log(res);
                         $(document).ready(function() {
                             getData(response)
                         })
                         $('#modalBody').html(res + '<div class="flex justify-center"><button id="btnSave2" type="button" class="btn bg-sky-500 w-full">Save</button></div>')
                         $('#modal').show()
                         $('#dataSiswa').hide()
                     }
                })
             }
         })
     }

 </script>
</body>
</html>


