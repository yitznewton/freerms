<?php if (!$database->isNew()): ?>
<div class="user-url">
  User URL:
  <?php echo link_to(
    public_path('/database/' . $database->getId(), true),
    public_path('/database/' . $database->getId(), true)) ?> 
</div>
<?php endif; ?>

