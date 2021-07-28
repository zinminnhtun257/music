<?php require_once "core/auth.php"?>
<?php include "template/header.php"?>
<h4>This is Dashboard Page</h4>

<?php
echo "<pre>";
print_r($_SESSION)
?>
<?php include "template/footer.php"?>
<script src="<?php echo $url; ?>/assets/js/app.js"></script>
