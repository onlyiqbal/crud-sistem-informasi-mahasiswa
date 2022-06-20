<!DOCTYPE html>
<html lang="id">

<head>
     <meta charset="UTF-8">
     <title><?= $model['title'] ?? "Halaman Login" ?></title>
     <style>
          body {
               background-color: #F8F8F8;
          }

          div.container {
               width: 380px;
               padding: 10px 50px 80px;
               background-color: white;
               margin: 20px auto;
               box-shadow: 1px 0px 10px, -1px 0px 10px;
          }

          a {
               text-decoration: none;
               color: black;
          }

          h1,
          h3 {
               text-align: center;
               font-family: sans-serif;
          }

          p {
               margin: 0;
          }

          fieldset {
               padding: 20px;
               width: 215px;
               margin: auto;
          }

          input {
               margin-bottom: 10px;
          }

          input[type=text],
          input[type=password] {
               width: 115px;
          }

          input[type=submit] {
               float: right;
          }

          label {
               width: 80px;
               float: left;
               margin-right: 10px;
          }

          .error {
               background-color: #FFECEC;
               padding: 10px 15px;
               margin: 0 0 20px 0;
               border: 1px solid red;
               box-shadow: 1px 0px 3px red;
          }
     </style>
</head>

<body>
     <div class="container">
          <h1>Registrasi Admin Sistem</h1>
          <?php if (isset($model['error'])) { ?>
               <div class="error"><?= $model['error'] ?></div>
          <?php } ?>
          <form action="/users/register" method="POST">
               <fieldset>
                    <legend>Register</legend>
                    <p>
                         <label for="username">Id : </label>
                         <input type="text" name="id" id="username" value="<?= $_POST['id'] ?? "" ?>">
                    </p>
                    <p>
                         <label for="username">Username : </label>
                         <input type="text" name="username" id="username" value="<?= $_POST['username'] ?? "" ?>">
                    </p>
                    <p>
                         <label for="password">Password : </label>
                         <input type="password" name="password" id="password">
                    </p>
                    <p>
                         <button type="submit">Register</button>
                    </p>
               </fieldset>
          </form>
     </div>
</body>

</html>