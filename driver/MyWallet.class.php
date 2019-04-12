<?php
require_once('..\php-client\autoload.php');


use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Client\AddressClient;
use BlockCypher\Client\TXClient;
use BlockCypher\Api\TX;

$config = array();
//$config["btc.pubkey"] = "02781ac6bab9097077aea5475a3c8488c2fa372d60d6c653648c64db31aec31acb"; // Master BTC Public Key
//$config["btc.privkey"] = "ac6ad1df7f6b3b81bffcb0f426ffd7e84afb5af5ab5ebb8fa28df24d151372b4"; // Master BTC Private Key
//$config["btc.addr"] = "2MvJzTA2kEFf4bRYLph3eyACKY4VYmGKctE"; // Master BTC Address
$config["btc.blockcypher.apitoken"] = "3a9f6240b5b044aba0c4aba0c764ca04"; // BlockCypher API Token

class MyWallet {
	private $apiContext, $apiContextNoToken;

	public function __construct($addr) {
		global $config;
		$config["btc.addr"] = $addr;
		//$config["btc.privkey"] = $privKey;

		$this->apiContext = ApiContext::create(
		    'test3', 'btc', 'v1',
		    new SimpleTokenCredential($config["btc.blockcypher.apitoken"]),
		    array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
		);

		// Non-POST requests doesn't need token which avoids hitting limit
		$this->apiContextNoToken = ApiContext::create(
		    'test3', 'btc', 'v1',
		    new SimpleTokenCredential(""),
		    array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
		);
	}

	// Getting receiving address
	public function getRecvAddr() {
		// Using hard coded address
		// If you are using HD (Hierarchical Deterministic) Wallet, please modify accordingly
		return $this->getMasterAddr();
	}


	public function getMasterAddr() {
		global $config;
		return $config["btc.addr"];
	}

	public function getMasterAddrTransactions() {
		return $this->getAddrTransactions($this->getMasterAddr());
	}

	public function getMasterAddrFullTransactions() {
		return $this->getAddrFullTransactions($this->getMasterAddr());
	}
	
	public function getAddrTransactions($addr) {
		$addressClient = new AddressClient($this->apiContextNoToken);
		$address = $addressClient->get($addr);
		return $address->txrefs;
	}
	
	public function getAddrFullTransactions($addr) {
		$addressClient = new AddressClient($this->apiContextNoToken);
		$address = $addressClient->getFullAddress($addr);
		return $address->txs;
	}

	public function getAddrBalance($addr) {
		$addressClient = new AddressClient($this->apiContextNoToken);
		$addressBalance = $addressClient->getBalance($addr);
		return $addressBalance->final_balance;
	}

	public function getMasterAddrBalance() {
		return $this->getAddrBalance($this->getMasterAddr());
	}

	public function sendPayment($sdrPrivKey, $btcAddress, int $satoshi) {
		global $config;
		$config["btc.privkey"] = $sdrPrivKey;
		$tx = new TX();

		// Tx inputs
		$input = new \BlockCypher\Api\TXInput();
		$input->addAddress($this->getMasterAddr());
		$tx->addInput($input);
		// Tx outputs
		$output = new \BlockCypher\Api\TXOutput();
		$output->addAddress($btcAddress);
		$tx->addOutput($output);
		// Tx amount
		$output->setValue($satoshi); // Satoshis

		$txClient = new TXClient($this->apiContext);
		$txSkeleton = $txClient->create($tx);
		$privateKeys = array($config["btc.privkey"]);
		$txSkeleton = $txClient->sign($txSkeleton, $privateKeys);
		
		$txSkeleton = $txClient->send($txSkeleton);
		
		return $txSkeleton->tx->hash;
		//return $txSkeleton;
	}

}
?>

