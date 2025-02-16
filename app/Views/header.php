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
        <img src="/images/icon1.jpg" alt="mdo" width="50" height="50" class="rounded-circle me-4 p-0 mb-0">
        <ul class="nav col-12 col-lg-auto me-lg-auto justify-content-center">
          <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Если пользователь вошел -->
            <li><button type="button" class="btn btn-header me-2"><a href="/logout" class="link-light link-underline-opacity-0">Logout</a></button></li>
          <?php else: ?>
            <!-- Если пользователь не вошел -->
            <li><button type="button" class="btn btn-header me-2"><a href="/login" class="link-light link-underline-opacity-0">Login</a></button></li>
          <?php endif; ?>          
          <li><button type="button" class="btn btn-header me-2"><a href="/cart" class="link-light link-underline-opacity-0">Cart</a></button></li>
          <li><button type="button" class="btn btn-header me-2"><a href="" class="link-light link-underline-opacity-0">1</a></button></li>
          <li><button type="button" class="btn btn-header me-2"><a href="" class="link-light link-underline-opacity-0">2</a></button></li>
          <li><button type="button" class="btn btn-header me-2"><a href="" class="link-light link-underline-opacity-0">3</a></button></li>          
          <li><button type="button" class="btn btn-header me-2"><a href="" class="link-light link-underline-opacity-0">4</a></button></li>
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