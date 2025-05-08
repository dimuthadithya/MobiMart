<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mobile Shop - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/vendor.css">
  <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f4f6f9;
    }

    .login-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-card {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      max-width: 900px;
      width: 100%;
    }

    .login-image {
      object-fit: cover;
      height: 100%;
      width: 100%;
    }

    .login-form {
      padding: 40px 30px;
    }

    .login-title {
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 25px;
      text-align: center;
    }
  </style>
</head>

<body>

  <div class="container-fluid login-container">
    <div class="row login-card">


      <div class="col-lg-6 d-none d-lg-block">
        <img src="../assets/images/login_banner.webp" alt="Mobile Shop" class="login-image">
      </div>


      <div class="col-12 col-lg-6 login-form">
        <div class="login-title text-center d-flex justify-content-center align-items-center">
          <a href="./index.html"><img src="./assets/images/main-logo.png" alt="" class="logo"></a>
        </div>
        <form action="../controller/sign_in_process.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label fw-bold">Email</label>
            <input type="text" class="form-control" id="username" name="email" required placeholder="Enter your email" autocomplete="off">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password</label>
            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password" autocomplete="off">
          </div>
          <button type="submit" class="btn btn-dark w-100">Login</button>
          <div class="mt-3 text-center">
            <span class="small text-muted">Don’t have an account? <a href="./sign_up.php" class="text-decoration-none text-dark">Register</a></span>
          </div>
        </form>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>