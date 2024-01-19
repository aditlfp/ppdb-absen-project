<div class="bg-gray-200 my-5 rounded-md shadow-md h-auto overflow-auto" data-simplebar>
    <div id="hero" class="text-center font-semibold text-md mt-10">
        <span>Create New Student</span>
    </div>
    <div class="flex flex-col m-5">
        <label for="nama_lengkap" class="text-sm font-semibold required">Nama Lengkap :</label>
        <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama Lengkap" class="input input-bordered input-sm input-warning w-full max-w-xs" />
    </div>
    <div class="flex flex-col m-5">
        <label for="no_tlp" class="text-sm font-semibold required">No. Tlp :</label>
        <input type="text" id="no_tlp" name="no_tlp" placeholder="0812223333" class="input input-bordered input-sm input-warning w-full max-w-xs" />
    </div>
    <div class="flex m-5 gap-x-3">
        <div class="flex flex-col">
            <label for="desa" class="text-sm font-semibold required">Desa :</label>
            <input type="text" id="desa" name="desa" placeholder="Wates" class="input input-bordered input-sm input-warning w-full max-w-xs" />
        </div>
        <div class="flex flex-col">
            <label for="rt" class="text-sm font-semibold required">RT :</label>
            <input type="text" id="rt" name="rt" placeholder="01" pattern="^(0?[1-9]|[1-9][0-9]|[1-9][0-9][0-9])$" title="Harap masukkan RT antara 01 dan 999" class="input input-bordered input-sm input-warning w-full max-w-xs" />
        </div>
        <div class="flex flex-col">
            <label for="rw" class="text-sm font-semibold required">RW :</label>
            <input type="text" id="rw" name="rw" placeholder="01" pattern="^(0?[1-9]|[1-9][0-9]|[1-9][0-9][0-9])$" title="Harap masukkan RW antara 01 dan 999" class="input input-bordered input-sm input-warning w-full max-w-xs" />
        </div>
    </div>
    <div class="flex flex-col m-5">
        <label for="kelurahan" class="text-sm font-semibold">Kelurahan :</label>
        <input type="text" id="kelurahan" name="Jenangan" placeholder="Kelurahan" class="input input-bordered input-sm input-warning w-full max-w-xs" />
    </div>
    <div class="flex flex-col m-5">
        <label for="kecamatan" class="text-sm font-semibold capitalize required">kecamatan :</label>
        <input type="text" id="kecamatan" name="kecamatan" placeholder="jenangan" class="input input-bordered input-sm input-warning w-full max-w-xs" />
    </div>
    <div class="flex flex-col m-5">
        <label for="kota" class="text-sm font-semibold required">Kota :</label>
        <input type="text" id="kota" name="kota" placeholder="Ponorogo" class="input input-bordered input-sm input-warning w-full max-w-xs" />
    </div>
    <div class="flex flex-col m-5">
        <label for="nama_ortu" class="text-sm font-semibold capitalize required">nama orang tua ( wali ) :</label>
        <input type="text" id="nama_ortu" name="nama_ortu" placeholder="Budianto" class="input input-bordered input-sm input-warning w-full max-w-xs" />
    </div>
    <div class="flex flex-col m-5">
        <label for="no_tlp_ortu" class="text-sm font-semibold capitalize required">no. tlp orang tua :</label>
        <input type="text" id="no_tlp_ortu" name="no_tlp_ortu" placeholder="081222211" class="input input-bordered input-sm input-warning w-full max-w-xs" />
    </div>
</div>

<script>
    $('#btnSave').on('click', function () {
        const nama_lengkap = $('#nama_lengkap').val();
        const no_tlp = $('#no_tlp').val();
        const desa = $('#desa').val();
        const rt = $('#rt').val();
        const rw = $('#rw').val();
        const kelurahan = $('#kelurahan').val();
        const kecamatan = $('#kecamatan').val();
        const kota = $('#kota').val();
        const nama_ortu = $('#nama_ortu').val();
        const no_tlp_ortu = $('#no_tlp_ortu').val();

        $.ajax({
            url: '{{ route('siswa.store') }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { nama_lengkap,
                    no_tlp,
                    desa,
                    rt,
                    rw,
                    kelurahan,
                    kecamatan,
                    kota,
                    nama_ortu,
                    no_tlp_ortu },
            success: function () {
                // After creating a new user, fetch updated data
                fetchdata();
                toastr.success('Data Has Been Saved !', 'success')
                $('#nama_lengkap').val('');
                $('#no_tlp').val('');
                $('#desa').val('');
                $('#rt').val('');
                $('#rw').val('');
                $('#kelurahan').val('');
                $('#kecamatan').val('');
                $('#kota').val('');
                $('#nama_ortu').val('');
                $('#no_tlp_ortu').val('');
            },
            error: function (error) {
                console.error('Error adding person:', error);
            }
        });
    });
</script>
