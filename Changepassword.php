<?PHP
	session_start();
	// Create connection to Oracle
	if(empty($_SESSION['ID']) || empty($_SESSION['NAME']) || empty($_SESSION['SURNAME'])){
		echo '<script>window.location = "Login.php";</script>';
	}
	$conn = oci_connect("system", "Rukhuman1198", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>

Change Password
<hr>

<?PHP
	if(isset($_POST['submit'])){
		$oldpassword = trim($_POST['oldpassword']);
		$newpassword = trim($_POST['newpassword']);
		$confirmnewpassword = trim($_POST['confirmnewpassword']);
		$id = $_SESSION['ID'];
		if($newpassword == $confirmnewpassword && $newpassword != Null && $oldpassword == $_SESSION['Password']){
			$query = "UPDATE AA_LOGIN SET PASSWORD = '$newpassword' WHERE username = '".$_SESSION['USERNAME']."' and password = '$oldpassword'";
			$_SESSION['Password'] = $newpassword;
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			echo "Success";
		}else{
			echo "Password error";
		}
	};
	oci_close($conn);
?>


<?PHP
	if(isset($_POST['back'])){
		echo '<script>window.location = "MemberPage.php";</script>';
	};
?>

<form action='Changepassword.php' method='post'>
	Old Password <br>
	<input name='oldpassword' type='password'><br>
	New Password<br>
	<input name='newpassword' type='password'><br>
    Comfirm New Password <br>
	<input name='confirmnewpassword' type='password'><br><br>
	<input name='submit' type='submit' value='Submit'>
    <input name='back' type='submit' value='Back'>
</form>