<?php
require_once 'includes/functions.php';

// Get the 'id' from the URL
$id = $_GET['id'];

// Path to the JSON file
$dataFile = './data/user.json';

// Read JSON data
$users = readJSON($dataFile); // Assuming 'readJSON()' properly returns the parsed array

// Find the specific user
$user = null;
foreach ($users as $u) {
    if ($u['Id'] == $id) { // Match based on 'Id'
        $user = $u;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="container-fluid">

        <div class="offset-1 col-10">
            <a href="index.php" class="btn btn-danger mb-3">Back</a>
            <div class="card mb-3">
                <img src="<?php echo $user['image']; ?>" class="" style="height: 400px;" width="400px">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $user['MMName']; ?></h5>
                    <?php if (isset($user['EngName'])): ?>
                        <small class="card-text mb-3">English Name : <?php echo $user['EngName']; ?></small><br>
                    <?php endif; ?>
                    <p class="mt-2">အကြောင်းအရာ</p>
                    <p class="card-text"><small class="text-body-secondary"></small><?php echo $user['Detail']; ?></p>
                    <p class="card-text">
                        <small class="text-danger">
                            <?= $user['IsDanger'] == 'Yes' ? 'အန္တာရယ် ရှိသည်' : 'အန္တာရယ် မရှိပါ'; ?>
                        </small>
                    </p>
                    <p class="card-text">
                        <small class="text-danger">
                            <?= $user['IsPoison'] == 'Yes' ? 'အဆိပ် ပါသည်' : 'အဆိပ် မပါသည်'; ?>
                        </small>
                    </p>
                </div>
            </div>

        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>