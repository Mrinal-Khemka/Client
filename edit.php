<?php
session_start();
$alert='';
//$name=$email=$phone=$address=$comapny=$address="";
if(!$_SESSION['user'])
{
    header('Location:index.php');
}
   $id = $_GET['id'];
   include('includes/connection.php');
   include('includes/functions.php'); 
    $query="SELECT * FROM client WHERE id='$id' ";
    $result=mysqli_query($conn,$query);

    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_assoc($result)){
            $name=$row['name'];
            $email=$row['email'];
            $phone=$row['phone'];
            $address=$row['address'];
            $company=$row['company'];
            $notes=$row['notes'];
        }

    }
    else{
        $error="<div class='alert alert-danger'>Nothing to show!</div>";
    }
   // $result="";
   if(isset($_POST['update']))
    {
        $name=$email=$phone=$notes=$company=$address=""; 
        $name=validateFormData($_POST['clientName']);

        $email=validateFormData($_POST['clientEmail']);
        $phone=validateFormData($_POST['clientPhone']);
        $address=validateFormData($_POST['clientAddress']);
        $company=validateFormData($_POST['clientCompany']);
       //echo $company;
        $notes=validateFormData($_POST['clientNotes']);
        $query="UPDATE client 
                 SET name= '$name',
                email='$email',
                phone='$phone',
                address='$address',
                company='$company', 
                notes='$notes' 
                WHERE id='$id' ";       
                if(mysqli_query($conn,$query))
                {
                   // echo $company;
                   // echo $notes;
                   header("Location:clients.php?alert=updatesuccess");
                }
                else{
                    echo "error updating record ". mysqli_error($conn); 
                }

    }
    if(isset($_POST['delete']))
    {
        $alert="<div class='alert alert-danger'><p>Are you sure you want to delete this client?</p><br>
                           <form action=' ".htmlspecialchars($_SERVER["PHP_SELF"])."?id=$id' method='post'>
                           <input type='submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Yes,delete!!'>
                           <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Opps!NO.</a>
                           </form>
                                      </div>";

    }
    if(isset($_POST['confirm-delete']))
    {
        $query=" DELETE FROM client WHERE id='$id' ";
        if(mysqli_query($conn,$query))
        {
            header('Location:clients.php?alert=delete');
        }
        else{
            echo "error occured while deleting" . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
include('includes/header.php');
?>

<h1>Edit Client</h1>
<?php echo $alert;?>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?id=<?php echo $id;?> " method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="client-name">Name</label>
        <input type="text" class="form-control input-lg" id="client-name" name="clientName" value="<?php echo $name ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-email">Email</label>
        <input type="text" class="form-control input-lg" id="client-email" name="clientEmail" value="<?php echo $email ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-phone">Phone</label>
        <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="<?php echo $phone ?>" >
    </div>
    <div class="form-group col-sm-6">
        <label for="client-address">Address</label>
        <input type="text" class="form-control input-lg" id="client-address" name="clientAddress" value="<?php echo $address ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Company</label>
        <input type="text" class="form-control input-lg" id="client-company" name="clientCompany" value="<?php echo $company ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes"><?php echo $notes ?></textarea>
    </div>
    <div class="col-sm-12">
        <hr>
        <button type="submit" class="btn btn-lg btn-danger pull-left" name="delete">Delete</button>
        <div class="pull-right">
            <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success" name="update">Update</button>
        </div>
    </div>
</form>

<?php
include('includes/footer.php');
?>