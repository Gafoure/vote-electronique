<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote Municipal - Sélection de la Commune</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            background-size: cover;
            padding: 0;
            margin: 0;
        }
        .container {
            width: 500px;
            background-color: #fff;
            margin: 120px auto 20px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
        }
        .commune-buttons {
            list-style: none;
            padding: 0;
            margin-bottom: 40px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .commune-buttons a {
            display: block;
            padding: 15px;
            background-color: #0056b3;
            color: #fff;
            text-decoration: none;
            border-radius: 15px;
            transition: background-color 0.3s ease;
            text-align: center;
        }
        .commune-buttons a:hover {
            /*background-color: #0056b3;*/
            background-color: #FC5D5D;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5 text-center">Sélectionner une Commune</h1>
        <div class="commune-buttons text-center mt-3">
            <a href="Commune_I.php" class="btn btn-primary">Commune I</a>
            <a href="Commune_II.php" class="btn btn-primary">Commune II</a>
            <a href="Commune_III.php" class="btn btn-primary">Commune III</a>
            <a href="Commune_IV.php" class="btn btn-primary">Commune IV</a>
            <a href="Commune_V.php" class="btn btn-primary">Commune V</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>