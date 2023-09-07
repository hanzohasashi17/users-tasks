<?php
if (isset($_FILES['image'])) {
    $UniqName = uniqid("image_");
    $imgName = "upload/" . $UniqName . "." . substr($_FILES['image']['name'], -3);
    move_uploaded_file($_FILES['image']['tmp_name'], $imgName);
    try {
        $db = new PDO("mysql:host=localhost;dbname=crud", "root", "");
        $db->exec("INSERT INTO `images` (id, name) VALUES (null, '$imgName')");
    }
    catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    header("Location: task_18.php");
}

if (isset($_GET['delete'])) {
    $imgId = $_GET['delete'];

    try {
        $db = new PDO("mysql:host=localhost;dbname=crud", "root", "");
        $res = $db->query("SELECT * FROM `images` WHERE `id`='$imgId'");
        $res = $res->fetch();
        if (file_exists($res['name'])) {
            unlink($res['name']);
        }
        $db->exec("DELETE FROM `images` WHERE `id`='$imgId'");
    }
    catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    header("Location: task_18.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        Подготовительные задания к курсу
    </title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="css/statistics/chartist/chartist.css">
    <link rel="stylesheet" media="screen, print" href="css/miscellaneous/lightgallery/lightgallery.bundle.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-regular.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body class="mod-bg-1 mod-nav-link ">
<main id="js-page-content" role="main" class="page-content">
    <div class="row">
        <div class="col-md-6">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Задание
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="panel-content">
                            <div class="form-group">
                                <form action="" enctype="multipart/form-data" method="post">
                                    <div class="form-group">
                                        <label class="form-label" for="simpleinput">Image</label>
                                        <input type="file" id="simpleinput" class="form-control" name="image">
                                    </div>
                                    <button class="btn btn-success mt-3">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                        Загруженные картинки
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="panel-content image-gallery">
                            <div class="row">
                                <?php
                                try {
                                    $db = new PDO("mysql:host=localhost;dbname=crud", "root", "");
                                    $res = $db->query("SELECT * FROM `images`");
                                    foreach ($res as $row) {
                                        ?>
                                        <div class="col-md-3 image">
                                            <img src="<?= $row['name'] ?>">
                                            <a class="btn btn-danger" onclick="confirm('Вы уверены?');" href="task_18.php?delete=<?= $row['id'] ?>">Удалить</a>
                                        </div>
                                        <?php
                                    }
                                }
                                catch (PDOException $e) {
                                    echo "Connection failed: " . $e->getMessage();
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</main>


<script src="js/vendors.bundle.js"></script>
<script src="js/app.bundle.js"></script>
<script>
    // default list filter
    initApp.listFilter($('#js_default_list'), $('#js_default_list_filter'));
    // custom response message
    initApp.listFilter($('#js-list-msg'), $('#js-list-msg-filter'));
</script>
</body>
</html>
