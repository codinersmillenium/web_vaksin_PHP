<?php include 'config/database.php'; 
if (isset($_GET['id'])) {
  $id_vaksin=$_GET['id'];
  $data_vaksin= mysqli_query($db,"SELECT * FROM vaksinasi,kabupaten_kota,provinsi where vaksinasi.id_kab_kota=kabupaten_kota.id_kab_kota and provinsi.id_provinsi=kabupaten_kota.id_provinsi and id_vaksinasi=$id_vaksin");
  $result_vaksin= mysqli_fetch_assoc($data_vaksin);
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="assets/form_style.css">
</head>
<body>
<center>
  <h2>Form Input Data Vaksinasi</h2>
</center>

<div class="container">
  <form action="form_update_vaksin.php" method="POST">
    <?php if (isset($_GET['id'])) { ?>
       <div class="row">
    <div class="col-25">
      <label for="fname">Provinsi</label>
    </div>
    <div class="col-75">
      <input type="text" id="fname" value="<?= $result_vaksin['nama_provinsi'] ?>"  disabled>
      <input type="hidden" id="fname" name="province" value="<?= $result_vaksin['id_provinsi'] ?>" >
      <input type="hidden" id="fname" name="id_vaksin" value="<?= $result_vaksin['id_vaksinasi'] ?>" >
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="lname">Kabupaten/Kota</label>
    </div>
    <div class="col-75">
      <input type="text" id="lname"  value="<?= $result_vaksin['nama_kab_kota'] ?>"  disabled>
    </div>
  </div>
<?php } ?>
  <div class="row">
    <div class="col-25">
      <label for="fname">Jumlah Penduduk yang Divaksin</label>
    </div>
    <div class="col-75">
      <input type="text" id="fname" name="jml_pend" placeholder="Masukkan Jumlah Total Penduduk yang Divaksin.." required>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="lname">Jumlah Lansia yang Divaksin</label>
    </div>
    <div class="col-75">
      <input type="text" id="lname" name="jml_lansia_divaksin" placeholder="Masukkan Jumlah Lansia yang Divaksin.." required>
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
$id = $_POST['id_vaksin'];
$jml_penduduk = $_POST['jml_pend'];
$jml_lansia = $_POST['jml_lansia_divaksin'];
$insert = "UPDATE vaksinasi SET jml_total_vaksinasi=$jml_penduduk,jml_lansia_vaksinasi= $jml_lansia where id_vaksinasi=$id";  
mysqli_query($db,$insert);
echo "<script> window.alert('Succesfully Updated');
    window.location.href='index.php?idprovinsi=".$province."';</script>";
}
 ?>
</body>
</html>


