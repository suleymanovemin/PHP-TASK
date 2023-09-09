<?php

include "dataBase.php";
$order = "DESC";
$search = "";
if(isset($_GET["order"])){
    if($_GET["order"] == "DESC"){
        $order = "DESC";
    }elseif($_GET["order"] == "ASC"){
        $order = "ASC";
    }
}
if(isset($_GET["search"])){
    $search = $_GET["search"];
}


$sql = "SELECT * FROM personals WHERE salary LIKE '$search%' ORDER BY salary $order";

$conn = $connect->prepare($sql);
$conn->execute();
$rows = $conn->fetchAll(PDO::FETCH_ASSOC);


$rows_json = json_encode($rows);
// print_r($rows);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>

    </style>
</head>
<body>
    <div class="container mt-4 mb-4">
        <a href="add.php" class="btn btn-warning">Add Personal</a>
    </div>
    <form method="GET" class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <input type="text" value="<?php if(isset($_GET['search'])){ echo $_GET['search'];} ?>" class="form-control" name="search" id="searchTerm" placeholder="Search by Name" >
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
                <ul id="autocomplete-list"></ul>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="order">Sort by Salary:</label>
                    <select class="form-control" name="order">
                        <option value="DESC" <?php if ($order === 'DESC') echo 'selected'; ?>>Descending</option>
                        <option value="ASC" <?php if ($order === 'ASC') echo 'selected'; ?>>Ascending</option>
                    </select>
                </div>
                <button class="btn btn-primary">Sort</button>
            </div>
        </div>
    </form>
    <table class="table container">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Position</th>
                <th scope="col">Salary</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($rows as $key => $row) {
            ?>
                <tr>
                    <th scope="row"><?php echo $key + 1 ?></th>
                    <td><?php echo $row["name"] ?></td>
                    <td><?php echo $row["surname"] ?></td>
                    <td><?php echo $row["position"] ?></td>
                    <td><?php echo $row["salary"] ?></td>
                    <td><?php echo $row["date"] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <script>
        const searchTermInput = document.getElementById('searchTerm');
        const autocompleteList = document.getElementById('autocomplete-list');
        let data = <?php echo $rows_json; ?>;

         searchTermInput.addEventListener("input", () => {
            autocompleteList.innerHTML = "";
            searchTermInput.value = searchTermInput.value.replace(/[^a-zA-Z]/g, "");
           let searchTerm = searchTermInput.value.toLowerCase();
           let filteredData = data.filter(item => item.name.toLowerCase().includes(searchTerm));
           console.log(filteredData);
           
           if(filteredData.length > 0){
            filteredData.map((a)=>{
                let li = document.createElement("li");
           let p = document.createElement("p");

           p.textContent = a.name;
           li.append(p);
           autocompleteList.append(li)
            })
           }else{
            autocompleteList.innerHTML = "";
           }
         });

    </script>
</body>
</html>
