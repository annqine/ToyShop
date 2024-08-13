<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4">
            <form method="POST" action="/login">
                <div class="form-group mb-3">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" class="form-control" required
                        style="border-color: pink;">
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" required
                        style="border-color: pink;">
                </div>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" style="background-color: red; color: white;"><?= $error ?></div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary w-100"
                    style="background-color: pink; border-color: pink;">Login</button>
                <p class="text-center mt-3">Don't have an account? <a href="/register" style="color: pink;">Register
                        here</a>.</p>
            </form>
        </div>
    </div>
</body>

</html>