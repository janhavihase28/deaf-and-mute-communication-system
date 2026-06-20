<?php

$conn = new mysqli("localhost","root","","connection_db");

if($conn->connect_error){
die("Database connection failed");
}

if(isset($_POST['username'])){

$username=$_POST['username'];
$password=$_POST['password'];
$action=$_POST['action'];

if($action=="signup"){

$check=$conn->query("SELECT * FROM users WHERE username='$username'");

if($check->num_rows>0){
echo "User already exists!";
}
else{
$conn->query("INSERT INTO users(username,password) VALUES('$username','$password')");
echo "signup_success";
}

exit();
}

if($action=="login"){

$result=$conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");

if($result->num_rows>0){
echo "login_success";
}
else{
echo "Wrong username or password!";
}

exit();
}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Communication Board Login</title>

<style>
body, html {margin:0;padding:0;height:100%;font-family:Arial,sans-serif;}
.video-bg{position:fixed;inset:0;min-width:100%;min-height:100%;z-index:-1;object-fit:cover;}
.login-container{
max-width:380px;margin:100px auto;background:rgba(255,255,255,.9);
padding:28px;border-radius:12px;box-shadow:0 5px 15px rgba(0,0,0,.3);text-align:center
}
.login-container input{width:90%;padding:12px;margin:10px 0;border-radius:8px;border:1px solid #aaa;font-size:16px}
button{padding:12px 20px;border:none;border-radius:8px;font-size:16px;cursor:pointer;margin:6px}
.login{background:#4CAF50;color:#fff}
.signup{background:#2196F3;color:#fff}
#msg{font-weight:600;margin-top:8px}
</style>
</head>

<body>

<video class="video-bg" autoplay muted loop>
<source src="bk.mp4" type="video/mp4">
</video>

<div class="login-container">

<h2>Communication Board</h2>
<h3 id="formTitle">Login</h3>

<input id="username" placeholder="Username">
<input id="password" type="password" placeholder="Password">

<div>
<button class="login" onclick="submitForm()">Login</button>
<button class="signup" onclick="toggleForm()">Create Account</button>
</div>

<p id="msg"></p>

</div>

<script>

let isSignup=false;

function toggleForm(){
isSignup=!isSignup;
formTitle.innerText=isSignup?"Create Account":"Login";
msg.innerText="";
}

function submitForm(){

let user=username.value.trim();
let pass=password.value.trim();

if(!user||!pass){
msg.style.color="red";
msg.innerText="Username & password required!";
return;
}

fetch("index.php",{
method:"POST",
headers:{
"Content-Type":"application/x-www-form-urlencoded"
},
body:"username="+user+"&password="+pass+"&action="+(isSignup?"signup":"login")
})
.then(res=>res.text())
.then(data=>{

if(data=="login_success"){
msg.style.color="green";
msg.innerText="Login successful!";
setTimeout(()=>location.href="dashboard.html",600);
}
else if(data=="signup_success"){
msg.style.color="green";
msg.innerText="Account created! Now login.";
toggleForm();
}
else{
msg.style.color="red";
msg.innerText=data;
}

});

}

</script>

</body>
</html>
