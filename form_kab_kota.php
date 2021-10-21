<?php include 'config/database.php'; ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="assets/form_style.css">
</head>
<body>
<center>
  <h2>Form Input Data Kabupaten/Kota</h2>
</center>

<div class="container">
  <form action="form_kab_kota.php" method="POST">
      <div class="row">
    <div class="col-25">
    <label for="province">Pilih Provinsi</label>
    </div>
    <div class="col-75">
      <select name="province">
        <?php 
    $country= mysqli_query($db,"SELECT * FROM provinsi");
     while ($row_country = mysqli_fetch_array($country)) {
     ?>
        <option value="<?= $row_country['id_provinsi'] ?>"><?= $row_country['nama_provinsi'] ?></option>
    <?php } ?>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="fname">Kabupaten Kota</label>
    </div>
    <div class="col-75">
      <input type="text"  name="kota" placeholder="Masukkan Nama Kabupaten Kota..">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="fname">Jumlah Penduduk</label>
    </div>
    <div class="col-75">
      <input type="text"  name="jml_pend" placeholder="Masukkan Jumlah Penduduk..">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="fname">Jumlah Penduduk Lansia</label>
    </div>
    <div class="col-75">
      <input type="text"  name="jml_lansia" placeholder="Masukkan Jumlah Penduduk Lansia..">
    </div>
  </div>
  <br>
  <div class="row">
    <input type="submit" value="Submit" name="submit">
  </div>
  </form>
</div>
<?php
if (isset($_POST['submit'])) {
$province = $_POST['province'];
$country = $_POST['kota'];
$jml_penduduk = $_POST['jml_pend'];
$jml_lansia = $_POST['jml_lansia'];
$insert = "INSERT INTO kabupaten_kota(id_provinsi,nama_kab_kota,jml_total_penduduk,jml_lansia) values ($province,'$country',$jml_penduduk,$jml_lansia)";
mysqli_query($db,$insert);
echo "<script> window.alert('Succesfully Updated');
    window.location.href='index.php';</script>";
}

 ?>
</body>
</html>


