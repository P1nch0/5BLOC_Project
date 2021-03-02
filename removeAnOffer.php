<script src="node_modules/web3/dist/web3.min.js"></script>
<script src="js/fraktal.js"></script>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include("stdPdoQueries.php");

    $idAnnonce = $_POST['idAnnonce'];
    $account = $_POST['account'];
    $fkl = $_POST['montantFkl'];
    $eth = $_POST['montantEth'];

    
    $pdoResult1 = $pdo->prepare("DELETE FROM annonce WHERE compteVendeur=:compteVendeur AND idAnnonce=:idAnnonce");
    $pdoResult1->execute(array('compteVendeur' => $_POST['account'], ':idAnnonce' => $_POST['idAnnonce']));

    echo "Your offer have been removed !";

    echo $idAnnonce;
    echo $account;
    echo $fkl;
    echo $eth;

    /*echo '<script type="text/javascript">',
	    'sendFkl('.$fkl.');',
	    '</script>';*/

  header('Refresh: 3; URL=http://ec2-18-202-245-210.eu-west-1.compute.amazonaws.com/Exchange.php');
?>
