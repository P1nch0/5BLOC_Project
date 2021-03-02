<script src="node_modules/web3/dist/web3.min.js"></script>
<script src="js/fraktal.js"></script>
<script src="node_modules/ethereumjs-tx/dist/fake.js"></script>
<script src="node_modules/ethereumjs-tx/dist/index.js"></script>
<script src="node_modules/ethereumjs-tx/dist/transaction.js"></script>
<script src="node_modules/ethereumjs-tx/dist/types.js"></script>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include("stdPdoQueries.php");

    $account = $_POST['account'];
    $fkl = $_POST['montantFkl'];
    $eth = $_POST['montantEth'];

    $sql = "INSERT INTO annonce (compteVendeur, montantFkL, montantEth) VALUES (?,?,?)";
    $pdo->prepare($sql)->execute([$account, $fkl, $eth]);

    echo "Your offer is now online !";

    /*echo $account;
    echo $fkl;
    echo $eth;*/

    /*echo '<script type="text/javascript">',
	    'sendFkl('.$fkl.');',
	    '</script>';*/

    header('Refresh: 3; URL=http://ec2-18-202-245-210.eu-west-1.compute.amazonaws.com/Exchange.php');
?>
