<h2>Edit Data Mahasiswa</h2>
<?php if (isset($model['error'])) { ?>
     <div class="error"><?= $model['error'] ?></div>
<?php } ?>
<form id="form_mahasiswa" action="/students/update" method="post">
     <fieldset>
          <legend>Mahasiswa Baru</legend>
          <p>
               <label for="nim">NIM : </label>
               <input type="text" name="nim" id="nim" value="<?= $model['student']['nim'] ?? $_POST['nim'] ?>" readonly>
               (tidak bisa diubah di menu edit)
          </p>
          <p>
               <label for="nama">Nama : </label>
               <input type="text" name="nama" id="nama" value="<?= $model['student']['nama'] ?? $_POST['nama'] ?>">
          </p>
          <p>
               <label for="tempat_lahir">Tempat Lahir : </label>
               <input type="text" name="tempat_lahir" id="tempat_lahir" value="<?= $model['student']['tempat_lahir'] ?? $_POST['tempat_lahir'] ?>">
          </p>
          <p>
               <label for="tgl">Tanggal Lahir : </label>
               <select name="tgl" id="tgl">
                    <?php
                    for ($i = 1; $i <= 31; $i++) {
                         if ($i == ($model['student']['tgl'] ?? $_POST['tgl'])) {
                              echo "<option value = $i selected>";
                         } else {
                              echo "<option value = $i >";
                         }
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
                         if ($key == ($model['student']['bln'] ?? $_POST['bln'])) {
                              echo "<option value=\"{$key}\" selected>{$value}</option>";
                         } else {
                              echo "<option value=\"{$key}\">{$value}</option>";
                         }
                    }
                    ?>
               </select>
               <select name="thn">
                    <?php
                    for ($i = 1990; $i <= 2022; $i++) {
                         if ($i == ($model['student']['thn'] ?? $_POST['thn'])) {
                              echo "<option value = $i selected>";
                         } else {
                              echo "<option value = $i >";
                         }
                         echo "$i </option>";
                    }
                    ?>
               </select>
          </p>
          <p>
               <label for="fakultas">Fakultas : </label>
               <select name="fakultas" id="fakultas">
                    <?php
                    $fakultas = $model['student']['fakultas'] ?? $_POST['fakultas'];

                    $selected_kedokteran = "";
                    $selected_fmipa = "";
                    $selected_teknik = "";
                    $selected_ekonomi = "";
                    $selected_sastra = "";
                    $selected_fasilkom = "";

                    switch ($fakultas) {
                         case 'Kedokteran':
                              $selected_kedokteran = "selected";
                              break;
                         case 'FMIPA':
                              $selected_fmipa = "selected";
                              break;
                         case 'Teknik':
                              $selected_teknik = "selected";
                              break;
                         case 'Sastra':
                              $selected_sastra = "selected";
                              break;
                         case 'FMIPA':
                              $selected_fasilkom = "selected";
                              break;
                    }
                    ?>
                    <option value="Kedokteran" <?php echo $selected_kedokteran ?>>Kedokteran</option>
                    <option value="FMIPA" <?php echo $selected_fmipa ?>>FMIPA</option>
                    <option value="Ekonomi" <?php echo $selected_ekonomi ?>>Ekonomi</option>
                    <option value="Teknik" <?php echo $selected_teknik ?>>Teknik</option>
                    <option value="Sastra" <?php echo $selected_sastra ?>>Sastra</option>
                    <option value="FASILKOM" <?php echo $selected_fasilkom ?>>FASILKOM</option>
               </select>
          </p>
          <p>
               <label for="jurusan">Jurusan : </label>
               <input type="text" name="jurusan" id="jurusan" value="<?= $model['student']['jurusan'] ?? $_POST['jurusan'] ?>">
          </p>
          <p>
               <label for="ipk">IPK : </label>
               <input type="text" name="ipk" id="ipk" value="<?= $model['student']['ipk'] ?? $_POST['ipk'] ?>">
               (angka desimal dipisah dengan karakter titik ".")
          </p>

     </fieldset>
     <br>
     <p>
          <input type="submit" name="submit" value="Update Data">
     </p>
</form>

</div>