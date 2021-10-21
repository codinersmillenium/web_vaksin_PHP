<?php include 'config/database.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
        <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<style type="text/css">
  .button{
    float: right;
    margin-bottom: 20px;
    margin-left: 10px;
    color: white;
  }
  .dropdwon{
    margin-bottom: 20px;
    margin-left: 10px;
  }
</style>
<body>
  <center><h1>Tabel Informasi Vaksinasi</h1></center>
  <h2>Keterangan:</h2>
  <h4>PPKM Level 1: Hijau</h4>
  <h4>PPKM Level 2: Kuning</h4>
  <h4>PPKM Level 3: Merah</h4>
  <a href="form_kab_kota.php"><button class="button" style="background-color:red;">Input Data Kabupaten</button></a>
  <a href="form_vaksin.php"><button class="button" style="background-color: green;">Input Data Vaksin</button></a>
  <label>Pilih Provinsi</label>
    <?php 
    $country= mysqli_query($db,"SELECT * FROM provinsi");
     ?>
   <select class="dropdwon" id="country" name="country" onchange="javascript:handleSelect(this)">
    <option>Pilih Provinsi</option>
    <option value="All">All</option>
    <?php while ($row_country = mysqli_fetch_array($country)) {
      $name_prov=$row_country['nama_provinsi'];
     ?>
        <option value="<?= $row_country['id_provinsi'] ?>"><?= $row_country['nama_provinsi'] ?></option>
    <?php } ?>
  </select>
  <?php if (isset($_GET['idprovinsi'])) {
    $country_name= mysqli_query($db,"SELECT * FROM provinsi where id_provinsi=".$_GET['idprovinsi']);
    if ($_GET['idprovinsi']=="All") {
     echo "<p>Provinsi: All Province</p>";
    }else{
      while ($name_prov = mysqli_fetch_array($country_name)){
        echo "<p>Provinsi: ".$name_prov['nama_provinsi']."</p>";
      }
    }  
  } ?>
  <table cellspacing='0'>
    <thead>
      <tr>
        <th>No</th>
        <th>Kabupaten/Kota</th>
        <th>Provinsi</th>
        <th>Jumlah Penduduk yang Divaksin</th>
        <th>Jumlah Lansia yang Divaksin</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $no=1;
      if (isset($_GET['idprovinsi'])) {
        if ($_GET['idprovinsi']=="All") {
        $sql="SELECT * FROM vaksinasi,provinsi,kabupaten_kota where vaksinasi.id_kab_kota=kabupaten_kota.id_kab_kota and kabupaten_kota.id_provinsi=provinsi.id_provinsi";
        $status_PPKM="SELECT * FROM kabupaten_kota";
        }else{
        $sql="SELECT * FROM vaksinasi,provinsi,kabupaten_kota where vaksinasi.id_kab_kota=kabupaten_kota.id_kab_kota and kabupaten_kota.id_provinsi=provinsi.id_provinsi and provinsi.id_provinsi=".$_GET['idprovinsi'];
        $status_PPKM="SELECT * FROM kabupaten_kota where id_provinsi=".$_GET['idprovinsi'];
      }
      }else{
        $sql="SELECT * FROM vaksinasi,provinsi,kabupaten_kota where vaksinasi.id_kab_kota=kabupaten_kota.id_kab_kota and kabupaten_kota.id_provinsi=provinsi.id_provinsi";
        $status_PPKM="SELECT * FROM kabupaten_kota";
      }
      
      $result=mysqli_query($db, $sql);
      $level=mysqli_query($db, $status_PPKM);
      $level_int = mysqli_fetch_assoc($level);
      $list_vaksin1=$level_int['jml_total_penduduk']*70/100;
      $list_vaksin1_lansia=$level_int['jml_lansia']*60/100;
      $list_vaksin2=$level_int['jml_total_penduduk']*50/100;
      $list_vaksin2_lansia=$level_int['jml_lansia']*40/100;
      $status= mysqli_num_rows($result);
      if ($status==0) {
        echo "<td colspan='6' style='text-align: center;'>Empty</td>";
      }else{
      while ($row = mysqli_fetch_array($result)) {
       ?>
      <tr>
        
        <?php if ($row['jml_total_vaksinasi']>$list_vaksin2 && $row['jml_lansia_vaksinasi']>$list_vaksin2_lansia) 
        {
          if ($row['jml_total_vaksinasi']>$list_vaksin1 && $row['jml_lansia_vaksinasi']>$list_vaksin1_lansia ){
         ?>
         <td style="background: green;color: white;"><?= $no++  ?></td>
        <td style="background: green;color: white;"><?= $row['nama_kab_kota']  ?></td>
        <td style="background: green;color: white;"><?= $row['nama_provinsi']  ?></td>
        <td style="background: green;color: white;"><?= $row['jml_total_vaksinasi']  ?></td>
        <td style="background: green;color: white;"><?= $row['jml_lansia_vaksinasi']  ?></td>
      <?php }else{ ?>
        <td style="background: yellow;color: black;"><?= $no++  ?></td>
        <td style="background: yellow;color: black;"><?= $row['nama_kab_kota']  ?></td>
        <td style="background: yellow;color: black;"><?= $row['nama_provinsi']  ?></td>
        <td style="background: yellow;color: black;"><?= $row['jml_total_vaksinasi']  ?></td>
        <td style="background: yellow;color: black;"><?= $row['jml_lansia_vaksinasi']  ?></td>
      <?php }}else{?>
        <td style="background: red;color: white;"><?= $no++  ?></td>
        <td style="background: red;color: white;"><?= $row['nama_kab_kota']  ?></td>
        <td style="background: red;color: white;"><?= $row['nama_provinsi']  ?></td>
        <td style="background: red;color: white;"><?= $row['jml_total_vaksinasi']  ?></td>
        <td style="background: red;color: white;"><?= $row['jml_lansia_vaksinasi']  ?></td>
      <?php } ?>
        <td><a href="form_update_vaksin.php?id=<?= $row['id_vaksinasi']  ?>"><button style="background:green;color:white;">Edit</button></a><a href="index.php?id_hapus=<?= $row['id_vaksinasi']  ?>"><button style="background:red;color:white;" onclick="confirm('Apakah kamu yakin menghapus data')">Hapus</button></a></td>
      </tr>
    <?php }}?>

    </tbody>
  </table>
  <?php
  if (isset($_GET['id_hapus'])) {
     $sql_del="DELETE from vaksinasi where id_vaksinasi=".$_GET['id_hapus'];
     mysqli_query($db,$sql_del);
     echo "<script> window.alert('Succesfully Deleted');
    window.location.href='index.php';</script>";
   } 
   ?>
  <script type="text/javascript">
  function handleSelect(elm)
  {
     window.location = "index.php?idprovinsi="+elm.value;
  }
</script>
</body>
</html>