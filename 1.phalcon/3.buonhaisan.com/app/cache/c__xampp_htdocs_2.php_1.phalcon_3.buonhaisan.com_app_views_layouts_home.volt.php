<!doctype html>
<html amp lang="en">

  <?= $this->partial('partials/head') ?>

  <body>
    <?= $this->partial('partials/header') ?>
    <?= $this->getContent() ?>
    
    <?= $this->partial('partials/footer') ?>
    
  </body>

</html>