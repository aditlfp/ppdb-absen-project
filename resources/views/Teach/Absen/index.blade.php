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
    $(document).ready(function(){
         fetchdata()
     })

     function fetchdata() {
         $('#load').show()
         $.ajax({
             url: '/api/teacher/absensi',
             type: 'GET',
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             success: function(response){
                 console.log(response.data);
                 $('#load').hide()
                 if (response && Array.isArray(response.data)) {
                 // Clear existing content
                 $('#userList').empty();
                 var no = 1;
                 // Iterate through the response and append rows to the table
                 if (response.data.length != 0) {
                     response.data.forEach(function(siswa) {
                         $('#userList').append(`
                             <tr>
                                 <td>${no++}</td>
                                 <td>${siswa.kelas}</td>
                                 <td>${siswa.jurusan.name} - ${siswa.abjat}</td>
                                 <td>${siswa.tidak_masuk}</td>
                             </tr>
                         `);
                     });
                }else{
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