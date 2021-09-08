<?php
//Connect Database
$server = "localhost";
$user = "root";
$pass = "";
$database = "arkademy";

$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_connect_error($koneksi));
//tombol simpan
if(isset($_POST['btnsimpan'])){
	//pengujian data di edit atau disimpan baru
	if($_GET['hal'] == "edit"){
		//data di edit
		$edit = mysqli_query($koneksi, "UPDATE produk SET nama_produk = '$_POST[tnama]',
										keterangan = '$_POST[tketerangan]',
										harga = '$_POST[tharga]',
										jumlah = '$_POST[tjumlah]'	
										WHERE id = '$_GET[id]'
										");
		if($edit){
			echo "<script>
			alert('Edit Data Sukses!');
			document.location='index.php';
			</script>";
		}
		else{
			echo "<script>
			alert('Edit Data Gagal!');
			document.location='index.php';
			</script>";
		}


	}
	else{
		//data disimpan baru
		$simpan = mysqli_query($koneksi, "INSERT INTO produk(nama_produk, keterangan, harga, jumlah)
										VALUES ('$_POST[tnama]', '$_POST[tketerangan]', '$_POST[tharga]', '$_POST[tjumlah]') 
										");
		if($simpan){
			echo "<script>
			alert('Simpan Data Sukses!');
			document.location='index.php';
			</script>";
		}
		else{
			echo "<script>
			alert('Simpan Data Gagal!');
			document.location='index.php';
			</script>";
		}
	}	
}
//Tombol Edit
if(isset($_GET['hal'])){
	if($_GET['hal'] == "edit"){
		$tampil = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = '$_GET[id]' ");
		$data = mysqli_fetch_array($tampil);
		if($data){
			//jika data ditemukan, ditampung dulu ke dalam variabel
			$vnama = $data['nama_produk'];
			$vketerangan = $data['keterangan'];
			$vharga = $data['harga'];
			$vjumlah = $data['jumlah'];
		}
	}
	else if($_GET['hal'] == "hapus"){
		$hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE id = '$_GET[id]' ");
		if($hapus){
			echo "<script>
			alert('Hapus Data Sukses!');
			document.location='index.php';
			</script>";
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Arkademy</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body>
<div class="container" style="padding-top: 40px;">
	<!--Awal card form bootstrap-->
	<div class="card">
		<div class="card header bg-primary text-white" style="text-align: center;" >
			Data Produk
		</div>
		<div class="card-body">
			<form method="post" action="">
				<div class="form-group">
					<label>Nama Produk</label>
					<input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama Produk" required>
				</div>
				<div class="form-group">
					<label>Keterangan Produk</label>
					<textarea class="form-control" name="tketerangan" placeholder="Input Keterangan Produk"><?=@$vketerangan?></textarea>
				</div>
				<div class="form-group">
					<label>Harga Produk</label>
					<input type="text" name="tharga" value="<?=@$vharga?>" class="form-control" placeholder="Input Harga Produk" required>
				</div>
				<div class="form-group">
					<label>Jumlah Produk Tersedia</label>
					<input type="text" name="tjumlah" value="<?=@$vjumlah?>" class="form-control" placeholder="Input Jumlah Produk" required>
				</div>

				<button type="submit" class="btn btn-success" name="btnsimpan">Simpan</button>
				<button type="reset" class="btn btn-danger" name="btnreset">Reset</button>
			</form>
	  	</div>
	</div>
	<!--Akhir card form bootstrap-->

	<!--Awal card tabel bootstrap-->
	<div class="card">
		<div class="card header bg-success text-white" style="text-align: center;" >
			Daftar Produk
		</div>
		<div class="card-body">
			<table class="table table-bordered table-striped">
				<tr>
					<th>Nomor</th>
					<th>Nama Produk</th>
					<th>Keterangan Produk</th>
					<th>Harga Produk</th>
					<th>Jumlah Produk Tersedia</th>
					<th>Aksi</th>
				</tr>
				<?php
				$tampil = mysqli_query($koneksi, "SELECT * FROM produk order by id asc");
				while ($data = mysqli_fetch_array($tampil)){
				?>
				<tr>
					<td><?= $data['id'] ?></td>
					<td><?= $data['nama_produk'] ?></td>
					<td><?= $data['keterangan'] ?></td>
					<td><?= $data['harga'] ?></td>
					<td><?= $data['jumlah'] ?></td>
					<td>
						<a href="index.php?hal=edit&id=<?=$data['id']?>" class="btn btn-warning">Edit</a>
						<a href="index.php?hal=hapus&id=<?=$data['id']?>" 
							onclick="return confirm('Hapus Data Ini?')" class="btn btn-danger">Hapus</a>
					</td>
				</tr>
				<?php } ?>
			</table>
	  	</div>
	</div>
	<!--Akhir card tabel bootstrap-->
</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>