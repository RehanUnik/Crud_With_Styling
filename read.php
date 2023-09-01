<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "mydb2";
$id9 = $create9 = $name9 = $hobbie = $password9 = $salary9 = $date9 = $gender9 = $city9 = $country9 =  $image9 = $update9 = $state9 = "";
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
    die("Failed: " . mysqli_connect_error());
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $name9 = $row["first_name"];
            $password9 = $row["password1"];
            $date9 = $row["joining_date"];
            $salary9 = $row["salary"];
            $gender9 = $row["gender"];
            $city9 = $row["city"];
            $state9 = $row["states"];
            $country9 = $row["country"];
            $hobbie = $row["hobbies"];
            //$id = $_POST["id"];
        }
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User Details</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Id:</strong> <?php echo $id; ?></li>
                            <li class="list-group-item"><strong>Name:</strong> <?php echo $name9; ?></li>
                            <li class="list-group-item"><strong>Password:</strong> <?php echo $password9; ?></li>
                            <li class="list-group-item"><strong>Joining Date:</strong> <?php echo $date9; ?></li>
                            <li class="list-group-item"><strong>Salary:</strong> <?php echo $salary9; ?></li>
                            <li class="list-group-item"><strong>Gender:</strong> <?php echo $gender9; ?></li>
                            <li class="list-group-item"><strong>City:</strong> <?php echo $city9; ?></li>
                            <li class="list-group-item"><strong>State:</strong> <?php echo $state9; ?></li>
                            <li class="list-group-item"><strong>Country:</strong> <?php echo $country9; ?></li>
                            <li class="list-group-item"><strong>Hobbies:</strong> <?php echo $hobbie; ?></li>
                            <li class="list-group-item"><strong>Image:</strong>
                                <?php
                                $conn = mysqli_connect($servername, $username, $password, $db);
                                if (!$conn) {
                                    die("Failed: " . mysqli_connect_error());
                                }
                                if (isset($_GET['id'])) {
                                    $id = $_GET['id'];
                                    $query1 = "SELECT images FROM users WHERE id = '$id'";
                                    $result = mysqli_query($conn, $query1);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) { ?>
                                            <div><img src="upload/<?php echo $row['images']; ?>" alt="Sorry!" style="height: 50px;width: 50px;"></div>
                                <?php
                                        }
                                    }
                                }
                                mysqli_close($conn); ?>
                            </li>
                            <li class="list-group-item"><strong>Created On:</strong> <?php echo $create9; ?></li>
                            <li class="list-group-item"><strong>Updated On:</strong> <?php echo $update9; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>