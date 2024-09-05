<?php
require '../functions.php';
$id = $_GET['id'];

if (delete_comment($id) > 0) {
  echo "<script>
          alert('Data Successfully deleted!');
          document.location.href = 'index.php';
        </script>";
} else {
  echo "<script>
          alert('Data Failed to delete!');
          document.location.href = 'index.php';
        </script>";
}
