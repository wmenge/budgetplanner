<ul class="nav nav-tabs">
  <li class="nav-item">
  <a class="nav-link <?= @$type=='periods' ? 'active' : ''?>" aria-current="page" href="/reporting/periods">
    Monthly</a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= @$type=='expenses' ? 'active' : ''?>" aria-current="page" href="/reporting/expenses">Expenses</a>
  </li>
  <li class="nav-item">
  <a class="nav-link <?= @$type=='income' ? 'active' : ''?>" aria-current="page" href="/reporting/income">
    Income</a>
  </li>
</ul>
