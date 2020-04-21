<?php
session_start();
if(!$_SESSION['user']){
    header('Location:index.php');
}
include('includes/connection.php');
include('includes/functions.php');
$error=$nerror=$perror=$aerror=$eerror="";
$name=$phone=$email=$address=$notes=$company="";
if(isset($_POST['add'])){

    if(!$_POST['clientName']){
        $nerror="Please enter name!!";
    }
    else{
        $name=validateFormData($_POST['clientName']);
    }
    if(!$_POST['clientEmail']){
        $eerror="Please enter email!!";
    }
    else{
        $email=validateFormData($_POST['clientEmail']);
    }

    if(!$_POST['clientPhone']){
        $perror="Please enter phone number!!";
    }
    else{
        $phone=validateFormData($_POST['clientPhone']);
    }
    if(!$_POST['clientAddress']){
        $aerror="Please enter address!!";
    }
    else{
        $address=validateFormData($_POST['clientAddress']);
    }
    $company=validateFormData($_POST['clientCompany']);
    $notes=validateFormData($_POST['clientNotes']);
    if($name&&$email&&$phone&&$address){
$query="INSERT INTO client(id,name,email,phone,address,company,notes,date_time)
         VALUES(NULL,'$name','$email','$phone','$address','$company','$notes',CURRENT_TIMESTAMP)"; 
        
        if(mysqli_query($conn,$query))
        {
            header("Location:clients.php?alert=success");
        }
    }
    }
include('includes/header.php');
?>

<h1>Add Client</h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="row">
    <div class="form-group col-sm-6">
     <!--   <small class="text-danger"><?php// echo $nerror ?></small>-->
        <label for="client-name">Name *</label>
        <small class="text-danger"><?php echo $nerror ?></small>
        <input type="text" class="form-control input-lg" id="client-name" name="clientName" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-email">Email *</label>
        <small class="text-danger"><?php echo $eerror ?></small>
        <input type="email" class="form-control input-lg" id="client-email" name="clientEmail" value="" required>
    </div>
    <div class="form-group col-sm-6">
        <label for="client-phone">Phone *</label>
        <small class="text-danger"><?php echo $perror ?></small>
        <input type="text" class="form-control input-lg" id="client-phone" name="clientPhone" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-address">Address *</label>
        <small class="text-danger"><?php echo $aerror ?></small>
        <input type="text" class="form-control input-lg" id="client-address" name="clientAddress" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Company</label>
        <input type="text" class="form-control input-lg" id="client-company" name="clientCompany" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="clientNotes"></textarea>
    </div>
    <div class="col-sm-12">
            <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="add">Add Client</button>
    </div>
</form>

<?php
include('includes/footer.php');
?>