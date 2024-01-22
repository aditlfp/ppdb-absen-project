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
       <div class="w-full h-full overflow-auto" data-simplebar>
        <div class="flex justify-end items-end w-full my-5">
            <button id="btnCreate" class="btn bg-amber-500  transition-all ease-in-out duration-150 w-fit">Create New</button>
        </div>
        <table class="table table-xs table-zebra max-h-[50%]">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="userList">
                <!-- User data will be dynamically added here -->
            </tbody>
        </table>
         <div class="join flex flex-row justify-center items-center m-2" id="paginationContainer"></div>    
         <div id="content-container"></div>
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
                url: 'user-data/create',
                type: 'GET',
                success: function(response){
                    $('#btnCreate').show()
                    $('#modal').hide()
                }
                })
            })
        })

        function paginate(meta) {
          const container = $('<div/>').addClass('join shadow-md');

          const prev = meta.links[0].url;
          const next = meta.links[meta.links.length - 1].url;
          const current = meta.current_page;
          console.log(prev, next, current)

          if (prev) {
            const prevLink = $('<a/>')
              .attr('href', prev)
              .addClass('join-item btn bg-blue-600 hover:bg-blue-800')
              .text('«');

            container.append(prevLink);
          }

          const currentButton = $('<button/>')
            .addClass('join-item btn bg-blue-600 hover:bg-blue-800')
            .text(current);

          container.append(currentButton);

          if (next) {
            const nextLink = $('<a/>')
              .attr('href', next)
              .addClass('join-item btn bg-blue-600 hover:bg-blue-800')
              .text('»');

            container.append(nextLink);
          }

          // Append the container to your desired element in the DOM
          $('#paginationContainer').empty().append(container);
        }


        function fetchdata(page = 1) {
            $('#load').show()
            $.ajax({
                url: '/api/admin/user?page=' + page,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    console.log(response);
                    $('#load').hide()
                    if (response && Array.isArray(response.data)) {
                    // Clear existing content
                    $('#userList').empty();
                    var no = 1;
                    //http://localhost:8001/api/admin/user?page=1
                    paginate(response.meta)
                    // Iterate through the response and append rows to the table
                    response.data.forEach(function(user) {

                        const createdAtDate = new Date(user.created_at);

                        // Extract year, month, and day
                        const year = createdAtDate.getFullYear();
                        const month = String(createdAtDate.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
                        const day = String(createdAtDate.getDate()).padStart(2, '0');

                        // Format the YMD string
                        const ymdString = `${year}-${month}-${day}`;

                        $('#userList').append(`
                            <tr>
                                <td>${no++}</td>
                                <td>${user.name}</td>
                                <td>${user.email}</td>
                                <td>${user.role.name}</td>
                                <td>${ymdString}</td>
                                <td>
                                    <div class="flex gap-x-3">
                                        <button onclick="editUser(${user.id})" class="btn btn-xs bg-amber-500"><i class="ri-pencil-fill"></i></button>
                                        <button onclick="deleteUser(${user.id})" class="btn btn-xs bg-red-500"><i class="ri-close-line"></i></button>     
                                    </div>
                                </td>
                            </tr>
                        `);
                    });
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
                url: 'user-data/create',
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
                url: `/api/admin/user/${userId}`,
                type: 'DELETE',
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(){
                    toastr.warning('Data User Has Deleted!', 'Warning')
                    fetchdata()
                }
            })
        }

        function editUser(userId)
        {
            $.ajax({
                url: `/api/admin/user/${userId}`,
                type: 'GET',
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    // console.log(response);
                   $.ajax({
                        url: `user-data/${response.data.id}/edit`,
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
   

  