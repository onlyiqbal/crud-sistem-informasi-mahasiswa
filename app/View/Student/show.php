<h2>Data Mahasiswa</h2>
<table border="1">
     <tr>
          <th>NIM</th>
          <th>Nama</th>
          <th>Tempat Lahir</th>
          <th>Tanggal Lahir</th>
          <th>Fakultas</th>
          <th>Jurusan</th>
          <th>IPK</th>
     </tr>
     <?php
     // $students = $model["students"];
     foreach ($model['students'] as $student) {
          echo "<tr>";
          echo "<td>$student[nim]</td>";
          echo "<td>$student[nama]</td>";
          echo "<td>$student[tempat_lahir]</td>";
          echo "<td>$student[tanggal_lahir]</td>";
          echo "<td>$student[fakultas]</td>";
          echo "<td>$student[jurusan]</td>";
          echo "<td>$student[ipk]</td>";
          echo "</tr>";
     }
     ?>
</table>
<div id="footer">
     Copyright © <?php echo date("Y"); ?> Iqbal
</div>