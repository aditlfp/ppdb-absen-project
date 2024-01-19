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
     <div class="flex justify-end items-end w-full my-5">
         <button id="btnCreate" class="btn bg-amber-500  transition-all ease-in-out duration-150 w-fit">Create New</button>
     </div>
     <table class="table table-xs table-zebra max-h-[50%]">
         <thead>
             <tr>
                 <th>#</th>
                 <th>Nama</th>
                 <th>Action</th>
             </tr>
         </thead>
         <tbody id="userList">
             <!-- User data will be dynamically added here -->
         </tbody>
     </table>    

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
             $.ajax({
             url: 'siswa-data/create',
             type: 'GET',
             success: function(response){
                 $('#btnCreate').show()
                 $('#modal').hide()
             }
             })
         })
     })


     function fetchdata() {
         $('#load').show()
         $.ajax({
             url: '/api/admin/jurusan',
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
                 // Iterate through the response and append rows to the table
                 if (response.data.length != 0) {
                     response.data.forEach(function(jurus) {
                         $('#userList').append(`
                             <tr>
                                 <td>${no++}</td>
                                 <td>${jurus.name}</td>
                                 <td>
                                     <div class="flex gap-x-3">
                                         <button onclick="editUser(${jurus.id})" class="btn btn-xs bg-amber-500"><i class="ri-pencil-fill"></i></button>
                                         <button onclick="deleteUser(${jurus.id})" class="btn btn-xs bg-red-500"><i class="ri-close-line"></i></button>     
                                     </div>
                                 </td>
                             </tr>
                         `);
                     });
                }else{
                    $('#userList').append(`
                             <tr class="text-center">
                                 <td colspan=3"><span>~ Data Kosong ~</span></td>
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
             url: 'jurusan-data/create',
             type: 'GET',
             success: function(response){
                 $('#modalBody').html(response + '<div class="flex justify-center"><button id="btnSave" type="button" class="btn bg-sky-500 w-full">Save</button></div>')
                 $('#btnCreate').hide()
                 $('#modal').show()
             }
         })
     });

     function deleteUser(userId)
     {
         $.ajax({
             url: `/api/admin/jurusan/${userId}`,
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
             url: `/api/admin/jurusan/${userId}`,
             type: 'GET',
             headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             success: function(response){
                 // console.log(response);
                $.ajax({
                     url: `jurusan-data/${response.data.id}/edit`,
                     type: 'GET',
                     success: function(res)
                     {
                         // console.log(res);
                         $(document).ready(function() {
                             getData(response)
                         })
                         $('#modalBody').html(res + '<div class="flex justify-center"><button id="btnSave2" type="button" class="btn bg-sky-500 w-full">Save</button></div>')
                         $('#modal').show()
                     }
                })
             }
         })
     }

 </script>
</body>
</html>


