<!DOCTYPE html>
<html>

<head>
  <title>All Toys</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-between">

        <ul class="nav col-12 col-lg-auto me-lg-auto justify-content-center">
          <!-- <li><a href="/login" class="nav-link px-2 link-body-emphasis">Login</a></li> -->
          <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Если пользователь вошел -->
            <li><a href="/logout" class="nav-link px-2 link-body-emphasis">Logout</a></li>
          <?php else: ?>
            <!-- Если пользователь не вошел -->
            <li><a href="/login" class="nav-link px-2 link-body-emphasis">Login</a></li>
          <?php endif; ?>
          <li><a href="/cart" class="nav-link px-2 link-body-emphasis">Cart</a></li>
        </ul>

        <form class="input-group search-group" method="get" action="/search">
          <input type="text" name="query" class="form-control" placeholder="Search" aria-label="Search">
          <select name="category" class="form-select" aria-label="Category">
            <option value="0" selected>All Categories</option>
            <option value="1">Girls</option>
            <option value="2">Boys</option>
            <option value="3">Toddlers</option>
            <option value="4">Newborns</option>
          </select>
          <button class="btn btn-search" type="submit">
            <img src="/images/search-icon.png" alt="Search">
          </button>
        </form>
      </div>
    </div>
    </div>
  </header>
</body>

</html>