<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PERPUSTAKAAN</title>
  <link rel="stylesheet" href="../assets/css/style-login.css">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Lexend+Deca' rel='stylesheet'>
  <style>
    body {
      font-family: 'Lexend Deca', sans-serif;
    }
    .login-form {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 5vh;
      background-color: #f8f9fa;
    }
    .login {
      max-width: 400px;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-color: #fff;
    }
    .form-box {
      padding: 20px;
    }
    .form-value p {
      font-size: 24px;
      font-weight: 800;
      margin-bottom: 20px;
    }
    .inputbox label {
      margin-bottom: 5px;
      font-weight: 600;
    }
    .btn-login {
      margin-top: 20px;
    }
    .btn-login button {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 5px;
      background-color: #FF7D29;
      color: white;
      transition: background-color 0.3s;
    }
    .btn-login button:hover {
      background-color: #FFBF78;
    }
  </style>
</head>
<body>
  <section class="login-form">
    <div class="container login">
      <div class="form-box">
        <div class="form-value">
          <form action="proses_login.php" method="post">
            <p class="text-center">LOGIN</p>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="btn-login text-center">
              <button type="submit" name="submit" class="btn btn-login">Log in</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
