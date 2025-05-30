<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mobile Shop - Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/vendor.css">
  <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f4f6f9;
    }

    .registration-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .registration-card {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      max-width: 900px;
      width: 100%;
    }

    .registration-image {
      object-fit: cover;
      height: 100%;
      width: 100%;
    }

    .registration-form {
      padding: 40px 30px;
    }

    .registration-title {
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 25px;
      text-align: center;
    }
  </style>
</head>

<body>

  <div class="container-fluid registration-container">
    <div class="row registration-card">


      <div class="col-12 col-lg-6 registration-form">
        <div class="registration-title text-center d-flex justify-content-center align-items-center">
          <a href="./index.html"><img src="./assets/images/main-logo.png" alt="" class="logo"></a>
        </div>
        <form action="../controller/sign_up_process.php" method="POST">
          <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email" autocomplete="off">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password</label>
            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password" autocomplete="off">
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label fw-bold">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required placeholder="Confirm your password" autocomplete="off">
          </div>
          <button type="submit" class="btn btn-dark w-100">Register</button>
          <div class="mt-3 text-center">
            <span class="small text-muted">Already have an account? <a href="./sign_in.php" class="text-decoration-none text-dark">Login</a></span>
          </div>
        </form>
      </div>

      <div class="col-lg-6 d-none d-lg-block">
        <img src="../assets/images/register_page_banner.webp" alt="Mobile Shop" class="registration-image">
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>