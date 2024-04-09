
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/customerbill.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<title>Feedback</title>
</head>
<body>
<div class="container">
    <h1>Feedback Details</h1>
    <table>
        <thead>
            <tr>
                <th>Customer Id</th>
                <th>Name</th>
                <th>Phone No</th>
                <th>vist</th>
                <th>Recommend</th>
                <th>Feedback</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once "Connection.php";
            $sql = "SELECT * FROM `feedback`";
            $result = mysqli_query($connection, $sql);

            // Check if there are results
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['Customer_Id']; ?></td>
                        <td><?php echo $row['Name']; ?></td>
                        <td><?php echo $row['Phone_No']; ?></td>
                        <td><?php echo $row['vist']; ?></td>
                        <td><?php echo $row['recommend']; ?></td>
                        <td><?php echo $row['Feedback']; ?></td>
                    </tr>
                    <?php
                }
                ?>
                <?php
            }
            ?>
        </tbody>
    </table>
 
</div>


</body>
</html>
