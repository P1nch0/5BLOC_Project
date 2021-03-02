<!DOCTYPE html>
<html lang="en">
<head>
<!-- basic -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- mobile metas -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="initial-scale=1, maximum-scale=1">
<!-- site metas -->
<title>Fraktal</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">
<!-- bootstrap css -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- style css -->
<link rel="stylesheet" href="css/style.css">
<!-- Responsive-->
<link rel="stylesheet" href="css/responsive.css">
<!-- fevicon -->
<link rel="icon" href="images/fevicon.png" type="image/gif" />
<!-- Scrollbar Custom CSS -->
<link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
<!-- Tweaks for older IEs-->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
<script src="node_modules/web3/dist/web3.min.js"></script>
<script src="js/fraktal.js"></script>
</head>
<!-- body -->
<?php include("menu.php"); ?>
<?php include("stdPdoQueries.php"); ?>

<div class="Currency-bg">
  <div class="container">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="abouttitle">
          <h2>EXCHANGE</h2>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="Currency">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="titlepage">
          <h2>Sell your  <strong class="cur">Fraktal</strong></h2>
          <span><img src="images/boder.png" alt="img"/> </span> </div>
	     <div class="row">
		<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                 <div class="three-box">
                  <figure><img src="images/1.jpg" alt="img"/></figure>
                  <div class="Bitcoin"> <i><img src="images/dollar.png" alt="img"/></i>
		   <h3>Make an offer</h3>
		    <form method="post" action="makeAnOffer.php">
			  <label for="sellerAccount">Your Account :</label><br>
			  <input type="text" id="sellerAccount" name="sellerAccount" readonly="true">
			  <label for="montantFkl">Fraktal amount :</label><br>
			  <input type="text" id="montantFkl" name="montantFkl"><br>
			  <label for="montantEth">Ethereum amount :</label><br>
			  <input type="text" id="montantEth" name="montantEth">
			  <input class="read-more" type="submit" id="submit" name="submit" value="Sell it">
		    </form>
		   <script>
                       showFraktals();
                   </script> 
		</div>
	      </div>
	     </div>
	   <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                 <div class="three-box">
                  <figure><img src="images/1.jpg" alt="img"/></figure>
                  <div class="Bitcoin"> <i><img src="images/dollar.png" alt="img"/></i>
		   <h3>Your Fraktals</h3>
		   <p id="userFraktals">You have : </p>
                   <script>
                        showAccount();
                   </script>
                </div>
              </div>
             </div>
       </div>
      </div>
     </div>
    </div>
   </div>

<script>


const promise = getUserAccount();

var account;

promise.then((value) => {
	document.cookie = "userAccount="+value;
});

</script>


<!-- Currency -->
<div class="Currency">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="titlepage">
          <h2>Your  <strong class="cur">sell orders</strong></h2>
          <span><img src="images/boder.png" alt="img"/> </span> </div>

<?php
	echo "<div class=\"row\">";
	
    	$pdoResult1 = $pdo->prepare("SELECT * FROM annonce WHERE compteVendeur=:compteVendeur");
	$pdoResult1->execute(['compteVendeur' => $_COOKIE["userAccount"]]); 

        while ($row = $pdoResult1->fetch()) {
                echo "<div class=\"col-xl-4 col-lg-4 col-md-4 col-sm-12\">
                       <div class=\"three-box\">
                        <figure><img src=\"images/1.jpg\" alt=\"img\"/></figure>
                         <div class=\"Bitcoin\"> <i><img src=\"images/dollar.png\" alt=\"img\"/></i>
                          <h3>Fraktal Offer</h3>";

		echo "<form method=\"post\" action=\"removeAnOffer.php\">
			  <label for=\"idAnnonce\">ID Ad </label>
			  <input type=\"text\" id=\"idAnnonce\" name=\"idAnnonce\" value=\"".$row['idAnnonce']."\">
                          <label for=\"account\">Seller account: </label>
                          <input type=\"text\" id=\"account\" name=\"account\" value=\"".$row['compteVendeur']."\" readonly=\"true\"><br>
                          <label for=\"montantFkl\">Fraktal amount :</label>
                          <input type=\"text\" id=\"montantFkl\" name=\"montantFkl\" value=\"".$row['montantFkl']."\" readonly=\"true\"><br>
                          <label for=\"montantEth\">Ethereum amount :</label>
                          <input type=\"text\" id=\"montantEth\" name=\"montantEth\" value=\"".$row['montantEth']."\" readonly=\"true\"><br>
                          </div>
                          <input class=\"read-more\" type=\"submit\" id=\"submit\" name=\"submit\" value=\"Remove it\">
                    </form></div></div>";

        };

?>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>


<!-- end Currency -->


<!-- Currency -->
<div class="Currency">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="titlepage">
          <h2>Exchange  <strong class="cur">offers</strong></h2>
	  <span><img src="images/boder.png" alt="img"/> </span> </div>
 
<?php
	echo "<div class=\"row\">";

	$pdoResult2 = $pdo->query("SELECT * FROM annonce");
		
	while ($row = $pdoResult2->fetch()) {
		echo "<div class=\"col-xl-4 col-lg-4 col-md-4 col-sm-12\">
	               <div class=\"three-box\">
        	        <figure><img src=\"images/1.jpg\" alt=\"img\"/></figure>
                	 <div class=\"Bitcoin\"> <i><img src=\"images/dollar.png\" alt=\"img\"/></i>
			  <h3>Fraktal Offer</h3>";

		echo "<form method=\"post\" action=\"makeAnOffer.php\">
                          <label for=\"account\">Seller account: </label>
                          <input type=\"text\" id=\"account\" name=\"account\" value=\"".$row['compteVendeur']."\" readonly=\"true\"><br>
                          <label for=\"montantFkl\">Fraktal amount :</label>
                          <input type=\"text\" id=\"montantFkl\" name=\"montantFkl\" value=\"".$row['montantFkl']."\" readonly=\"true\"><br>
                          <label for=\"montantEth\">Ethereum amount :</label>
			  <input type=\"text\" id=\"montantEth\" name=\"montantEth\" value=\"".$row['montantEth']."\" readonly=\"true\"><br>
			  </div>
                          <input class=\"read-more\" type=\"submit\" id=\"submit\" name=\"submit\" value=\"Buy it\">
                    </form></div></div>";

	};

?>
	</div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>

   
<!-- end Currency -->
<?php include("footer.php"); ?>
</body>
</html>
