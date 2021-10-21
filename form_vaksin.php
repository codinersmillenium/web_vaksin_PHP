<?php include 'config/database.php'; 
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
  <form action="form_vaksin.php" method="POST">
      <div class="row">
    <div class="col-25">
    <label for="country">Pilih Provinsi</label>
    </div>
    <div class="col-75">
     <?php 
    $province= mysqli_query($db,"SELECT * FROM provinsi");
     ?>
   <select id="province" name="province" onchange="javascript:handleSelect(this)">
    <?php 
    if (isset($_GET['idprovinsi'])) {
          $id=$_GET['idprovinsi'];
          $province_id= mysqli_query($db,"SELECT * FROM provinsi where id_provinsi=$id");
          while ($row_province_id = mysqli_fetch_array($province_id)) {
      ?>
      <option value="<?= $row_province_id['id_provinsi'] ?>"><?= $row_province_id['nama_provinsi'] ?></option>
      <?php 
    }}
    while ($row_province = mysqli_fetch_array($province)) {
     ?>
        <option value="<?= $row_province['id_provinsi'] ?>"><?= $row_province['nama_provinsi'] ?></option>
    <?php } ?>
      </select>
    </div>
  </div>
       <div class="row">
    <div class="col-25">
  <label for="country">Pilih Kabupaten/Kota</label>
    </div>
    <div class="col-75">
       <?php
       if (isset($_GET['idprovinsi'])) {
          $country= mysqli_query($db,"SELECT * FROM kabupaten_kota where id_provinsi=".$_GET['idprovinsi']);
          $row_country= mysqli_num_rows($country);
        } 
     ?>
   <select id="country" name="country" required>
    <?php 
    if (isset($_GET['idprovinsi'])) {
      if ($row_country==0) {
      echo "<option value='' disabled >Data Kosong</option>";  
      }else{
    while ($row_country = mysqli_fetch_array($country)) {
     ?>
        <option value="<?= $row_country['id_kab_kota'] ?>"><?= $row_country['nama_kab_kota'] ?></option>
    <?php }}}
    else{
      echo "<option value='' disabled >Pilih Provinsi</option>";
    } ?>      
      </select>
    </div>
  </div>
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
$country = $_POST['country'];
$jml_penduduk = $_POST['jml_pend'];
$jml_lansia = $_POST['jml_lansia_divaksin']; 
$insert = "INSERT INTO vaksinasi(id_kab_kota,jml_total_vaksinasi,jml_lansia_vaksinasi) values ($country,$jml_penduduk,$jml_lansia)";
mysqli_query($db,$insert);
echo "<script> window.alert('Succesfully Updated');
    window.location.href='index.php?idprovinsi=".$province."';</script>";
}
 ?>
 <script type="text/javascript">
  function handleSelect(elm)
  {
     window.location = "form_vaksin.php?idprovinsi="+elm.value;
  }
</script>
</body>
</html>


