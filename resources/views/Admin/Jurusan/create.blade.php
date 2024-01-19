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
     $('#btnSave').on('click', function () {
        const name = $('#name').val();
        $.ajax({
            url: '{{ route('jurusan.store') }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { name },
            success: function () {
                // After creating a new user, fetch updated data
                fetchdata();
                toastr.success('Data Has Been Saved !', 'success')
                $('#name').val('');
            },
            error: function (error) {
                console.error('Error adding person:', error);
            }
        });
    });
</script>
