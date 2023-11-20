<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url("/"); ?>/assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url("/"); ?>/assets/select2/dist/css/nice-select2.css">

    <link rel="stylesheet" href="<?= base_url("/"); ?>/assets/vendors/simple-datatables/style.css">

    <link rel="stylesheet" href="<?= base_url("/"); ?>/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?= base_url("/"); ?>/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url("/"); ?>/assets/css/app.css">
    <link rel="shortcut icon" href="<?= base_url("/"); ?>/assets/images/favicon.svg" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
    <style>
        #map {
            height: 400px;
            /* The height is 400 pixels */
            width: 100%;
            /* The width is the width of the web page */

        }
    </style>

</head>



<body>
    <div class="app">
        <?= $this->include('layouts/sidebar'); ?>
        <?= $this->include('layouts/default'); ?>

        <script src="<?= base_url("/"); ?>/assets/select2/dist/js/nice-select2.js"></script>

        <script src="<?= base_url("/"); ?>/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
        <script src="<?= base_url("/"); ?>/assets/js/bootstrap.bundle.min.js"></script>

        <script src="<?= base_url("/"); ?>/assets/vendors/simple-datatables/simple-datatables.js"></script>
        <script>
            // Simple Datatable
            let table1 = document.querySelector('#table1');
            let dataTable = new simpleDatatables.DataTable(table1);
        </script>

        <script src="<?= base_url("/"); ?>/assets/js/main.js"></script>
        <script async src="getenv('API_KEY')">
        </script>
</body>

</html>