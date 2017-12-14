<? 
	if(!isset($_SESSION))
	{
	  session_start();
	}
	
	include_once $_SESSION['base_url'].'/partials/header.php';
	include_once $_SESSION['base_url'].'/partials/footer.php';
?>