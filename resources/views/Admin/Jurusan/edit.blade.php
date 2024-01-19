<div class="bg-gray-200 my-5 rounded-md shadow-md h-auto overflow-auto" data-simplebar>
  <div id="hero" class="text-center font-semibold text-md mt-10">
        <span>Create New Jurusan</span>
    </div>
    <div class="flex flex-col m-5">
        <label for="name" class="text-sm font-semibold required">Nama Jurusan :</label>
        <input type="text" id="name" name="name" placeholder="Masukkan Nama Jurusan" class="input input-bordered input-sm input-warning w-full max-w-xs" />
    </div>
</div>

<script>
    $('#load').show()
        function getData(response) {
        // Populate form fields with user data
        $('#name').val(response.data.name);

        // Hide the loading indicator
        $('#load').hide();

        // Attach click event handler to the Save button
        $('#btnSave2').on('click', function () {
            // Get updated values from form fields
            const name = $('#name').val();

            // Make an AJAX request to update user data
            $.ajax({
                url: `/api/admin/jurusan/${response.data.id}`,
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { name },
                success: function () {
                    // After updating user data, fetch updated data
                    fetchdata();
                    toastr.success('Data Has Been Saved!', 'success');

                    // Reset form fields
                    $('#name').val('');
                },
                error: function (error) {
                    console.error('Error updating user data:', error);
                    toastr.error('Failed to update data!', 'error');
                }
            });
        });
    }
</script>