<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Confirmation de Vote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        /* .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        } */
    </style>
    <script>
        // Redirection après 5 secondes
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 10000);
    </script>
</head>
<body>
<div class="container">
    <h1>Nous sommes reconnaissants pour votre citoyenneté.</h1>
    <p>Votre vote a été bien pris en compte.</p>
    <p>À la prochaine fois!</p>
    <a href="index.php"></a>
    <!-- <a href="index.php" class="btn btn-primary">Retourner à l'accueil maintenant</a> -->
</div>
</body>
</html>
