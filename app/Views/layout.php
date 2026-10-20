<!DOCTYPE html>
<html lang="pt-PT" data-bs-theme="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF -->
    <meta name="csrf-name-key" content="<?php echo $csrfNameKey ?? '' ?>">
    <meta name="csrf-value-key" content="<?php echo $csrfValueKey ?? '' ?>">
    <meta name="csrf-name" content="<?php echo $csrfName ?? '' ?>">
    <meta name="csrf-value" content="<?php echo $csrfValue ?? '' ?>">

    <title>Agenda de Contactos</title>

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">

    <script src="/assets/js/jquery.min.js"></script>
    <script type="module" src="/assets/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/agenda/index">Agenda</a>
        </div>
    </nav>

    <div class="container">
        <?php echo $content ?? '' ?>
    </div>

    <?php echo $scripts ?? '' ?>
</body>
</html>