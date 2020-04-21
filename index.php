<?php
session_start();
$loginerror="";
$formemail=$formpass=" ";
include('includes/functions.php');
if(isset($_POST['login'])){
    $formemail=validateFormData($_POST['email']);
    $formpass=validateFormData($_POST['password']);

include('includes/connection.php');
$query="SELECT * FROM USERS ";
$result=mysqli_query($conn,$query);

if(mysqli_num_rows($result)>0){
    while($row=mysqli_fetch_assoc($result))
    {
        $name=$row['name'];
        //$email=$row['email'];
        $pass=$row['password'];
    }

if(password_verify($formpass,$pass)){

    $_SESSION['user']=$name;
    header("Location: clients.php");

}
else{
    $loginerror="<div class='alert alert-danger'>Wrong username/password</div>";
}
}
else{
    $loginerror="<div class='alert alert-danger'>Sorry!!there are no users in database<a class='close' data-dismiss='alert'>&times;</a></div>";
}
mysqli_close($conn);

}
//$formemail=$formpass=" ";

include('includes/header.php');
?>

<h1>Client Address Book</h1>
<p class="lead">Log in to your account.</p>
<?php echo $loginerror ?>
<form class="form-inline" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
    <div class="form-group">
        <label for="login-email" class="sr-only">Email</label>
        <input type="email" class="form-control" id="login-email"  name="email"  placeholder="email" value="<?php echo $formemail?>" required >
    </div>
    <div class="form-group">
        <label for="login-password" class="sr-only">Password</label>
        <input type="password" class="form-control" id="login-password" placeholder="password" name="password">
    </div>
    <button type="submit" class="btn btn-primary" name="login">Login</button>
</form>

<?php
include('includes/footer.php');
?>