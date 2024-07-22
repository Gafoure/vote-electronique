<?php
include 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $electionID = $conn->real_escape_string($_POST['electionID']);
    $StartDate = $conn->real_escape_string($_POST['StartDate']);
    $EndDate = $conn->real_escape_string($_POST['EndDate']);
    $tourID = $conn->real_escape_string($_POST['tourID']);

    $sql = "UPDATE tour SET electionID='$electionID', StartDate='$StartDate', EndDate='$EndDate' WHERE tourID=$tourID";

    if ($conn->query($sql) === TRUE) {
        $message = "Tour modifié avec succès.";
    } else {
        $message = "Erreur : " . $sql . "<br>" . $conn->error;
    }

    header('Location: tour.php');
    exit();
}

$tourID = $_GET['id'];
$sql = "SELECT * FROM tour WHERE tourID=$tourID";
$result = $conn->query($sql);
$tour = $result->fetch_assoc();

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier Tour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            width: 400px;
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .alert {
            margin-top: 20px;
        }
        .form-container {
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mt-5">Modifier Tour</h1>

    <?php if(isset($message)) { echo '<div class="alert alert-info">' . $message . '</div>'; } ?>

    <div class="form-container">
        <form action="" method="post" class="mt-3 mb-5">
            <input type="hidden" name="tourID" value="<?php echo $tour['tourID']; ?>">
            <div class="mb-3">
                <label for="electionID" class="form-label">Election ID:</label>
                <input type="number" class="form-control" id="electionID" name="electionID" value="<?php echo $tour['electionID']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="StartDate" class="form-label">Start Date:</label>
                <input type="date" class="form-control" id="StartDate" name="StartDate" value="<?php echo $tour['StartDate']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="EndDate" class="form-label">End Date:</label>
                <input type="date" class="form-control" id="EndDate" name="EndDate" value="<?php echo $tour['EndDate']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
