<?php
require_once './config/db.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>product management</title>
</head>
<body>
    <?php
    if(isset($_GET['page_layout'])) {
        switch ($_GET['page_layout']) {
            case 'danhsach':
                require_once 'product/list.php';
                break;
            case 'them':
                require_once 'product/add.php';
                break;
            case 'sua':
                require_once 'product/edit.php';
                break;
            case 'xoa':
                require_once 'product/delete.php';
                break;        
            default:
                require_once 'product/list.php';
                break;
        }
    }else{
        require_once './product/list.php';
    }
    ?>
</body>
</html>