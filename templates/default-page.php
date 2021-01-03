<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Budget Planner</title>

  <!-- Bootstrap -->
  <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
  
<style>
  body { padding-top: 70px; }
</style>

</head>
<body>

  <!-- Navigation bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">Budget Planner</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <?= $menu ?>
        <span class="navbar-text">
          <?= $ownerDetails ? "Hello " . $ownerDetails->getFirstName() : "" ?>
        </span>
      </div>
    </div>
  </nav>
  
  <div class="container" role="main">
    <div class="row">
      <div class="col-sm-12">

        <?php if(@is_string($flash['success'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $flash['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <?php if(@is_string($flash['warning'])): ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= $flash['warning'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <?php if(@is_string($flash['error'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $flash['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <?php if(@is_array($flash['success'])): ?>
          <?php foreach ($flash['success'] as $message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?= $message ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
        <?php if(@is_array($flash['warning'])): ?>
          <?php foreach ($flash['warning'] as $message): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <?= $message ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
        <?php if(@is_array($flash['error'])): ?>
          <?php foreach ($flash['error'] as $message): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?= $message ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

      <?= $content ?>

      </div>
    </div>

    
  </div>

</body>

 </html>