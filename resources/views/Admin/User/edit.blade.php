<div class="bg-gray-200 my-5 rounded-md shadow-md h-auto overflow-auto" data-simplebar>
    <div id="hero" class="text-center font-semibold text-md mt-10">
        <span>Edit User</span>
    </div>
    <div class="flex flex-col m-5">
        <label for="name" class="text-sm font-semibold">Name :</label>
        <input type="text" id="name" name="name" placeholder="Masukkan Nama" class="input input-bordered input-sm input-warning w-full max-w-xs" />
    </div>
    <div class="flex flex-col m-5">
        <label for="email" class="text-sm font-semibold">Email :</label>
        <input type="email" id="email" name="email" placeholder="example@gmail.com" class="input input-bordered input-sm input-warning w-full max-w-xs" />
    </div>
    <div class="flex flex-col m-5">
        <label for="role_id" class="text-sm font-semibold">Permission :</label>
        <select id="role_id" name="role_id" class="select select-warning text-xs select-sm w-full max-w-xs">
            <option value="0" disabled selected>~Select Permission~</option>
            <option value="1">Guru ( Teacher )</option>
            <option value="3">Siswa ( Student )</option>
            <option value="2">Admin</option> <!-- Corrected value for Admin -->
        </select>
    </div>
    <div class="flex flex-col m-5" style="display: none;" id="userPermission">
    <label for="role_id" class="text-sm font-semibold">User Permission :</label>
       <div class="form-control flex flex-col gap-y-2">

          <div class="flex flex-row items-center gap-x-5">
            <input type="checkbox" value="1" id="created" class="checkbox checkbox-warning" />
            <span class="label-text">Save Data</span>
          </div>

          <div class="flex flex-row items-center gap-x-5">
            <input type="checkbox" value="1" id="deleted" class="checkbox checkbox-warning" />
            <span class="label-text">Deleted</span>
          </div>
        </div>
    </div>
    <div class="flex flex-col m-5">
        <label for="password" class="text-sm font-semibold">Password :</label>
        <input type="password" id="password" name="password" class="input input-bordered input-sm input-warning w-full max-w-xs" />
    </div>
    <div class="flex flex-col m-5">
        <label for="password_confirmation" class="text-sm font-semibold">Retype Password :</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="input input-bordered input-sm input-warning w-full max-w-xs" />
    </div>
</div>

<script>
    $('#role_id').on('change', function(){
        $(this).val() == 1 ? $('#userPermission').show() : $('#userPermission').hide()
    })

    $('#load').show()
        function getData(response) {
        // Populate form fields with user data
        $('#name').val(response.data.name);
        $('#email').val(response.data.email);
        $('#role_id').val(response.data.role_id);
        $('#password').val(response.data.password);
        $('#password_confirmation').val(response.data.password);

        response.data.role_id == 1 ? $('#userPermission').show() : $('#userPermission').hide();

        $('#created').attr('checked', response.data.create == 1 ? true : false);
        $('#deleted').attr('checked', response.data.delete == 1 ? true : false);

        // Hide the loading indicator
        $('#load').hide();

        // Attach click event handler to the Save button
        $('#btnSave2').on('click', function () {
            // Get updated values from form fields
            const name = $('#name').val();
            const email = $('#email').val();
            const role_id = $('#role_id').val();
            const password = $('#password').val();
            const password_confirmation = $('#password_confirmation').val();
            const create = $('#created').attr('checked', response.data.create == 1 ? true : false);
            const deleted = $('#deleted').attr('checked', response.data.delete == 1 ? true : false);

            // Make an AJAX request to update user data
            $.ajax({
                url: `/api/admin/user/${response.data.id}`,
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { name, email, role_id, password, password_confirmation, create, delete: deleted },
                success: function () {
                    // After updating user data, fetch updated data
                    fetchdata();
                    toastr.success('Data Has Been Saved!', 'success');

                    // Reset form fields
                    $('#name').val('');
                    $('#email').val('');
                    $('#role_id').val('0');
                    $('#password').val('');
                    $('#password_confirmation').val('');
                    $('#created').attr('checked', false);
                    $('#deleted').attr('checked', false);
                },
                error: function (error) {
                    console.error('Error updating user data:', error);
                    toastr.error('Failed to update data!', 'error');
                }
            });
        });
    }
</script>