<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <title>Document</title>
</head>
<body>
    <div id="mainContent" class="w-full">
     <div class="flex justify-end items-end my-5 mr-3 gap-x-2">
         <button id="btnCreate" onclick="create()" class="btn bg-amber-500  transition-all ease-in-out duration-150 w-fit">Create New</button>
         <button id="btnBack" onclick="back()" class="btn bg-red-500  transition-all ease-in-out duration-150 w-fit">Home</button>
     </div>
     <table id="dataSiswa" class="table table-xs table-zebra max-h-[50%]" data-simplebar>
         <thead>
             <tr>
                 <th>#</th>
                 <th>Nama Lengkap</th>
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

         <div id="modal" style="display: none" class="w-full h-full">
             <div id="modalBody">

             </div>
         </div>

     <div class="flex justify-center items-center">
         <span id="load" class="loading loading-infinity loading-lg" style="display: none;"></span>
     </div>
 </div>
 <script>
    var mainContent = $('#mainContent').html();
     $(document).ready(function(){
         fetchdata()
         $('#close').on('click', function() {
                 $('#btnCreate').show()
                 $('#modal').hide()
                 $('#dataSiswa').show();
         })
     })

     function backTo()
     {
        $('#mainContent').html(mainContent);
        fetchdata()
     }

     function fetchdata() {
         $('#load').show()
         var created = {!! Auth::user()->create !!};
         var deleted = {!! Auth::user()->delete !!}
         $.ajax({
             url: '/api/teacher/ppdb-siswa',
             type: 'GET',
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             success: function(response){
                 $('#load').hide()
                 if (response && Array.isArray(response.data)) {
                 // Clear existing content
                 $('#userList').empty();
                 var no = 1;
                 var auth = {{ Auth::user()->role_id}}
                 // Iterate through the response and append rows to the table
                 if (response.data.length != 0) {
                     response.data.forEach(function(siswa) {
                         $('#userList').append(`
                             <tr>
                                 <td>${no++}</td>
                                 <td>${siswa.nama_lengkap}</td>
                                 <td>${siswa.no_tlp}</td>
                                 <td>Des.${siswa.desa} / RT ${siswa.rt}/ RW ${siswa.rw}, Kel.${siswa.kelurahan}, Kec.${siswa.kecamatan}, Kota.${siswa.kota}</td>
                                 <td>${siswa.nama_ortu}</td>
                                 <td>${siswa.no_tlp_ortu}</td>
                                 <td>
                                     <div class="flex gap-x-3">
                                        ${auth == 2 ? `<button onclick="editUser(${siswa.id})" class="btn btn-xs bg-amber-500"><i class="ri-pencil-fill"></i></button>` : ""}
                                        ${auth == 2 ? `<button onclick="deleteUser(${siswa.id})" class="btn btn-xs bg-red-500"><i class="ri-close-line"></i></button>` : ""}
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

        function create()
        {
            $.ajax({
             url: 'teacher/siswa-new/create',
             type: 'GET',
             success: function(response){
                 $('#modalBody').html(response + '<div class="flex justify-center gap-x-3 m-2"><button id="btnSave" type="button" class="btn bg-sky-500">Save</button><button onclick="backTo()" type="button" class="btn bg-red-500">Back</button></div>')
                 $('#btnCreate').hide()
                 $('#modal').show()
                 $('#dataSiswa').hide()
             }
         })
        }

     function deleteUser(userId)
     {
         $.ajax({
             url: `/api/teacher/ppdb-siswa/${userId}`,
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
             url: `/api/teacher/ppdb-siswa/${userId}`,
             type: 'GET',
             headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             success: function(response){
                 // console.log(response);
                $.ajax({
                     url: `teacher/siswa-new/${response.data.id}/edit`,
                     type: 'GET',
                     success: function(res)
                     {
                         // console.log(res);
                         $(document).ready(function() {
                             getData(response)
                         })
                         $('#modalBody').html(res + '<div class="flex justify-center gap-x-3 m-2"><button id="btnSave2" type="button" class="btn bg-sky-500">Save</button><button onclick="backTo()" type="button" class="btn bg-red-500">Back</button></div>')
                         $('#modal').show()
                     }
                })
             }
         })
     }

 </script>
</body>
</html>


