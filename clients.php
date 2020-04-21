<?php
session_start();
$error=$alert="";
if(!$_SESSION['user']){
    header('Location:index.php');
}
include('includes/connection.php');
$query="SELECT * FROM client";
$result=mysqli_query($conn,$query);
if(!mysqli_num_rows($result)){
   $error="<div class='alert alert-danger'>You dont have any client!!!!</div>";
}
if(isset($_GET['alert'])){
    if($_GET['alert']=='success')
    $alert="<div class='alert alert-success'>New client added to the database!!<a class='close' data-dismiss='alert'>&times;</a></div>";
    else if($_GET['alert']=='updatesuccess')
    {
        $alert="<div class='alert alert-success'>record is updated successfully!!<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
    else if($_GET['alert']=='delete')
    {
        $alert="<div class='alert alert-success'>record is deleted successfully!!<a class='close' data-dismiss='alert'>&times;</a></div>";
    }
}

include('includes/header.php');
?>


<h1>Client Address Book</h1>
 <?php echo $error;
       echo $alert;
 ?>

<table class="table table-striped table-bordered">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Company</th>
        <th>Notes</th>
        <th>Edit</th>
    </tr>
    <?php
        while($row=mysqli_fetch_assoc($result))
        {
            $name=$row['name'];
            $email=$row['email'];
            $phone=$row['phone'];
            $address=$row['address'];
            $comp=$row['company'];
            $notes=$row['notes'];

            echo "<tr><td>".$name."</td><td>".$email."</td><td>".$phone."</td><td>".$address."</td><td>".$comp."</td><td>".$notes."</td>";
             echo "<td><a href='edit.php?id= ".$row['id']." ' type='button' class='btn btn-default btn-primary btn-sm'><span class='glyphicon glyphicon-edit'></span></a></td>";
             echo "</tr>";       
            }    

    mysqli_close($conn);

    ?>
   
    <tr>
        <td colspan="7"><div class="text-center"><a href="add.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add Client</a></div></td>
    </tr>
</table>

<?php
include('includes/footer.php');
?>