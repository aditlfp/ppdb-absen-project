<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<style type="text/css">
	/* Gaya untuk tabel */
	table {
	  width: 100%;
	  border-collapse: collapse;
	  margin-bottom: 20px;
	}

	/* Gaya untuk baris ganjil */
	table tr:nth-child(odd) {
	  background-color: #f2f2f2; /* Ganti dengan warna latar belakang yang diinginkan */
	}

	/* Gaya untuk baris genap */
	table tr:nth-child(even) {
	  background-color: #ffffff; /* Ganti dengan warna latar belakang yang diinginkan */
	}

	/* Gaya untuk sel di dalam tabel */
	table td, table th {
	  border: 1px solid #dddddd; /* Ganti dengan warna border yang diinginkan */
	  padding: 8px;
	  text-align: left;
	  font-family: Arial, sans-serif; /* Gunakan font Arial atau fallback ke sans-serif */
	  font-size: 12px; /* Ukuran font 12px */
	}

	/* Gaya untuk header kolom */
	table th {
	  background-color: #4CAF50; /* Ganti dengan warna latar belakang header yang diinginkan */
	  color: white;
	}


</style>
<body>
	<table>
		<thead>
			<tr>
				<th>#</th>
                 <th>Nama Lengkap</th>
                 <th>Kelas - Jurusan</th>
                 <th>Tlp</th>
                 <th>Alamat Lengkap</th>
                 <th>Org Tua / Wali</th>
                 <th>Tlp Org Tua</th>
			</tr>
		</thead>

		<tbody>
			<?php $no = 1 ?>
			@forelse($siswa as $arr)
				<tr>
					<td>{{ $no++ }}</td>
					<td>{{$arr->nama_lengkap}}</td>
	                 <td>{{$arr->kelas? $arr->kelas:'-'}} {{$arr->jurusan?$arr->jurusan->name:'-'}}-{{$arr->abjat?$arr->abjat:'-'}}</td>
	                 <td>{{$arr->no_tlp}}</td>
	                 <td>Des.{{$arr->desa}} / RT {{$arr->rt}}/ RW {{$arr->rw}}, Kel.{{$arr->kelurahan}}, Kec.{{$arr->kecamatan}}, Kota.{{$arr->kota}}</td>
	                 <td>{{$arr->nama_ortu}}</td>
	                 <td>{{$arr->no_tlp_ortu}}</td>
                 </tr>
			@empty
				<tr>
					<td colspan="7" style="text-align: center;"><span>~ Data Not Found Or Not Avaible ~</span></td>
				</tr>
			@endforelse
		</tbody>
	</table>
</body>
</html>



