<?php

namespace App\Services;

use Illuminate\Http\Request;

class StatusAccountService {

	public function __construct(SportRepository $sport) {
		$this->sport = $sport ;
	}

	public function getStatusAccount() {
        $token = $this->sport->getStatusAccount();
        $domain_id = "CCC";
        $date = date('Ymd');
        $calculatedToken = base64_encode(strtoupper(md5($domain_id.$date)));
        
        $share = auth()->user()->username;
    
        $opts = array(
          'ssl' => array('ciphers'=>'RC4-SHA', 'verify_peer'=>false, 'verify_peer_name'=>false)
        );
        $params = array (
          'encoding' => 'UTF-8', 
          'verifypeer' => false, 
          'verifyhost' => false, 
          'soap_version' => SOAP_1_2, 
          'trace' => 1, 'exceptions' => 1, 
          "connection_timeout" => 180, 
          'stream_context' => stream_context_create($opts),
        );
        $url = "http://10.0.0.15:8080/wsServiciosSociosCCC3/wsSociosCCC.asmx?WSDL";
    
          try{
              $client = new SoapClient($url,$params);
              $response = $client->GetEstadoCuentaXML([
                'group_id' => $share,
                'token' => $calculatedToken,
              ])->GetSaldoCSVResult;
            //   dd($response);
          }
          catch(SoapFault $fault) {
              echo '<br>'.$fault;
          }
	}
}