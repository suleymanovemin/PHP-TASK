<?php 

include "dataBase.php";
$postion= $connect->prepare("SELECT * FROM postions");
$postion->execute();

$pRow = $postion->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"] === "POST"){
 $name = $_POST["name"];
 $surName = $_POST["surname"];
 $salary = $_POST["salary"];
 $position = $_POST["position"];
 $date = $_POST["date"];


 $conn = $connect->prepare("INSERT INTO personals (name,surname,salary,position,date) VALUES (?,?,?,?,?) ");

 $data = [$name,$surName,$salary,$position,$date];
 $conn->execute($data);

session_start();
$_SESSION["message"] = "Əlavə Olundu!";

header("Location:index.php");

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<form method="POST" class="container">
    <a href="index.php" class="btn btn-success mb-4 mt-4">Personal List</a>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Name</label>
    <input type="text" name="name" class="form-control"  aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Surname</label>
    <input type="text" name="surname" class="form-control" >
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Salary</label>
    <input type="text" name="salary" class="form-control" >
  </div>
  <select class="form-control mb-4" name="position">
    <?php 
    foreach($pRow as $row){
        ?>
        <option value="<?php echo $row["name"]?>"><?php echo $row["name"]?></option>
        <?php
    }
    ?>
    <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Date</label>
    <input  type="date" name="date" class="form-control mb-4" >
  </div>
  </select>
  <button class="btn btn-primary">Submit</button>
</form>



<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("submitBtn").addEventListener("click", function(event) {
        event.preventDefault(); 

        let name = document.querySelector("input[name='name']").value;
        let surname = document.querySelector("input[name='surname']").value;
        let salary = document.querySelector("input[name='salary']").value;
        let position = document.querySelector("select[name='position']").value;
        let date = document.querySelector("input[name='date']").value;

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "add.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert("Əlavə olundu");
            }
        };
        let data = "name=" + name + "&surname=" + surname + "&salary=" + salary + "&position=" + position + "&date=" + date;
        xhr.send(data);
    });
});
</script>

</body>
</html>