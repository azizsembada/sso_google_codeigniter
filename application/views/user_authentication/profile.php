<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Login with Google in CodeIgniter by CodexWorld</title>
<style type="text/css">
h1{
    color: #444;
    background-color: transparent;
    border-bottom: 1px solid #D0D0D0;
    font-size: 19px;
    font-weight: normal;
    margin: 0 0 14px 0;
    padding: 14px 15px 10px 15px;
}
.wrapper{
    width:450px;
    margin-left:auto;
    margin-right:auto;
}
.info-box{
	margin: 20px;
	background-color: #FFF0DD;
	padding: 10px;
	border: #F7CFCF solid 1px;
}
.info-box .image{text-align:center;}
</style>
</head>
<body>
<h1>CodeIgniter Sign In With Google Account</h1>
<div class="wrapper">
    <div class="info-box">
        <p class="image"><img src="<?php echo $image; ?>" width="300" height="220"/></p>
        <p><b>Name: </b><?php echo $name ?></p>
        <p><b>Email: </b><?php echo $email ?></p>
        <p><b>Logout from <a href="<?php echo base_url().'user_authentication/logout'; ?>">Google</a></b></p>
    </div>
</div>
</body>
</html>