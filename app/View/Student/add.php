<h2>Tambah Data Mahasiswa</h2>
<?php if (isset($model['error'])) { ?>
     <div class="error"><?= $model['error'] ?></div>
<?php } ?>
<form id="form_mahasiswa" action="/students/add" method="POST">
     <fieldset>
          <legend>Mahasiswa Baru</legend>
          <p>
               <label for="nim">NIM : </label>
               <input type="text" name="nim" id="nim" value="<?= $_POST['nim'] ?? "" ?>" placeholder="Contoh: 12345678">
               (8 digit angka)
          </p>
          <p>
               <label for="nama">Nama : </label>
               <input type="text" name="nama" id="nama" value="<?= $_POST['nama'] ?? "" ?>">
          </p>
          <p>
               <label for="tempat_lahir">Tempat Lahir : </label>
               <input type="text" name="tempat_lahir" id="tempat_lahir" value="<?= $_POST['tempat_lahir'] ?? "" ?>">
          </p>
          <p>
               <label for="tgl">Tanggal Lahir : </label>
               <select name="tgl" id="tgl">
                    <?php
                    for ($i = 1; $i <= 31; $i++) {
                         echo "<option value = $i >";
                         echo str_pad($i, 2, "0", STR_PAD_LEFT);
                         echo "</option>";
                    }
                    ?>
               </select>
               <select name="bln">
                    <?php
                    $arr_bln = [
                         "1" => "Januari",
                         "2" => "Februari",
                         "3" => "Maret",
                         "4" => "April",
                         "5" => "Mei",
                         "6" => "Juni",
                         "7" => "Juli",
                         "8" => "Agustus",
                         "9" => "September",
                         "10" => "Oktober",
                         "11" => "Nopember",
                         "12" => "Desember"
                    ];
                    foreach ($arr_bln as $key => $value) {
                         echo "<option value=\"{$key}\">{$value}</option>";
                    }
                    ?>
               </select>
               <select name="thn">
                    <?php
                    for ($i = 1990; $i <= 2022; $i++) {
                         echo "<option value = $i>$i</option>";
                    }
                    ?>
               </select>
          </p>
          <p>
               <label for="fakultas">Fakultas : </label>
               <select name="fakultas" id="fakultas">
                    <option value="Kedokteran">Kedokteran </option>
                    <option value="FMIPA">FMIPA</option>
                    <option value="Ekonomi">Ekonomi</option>
                    <option value="Teknik">Teknik</option>
                    <option value="Sastra">Sastra</option>
                    <option value="FASILKOM">FASILKOM</option>
               </select>
          </p>
          <p>
               <label for="jurusan">Jurusan : </label>
               <input type="text" name="jurusan" id="jurusan" value="<?= $_POST['jurusan'] ?? "" ?>">
          </p>
          <p>
               <label for="ipk">IPK : </label>
               <input type="text" name="ipk" id="ipk" value="<?= $_POST['ipk'] ?? "" ?>" placeholder="Contoh: 2.75">
               (angka desimal dipisah dengan karakter titik ".")
          </p>

     </fieldset>
     <br>
     <p>
          <input type="submit" name="submit" value="Tambah Data">
     </p>
</form>

<div id="footer">
     Copyright © <?php echo date("Y"); ?> Iqbal
</div>