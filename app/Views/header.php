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
        <!-- <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
            <use xlink:href="#bootstrap"></use>
          </svg>
        </a> -->

        <ul class="nav col-12 col-lg-auto me-lg-auto justify-content-center">
          <li><a href="/admin" class="nav-link px-2 link-body-emphasis">Login</a></li>
          <li><a href="#" class="nav-link px-2 link-body-emphasis">Customers</a></li>
          <li><a href="#" class="nav-link px-2 link-body-emphasis">Products</a></li>
        </ul>

        <form class="input-group search-group" method="get" action="/search">
          <input type="text" name="query" class="form-control" placeholder="Search" aria-label="Search">
          <select name="category" class="form-select" aria-label="Category">
            <option value="" selected>All Categories</option>
            <option value="0">Girls</option>
            <option value="1">Boys</option>
            <option value="2">Toddlers</option>
            <option value="3">Newborns</option>
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