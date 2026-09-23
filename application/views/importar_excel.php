<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Importar Excel</title>
    </head>
    <body>
        <h2>Importar productos desde Excel</h2>
        <form action="<?= base_url('importar/excel') ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="archivo" accept=".xlsx" required>
            <br><br>
            <button type="submit">Subir e importar</button>
        </form>
    </body>
</html>