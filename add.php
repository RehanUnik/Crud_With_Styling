<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Employee Detail</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="sweetalert2.min.js"></script>
  <link rel="stylesheet" href="sweetalert2.min.css">
  <script src="sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <div class="table-responsive">

    <div class="container mt-5">
      <div class="d-flex justify-content-between">
        <h2>Employee Details</h2>
        <button type="button" class="btn btn-light" onclick="redirectToForm1()" title='Add Employee'><b>+Add Employee</b></button>
      </div>
    </div>
    <table class="table table-striped">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>NAME</th>
          <th>PASSWORD</th>
          <th>JOINING DATE</th>
          <th>SALARY</th>
          <th>GENDER</th>
          <th>CITY</th>
          <th>STATE</th>
          <th>COUNTRY</th>
          <th>HOBBIE</th>
          <th>IMAGE</th>
          <th>CREATED ON</th>
          <th>UPDATED ON</th>
          <th>ACTION</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $servername = "localhost";
        $username = "root";
        $password1 = "";
        $db = "mydb2";
        $d = "";

        $conn = mysqli_connect($servername, $username, $password1, $db);
        if (!$conn) {
          die("Failed To Connect: " . mysqli_connect_error());
        }

        $sql2 = "SELECT * FROM  users";
        $res = mysqli_query($conn, $sql2);
        $sno = 0;
        if (mysqli_num_rows($res) > 0) {

          while ($row1 = mysqli_fetch_array($res)) {
            $sno = $sno + 1;
            echo "<tr>" . "<td>" . $row1["id"] . "</td>" . "<td>" . $row1["first_name"] . "</td>" . "<td>" . $row1["password1"] . "</td>"
              . "<td>" . $row1["joining_date"] . "</td>" . "<td>" . $row1["salary"] . "</td>" .
              "<td>" . $row1["gender"] . "</td>" .
              "<td>" . $row1["city"] . "</td>" .
              "<td>" . $row1["states"] . "</td>" .
              "<td>" . $row1["country"] . "</td>" .
              "<td>" . $row1["hobbies"] . "</td>" .
              "<td><div><img src='upload/" . $row1['images'] . "' alt='Sorry!' style='height: 50px;width: 50px;'></div></td>" .
              "<td>" . $row1["created_at"] . "</td>" . "<td>" . $row1["updated_at"] . "</td>" . "<td> 
              <a href='read.php?id=" . $row1['id'] . "' class='btn btn-light' title='Read Data'>
                            <img src='r.png' alt='Read' style='height: 30px;'>
                        </a>
                        <a href='update.php?id=" . $row1['id'] . "' class='btn btn-light' title='Update Data'>
                            <img src='p.png' alt='Update' style='height: 30px;'>
                        </a>
                        <a href='#' class='btn btn-light' title='Delete Data' onclick='return hjk(" . $row1['id'] . ");'>
                        <img src='d.png' alt='Delete' style='height: 30px;'>
                    </a>
                </td>" .
              "</tr>";
          }
        }


        mysqli_close($conn);


        ?>

      </tbody>

    </table>
  </div>
  <script>
    function redirectToForm1() {
      console.log("this is ")
      window.location.href = "create.php";
    }

    function redirectToForm2() {
      console.log("this is ")
      window.location.href = "update.php";
    }

    function confirmDelete() {
      return confirm("Are you sure you want to delete this record?");
    }

    function hjk(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {

          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'

          )
          setTimeout(function() {
            window.location.href = 'delete.php?id=' + encodeURIComponent(id);
          }, 1000);
        }
      })
      return false;
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</body>

</html>