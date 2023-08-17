<ul class="navbar-nav me-auto mb-2 mb-lg-0">
  <li class="nav-item">
    <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/categories') ? 'active' : '' ?>" href="/categories">Categories</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/transactions') ? 'active' : '' ?>" href="/transactions">Transactions</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/accounts') ? 'active' : '' ?>" href="/accounts">Accounts</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/tags') ? 'active' : '' ?>" href="/tags">Tags</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= str_contains($_SERVER['REQUEST_URI'], '/reporting') ? 'active' : '' ?>" href="/reporting">Reporting</a>
  </li>
</ul>