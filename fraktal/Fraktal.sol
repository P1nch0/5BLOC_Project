pragma solidity ^0.4.4;

contract Fraktal {
    

/*
                       ___---___                    
                    .--         --.      
                  ./   ()      .-. \.
                 /   o    .   (   )  \
                / .            '-'    \         
               | ()    .  O         .  |      
              |                         |      
              |    o           ()       |
              |       .--.          O   |            
               | .   |    |            |
                \    `.__.'    o   .  /     FRAKTAL
                 \                   /                   
                  `\  o    ()      /'      TO THE MOON !!
                    `--___   ___--'
  
  
  
  
                  /\
                 /  \
                |    |
                |FKL!|
                |    |
                |    |
                |    \
               |      \
               |   |  |
               |   |  |
               |___|__|
                '-`'-`   .
               / . \'\ . .'
             ''( .'\.' ' .;'
          '.;.;' ;'.;' ..;;'
*/


    // Renvoie le nombre total de tokens
    function totalSupply() constant returns (uint256 supply) {}
    
    // La balance du _owner (Adresse depuis laquelle le solde sera récupéré)
    function balanceOf(address _owner) constant returns (uint256 balance) {}
    
    // _to est l'adresse du destinataire
    // _value le nombre de token à transferer 
    // On envoi la valeur _value à _to depuis msg.sender
    function transfer(address _to, uint256 _value) returns (bool success) {}
    
    // _ from adresse de l'envoyeur
    // _to adresse du destinataire
    // _value le nombre de token à transferer
    // On envoi la valeur [_value] à [_to] depuis [_from] à condition qu'il approuve la transaction
    function transferFrom(address _from, address _to, uint256 _value) returns (bool success) {}
    
    // _spender l'adresse du compte capable de faire le transfert de tokens
    // _value le montant à approuver pour le transfert
    // msg.sender approuve l'addresse _addr pour dépenser un nombre _value de tokens
    function approve(address _spender, uint256 _value) returns (bool success) {}
    
    // _owner L'adresse du compte possédant les tokens
    // _spender L'adresse du compte capable de transférer les tokens
    // return le montant de jetons restants autorisés à dépenser
    function allowance(address _owner, address _spender) constant returns (uint256 remaining) {}
    
    event Transfer(address indexed _from, address indexed _to, uint256 _value);
    event Approval(address indexed _owner, address indexed _spender, uint256 _value);

}

contract FraktalToken is Fraktal {

    function transfer(address _to, uint256 _value) returns (bool success) {
    
    // La valeur par défaut suppose que l'approvisionnement total ne peut pas dépasser (2^256 - 1)
    // Si le jeton ne tient pas compte du totalSupply et peut émettre plus de jetons au fil du temps, on vérifie
    
    //Pour la protection anti-Wraping
    //à mettre si le totalSupply tombe à 0
    //if (balances[msg.sender] >= _value && balances[_to] + _value > balances[_to]) {
        if (balances[msg.sender] >= _value && _value > 0) {
        balances[msg.sender] -= _value;
        balances[_to] += _value;
        Transfer(msg.sender, _to, _value);
        return true;
        } else { return false; }
    }

    function transferFrom(address _from, address _to, uint256 _value) returns (bool success) {
        
        //Pour la protection anti-Wraping
        //pareil qu'au dessus
        //if (balances[_from] >= _value && allowed[_from][msg.sender] >= _value && balances[_to] + _value > balances[_to]) {
        if (balances[_from] >= _value && allowed[_from][msg.sender] >= _value && _value > 0) {
            
        //Besoin de
        //require(msg.sender.balance >= 1000)
        
        balances[_to] += _value;
        balances[_from] -= _value;
        allowed[_from][msg.sender] -= _value;
        Transfer(_from, _to, _value);
        
        //Collecte des commissions
        myAdress.transfer(1000);
        //Ou
        transfer(myAdress,1000);
        
        return true;
        } else { return false; }
    }
    
    function balanceOf(address _owner) constant returns (uint256 balance) {
    return balances[_owner];
    }
    
    function approve(address _spender, uint256 _value) returns (bool success) {
    allowed[msg.sender][_spender] = _value;
    Approval(msg.sender, _spender, _value);
    return true;
    }
    
    function allowance(address _owner, address _spender) constant returns (uint256 remaining) {
    return allowed[_owner][_spender];
    }
    
    mapping (address => uint256) balances;
    mapping (address => mapping (address => uint256)) allowed;
    uint256 public totalSupply;
}


// Contrat ERC20Fraktal
contract ERC20Fraktal is FraktalToken {

    function () {
    //Renvoie si envoyer ici
    throw;
    }

    //infos
    string public name; 
    uint8 public decimals; 
    string public symbol; 
    string public version = '4.2';

    function ERC20Fraktal() {
    balances[msg.sender] = 20000; // supply du createur
    totalSupply = 1000000000000000000000000000; // total
    name = "fraktal"; // nom
    decimals = 1; // affichage du nombre de décimales
    symbol = "FkL"; // sigle
    }


    // Approuve puis appelle le contrat de réception
    function approveAndCall(address _spender, uint256 _value, bytes _extraData) returns (bool success) {
    allowed[msg.sender][_spender] = _value;
    Approval(msg.sender, _spender, _value);
    
    // On la fonction receiveApproval sur le contrat dont on souhaite être averti. 
    //Cela crée la signature de la fonction manuellement (pour de ne pas avoir besoin d'inclure un contrat ici juste pour ça)
    
    //receiveApproval(address _from, uint256 _value, address _tokenContract, bytes _extraData)
    
    //on suppose que l'appel doit réussir, sinon on utilisera à la place l'approbation à l'ancienne.
    if(!_spender.call(bytes4(bytes32(sha3("receiveApproval(address,uint256,address,bytes)"))), msg.sender, _value, this, _extraData)) { throw; }
    return true;
    }
}
