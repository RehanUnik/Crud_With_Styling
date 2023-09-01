<?php
$servername = "localhost";
$username = "root";
$password1 = "";
$db = "mydb2";
$conn = mysqli_connect($servername, $username, $password1, $db);
if (!$conn) {
    die("Failed To Connect: " . mysqli_connect_error());
}
$id9 = $iderr9 = $name9 = $email9 = $password9 = $salary9 = $date9 = $gender9 = $city9 = $country9 =  $image9 = $h9 = $fr9 = $state9 = $sterr9 = "";
$nerr9 = $eerr9 = $perr9 = $serr9 = $derr9 = $gerr9 = $cerr9 = $coerr9 = $herr9 = $ierr9 = $ctime = $utime = $path = $image_size = "";
$hobbie = array("hobbie1", "hobbie2", "hobbie3");
$jsondata = $tmp_name = $error = $path_lc = $img_new = $img_upload = "";
// VALIDATION
if ($_SERVER['REQUEST_METHOD'] == "POST") {



    if (!preg_match('/^[A-Za-z\s\'-]+$/', $_POST["name"])) {
        $nerr9 = "Only alphabets and whitespace are allowed.";
    } else {
        $name9 = $_POST["name"];
    }


    $password9 = $_POST["password"];
    $cpassword9 = $_POST["cpassword"];
    if ($password9 === $cpassword9) {
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*]{8,}$/', $_POST["password"])) {
            $perr9 = "Password must be at least 8 characters long and contain at least one letter, one digit, and special characters.";
        }
    } else {
        $s9 = "confirm password is invalid";
    }
    if (!preg_match('/^\d+(\.\d{1,2})?$/', $_POST["salary"])) {
        $serr9 = "Enter valid values for salary!";
    } else {
        $salary9 = $_POST["salary"];
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["date"])) {
        $derr9 = "Enter date in Formate Of DD-MM-YYYY";
    } else {
        $date9 = $_POST["date"];
    }
    if (empty($_POST["gender"])) {
        $gerr9 = "Gender Required";
    } else {
        $gender9 = $_POST["gender"];
    }
    if (!preg_match('/^[A-Za-z]+$/', $_POST["city"])) {
        $cerr9 = "Please Select City";
    } else {
        $city9 = $_POST["city"];
    }
    if (!preg_match('/^[A-Za-z]+$/', $_POST["state"])) {
        $sterr9 = "Please Select State";
    } else {
        $state9 = $_POST["state"];
    }
    if (!preg_match('/^[A-Za-z]+$/', $_POST["country"])) {
        $coerr9 = "Please Enter Country Name";
    } else {
        $country9 = $_POST["country"];
    }
    if (isset($_POST["create"]) || isset($_POST["update"])) {
        if (!empty($_POST["hobbie"])) {
            $g = array();
            foreach ($_POST["hobbie"] as $h) {
                array_push($g, $h);
                $jsondata = json_encode($g);
            }
        } else {
            $herr9 = "Select One Check Box";
        }
    }
    if (empty($jsondata)) {
        $fr9 = "Select Atleast One Check Box";
    }


    if (!empty($_FILES["image"]["name"])) {
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        if (!in_array($imageFileType, array("jpg", "jpeg", "png", "gif"))) {
            $ierr9 = "Upload Valid Image (JPG, JPEG, PNG, GIF)";
        }
    } else {
        $ierr9 = "Please select an image";
    }

    // CREATE

    if (isset($_POST["create"]) && isset($_FILES["image"])) {
        if (!empty($_FILES["image"]["name"])) {
            $image9 = $_FILES['image']['name'];
            $image_size = $_FILES['image']['size'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $error = $_FILES['image']['error'];
            if ($error === 0) {
                if ($image_size > 125000) {
                    $you = "Image size is too large.";
                    header("Location: create.php?error=$you");
                    exit();
                } else {
                    $path = pathinfo($image9, PATHINFO_EXTENSION);
                    $path_lc = strtolower($path);
                    $img_new = uniqid("IMG-", true) . '.' . $path_lc;
                    $img_upload = 'upload/' . $img_new;
                    move_uploaded_file($tmp_name, $img_upload);
                }
            }
        }
        $checkQuery = "SELECT * FROM exp WHERE id = '$id9'";
        $checkResult = mysqli_query($conn, $checkQuery);
        move_uploaded_file($_FILES['image']['tmp_name'], $path);
        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            echo "Duplicate ID. Cannot insert.";
        } else {
            $insertQuery = "INSERT INTO users (id, first_name, password1, joining_date, salary, gender, city,states, country, hobbies, images) VALUES ('$id9', '$name9', '$password9', '$date9', '$salary9', '$gender9', '$city9', '$state9','$country9', '$jsondata', '$img_new')";

            if (empty($name9) || empty($password9) || empty($salary9) || empty($date9) || empty($gender9) || empty($city9) || empty($state9) || empty($country9) || empty($jsondata) || empty($img_new)) {
                echo '<div style="text-align: center; margin-top: 20px;">
          <p style="color: red; font-weight: bold;">Insert ALL Data!</p>
      </div>';
            } elseif (mysqli_query($conn, $insertQuery)) {
                header("Location: add.php");
            } else {
                echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
            }
        }
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .checkbox-error {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-3">Create Employee</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <p class="text-muted">Please fill in all the details.</p>
            </div>
        </div>
    </div>


    <div class="container mt-5 d-flex justify-content-center">

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="w-75" enctype="multipart/form-data">

            <div class="row">

                <div class="col-md-10">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control <?php if (!empty($nerr9)) echo 'is-invalid'; ?>" id="name" name="name">
                        <span class="error invalid-feedback"><?php echo $nerr9; ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control <?php if (!empty($perr9)) echo 'is-invalid'; ?>" id="password" name="password">
                        <span class="error invalid-feedback"><?php echo $perr9; ?></span>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="cpassword">Confirm Password:</label>
                        <input type="password" class="form-control <?php if (!empty($perr9)) echo 'is-invalid'; ?>" id="cpassword" name="cpassword">
                        <span class="invalid-feedback"><?php echo $perr9; ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="date">Joining Date:</label>
                        <input type="date" class="form-control <?php if (!empty($derr9)) echo 'is-invalid'; ?>" id="date" name="date">
                        <span class="invalid-feedback"><?php echo $derr9; ?></span>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="salary">Salary:</label>
                        <input type="number" class="form-control <?php if (!empty($serr9)) echo 'is-invalid'; ?>" id="salary" name="salary">
                        <span class="invalid-feedback"><?php echo $serr9; ?></span>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Gender:</label>
                        <div class=" d-flex flex-column ">
                            <div class="d-flex flex-row ">
                                <div class="ml-4">
                                    <input class="form-check-input mr-4 <?php if (!empty($gerr9)) echo 'is-invalid'; ?>" type="radio" name="gender" id="female" value="female">
                                    <label class="form-check-label mr-4" for="female">Female</label>
                                </div>
                                <div>
                                    <input class="form-check-input <?php if (!empty($gerr9)) echo 'is-invalid'; ?>" type="radio" name="gender" id="male" value="male">
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                            </div>
                            <div class="error invalid-feedback checkbox-error"><?php echo $gerr9; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Hobbies:</label>
                        <div class="d-flex flex-row <?php if (!empty($fr9)) echo 'is-invalid'; ?>">
                            <div class="">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="hobbie1" name="hobbie[]" value="Reading">
                                    <label class="form-check-label" for="hobbie1">Reading</label>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="form-check">
                                    <input class="form-check-input " type="checkbox" id="hobbie2" name="hobbie[]" value="Travelling">
                                    <label class="form-check-label" for="hobbie2">Travelling </label>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="form-check">
                                    <input class="form-check-input " type="checkbox" id="hobbie3" name="hobbie[]" value="Music">
                                    <label class="form-check-label" for="hobbie3">Music</label>
                                </div>
                            </div>
                        </div>
                        <span class="invalid-feedback"><?php echo $fr9; ?></span>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="city">City:</label>
                        <select name="city" id="city" class="form-control <?php if (!empty($cerr9)) echo 'is-invalid'; ?>">
                            <option value=" ">Choose!</option>
                            <option value="Ahmedabad">Ahmedabad</option>
                            <option value="Vadodara">Vadodara</option>
                            <option value="Surat">Surat</option>
                            <option value="Indor">Indor</option>
                            <option value="Mumbai">Mumbai</option>
                            <option value="Jaipur">Jaipur</option>
                            <option value="Amritsar">Amritsar</option>

                        </select>
                        <span class="invalid-feedback"><?php echo $cerr9; ?></span>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="state">State:</label>
                        <select name="state" id="state" class="form-control <?php if (!empty($sterr9)) echo 'is-invalid'; ?>">
                            <option value=" ">Choose!</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Rajasthan">Rajasthan</option>
                            <option value="MadhyaPradesh">MadhyaPradesh</option>
                            <option value="Punjab">Punjab</option>
                        </select>
                        <span class="invalid-feedback"><?php echo $sterr9; ?></span>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-5">
                    <div class="form-group">
                        <label for="country">Country:</label>
                        <input type="text" class="form-control <?php if (!empty($coerr9)) echo 'is-invalid'; ?>" id="country" name="country">
                        <span class="error invalid-feedback"><?php echo $coerr9; ?></span>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" class="form-control-file <?php if (!empty($ierr9)) echo 'is-invalid'; ?>" name="image">
                        <span class="invalid-feedback"><?php echo $ierr9; ?></span>
                    </div>
                </div>
            </div>


            <button type="submit" class="btn btn-primary" name="create">Submit</button>
            <button type="reset" class="btn btn-secondary">Reset</button>

        </form>
    </div>

    <!-- Add Bootstrap JS scripts here if needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>