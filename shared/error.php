<?php
include "header.php";
include_once '../characters/content/utility.php';
?>


<div class="alert alert-danger container text-center mt-4" role="alert">
    <?php print htmlspecialchars($_GET["msg"]); ?>
</div>

<?php
include "footer.php"; ?>