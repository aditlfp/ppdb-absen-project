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
                 <th>Kelas - Jurusan</th>
                 <th>Tidak Masuk</th>
			</tr>
		</thead>

		<tbody>
			<?php $no = 1 ?>
			@forelse($absen as $arr)
				<tr>
					<td>{{ $no++ }}</td>
	                 <td>{{$arr->kelas? $arr->kelas:'-'}} {{$arr->jurusan?$arr->jurusan->name:'-'}}-{{$arr->abjat?$arr->abjat:'-'}}</td>
	                 @php
					    $tidakMasukHtml = '';

					    if (is_string($arr->tidak_masuk)) {
					        try {
					            $tidakMasukArray = json_decode($arr->tidak_masuk, true);

					            if (is_array($tidakMasukArray)) {
					                foreach ($tidakMasukArray as $data) {
					                    $tidakMasukHtml .= "
					                        <div>
					                            Nama: {$data['nama']}, Keterangan: {$data['keterangan']}
					                        </div>";
					                }
					            } else {
					                $tidakMasukHtml = 'Invalid tidak_masuk data';
					                \Log::error('Invalid tidak_masuk data format:', $tidakMasukArray);
					            }
					        } catch (\Exception $error) {
					            $tidakMasukHtml = 'Error parsing tidak_masuk JSON';
					            \Log::error('Error parsing tidak_masuk JSON:', ['data' => $arr->tidak_masuk, 'error' => $error->getMessage()]);
					        }
					    } else {
					        $tidakMasukHtml = 'Invalid tidak_masuk data';
					        \Log::error('Invalid tidak_masuk data format:', ['data' => $arr->tidak_masuk]);
					    }
					@endphp
					<td>{!! $tidakMasukHtml !!}</td>

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



