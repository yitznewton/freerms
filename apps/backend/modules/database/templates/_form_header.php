<div class="user-url">
  User URL:
  <?php echo link_to(
    public_path('/database/' . $database->getId(), true),
    public_path('/database/' . $database->getId(), true)) ?> 
</div>

