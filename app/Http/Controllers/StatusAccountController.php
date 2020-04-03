<?php

namespace App\Http\Controllers;

use SoapClient;
use Illuminate\Http\Request;
use App\BackOffice\Services\LoginTokenService;
use App\BackOffice\Services\ClientesService;

class StatusAccountController extends Controller
{
    public function __construct(
		LoginTokenService $loginTokenService,
		ClientesService $clientesService
		)
	{
		$this->loginTokenService = $loginTokenService;
		$this->clientesService = $clientesService;
    }

    function getToken() {
      date_default_timezone_set('America/Caracas');
      $domain_id = "CCC";
      $date = date('Ymd');
      $calculated_token = md5($domain_id.$date);
      $calculated_token = base64_encode(strtoupper(md5($domain_id.$date )));
      return $calculated_token;
    }

    function EstadoCuenta($xml) {
	$EstadoCuenta = "";

	//echo  "<h3>Estado de Cuenta</h3>";

	$i = 0;
	$status = 0;
	//echo '<div id="gmp_de_persona" class="table-responsive card-body ew-grid-middle-panel">';
	echo '<div id="gmp_de_persona" class="table-responsive ew-grid-middle-panel">';

	echo "<table class='table table-striped' border='1' width='100%'>";
	//echo '<table id="tbl_estadocuenta" class="table ew-table">';
	
	
	foreach ($xml as $key => $value)
	{
		//foreach($value as $ekey => $eValue)
		{
			//echo $i . "<br>";
			//print($key . " =* " . $value . "<br>");
			if ($i==1)
			{
				$myxml = simplexml_load_string($value);
				//print_r($myxml);
				//$array2 = stdToArray($value);
				//print_r($array2);
				//var_dump($array2);
				
				$registros= $myxml->NewDataSet->Table;
				//print_r( $registros);
				$arrlength = @count($registros);
				//echo $arrlength;
				// echo 'fact_num '  . " - ";
				// echo 'fec_emis '  . " - ";
				// echo '                    fact_venc'  . " - ";
				// echo 'descrip  '  . " - ";
				// echo 'saldo    ';
				// echo "<br>";

				echo '<thead class="thead-dark">';
				echo '<tr>';
				echo '<th scope="col">Nro</th>';
				echo '<th scope="col">Emision</th>';
				//echo '<th scope="col">Vencimiento</th>';
				echo '<th scope="col">Descripcion</th>';
				echo '<th scope="col">Tipo</th>';
				echo '<th scope="col">Debe</th>';
				echo '<th scope="col">Haber</th>';
				echo '<th scope="col">Acumulado</th>';
				echo '</tr>';
				echo '</thead>';

				$acumulado = 0;
				for($x = 0; $x < $arrlength; $x++) {
					//print_r ($registros[$x]);
					// echo $registros[$x]->fact_num . " - ";
					// echo $registros[$x]->fec_emis . " - ";
					// echo $registros[$x]->fact_venc . " - ";
					// echo $registros[$x]->descrip . " - ";
					// echo $registros[$x]->saldo;
					// echo "<br>";

					echo '<tr>';
					
					$value = $registros[$x]->fact_num;
					echo '<td align="center">' . $value 	. "</td>";
					$EstadoCuenta = $EstadoCuenta . ";" . $value;

					$date = date_create( $registros[$x]->fec_emis );
					$value = date_format($date, 'd-m-Y');
					echo '<td>' .  $value  	. "</td>";
					$EstadoCuenta = $EstadoCuenta . ";" . $value;


					/*
					$date2 = date_create( $registros[$x]->fact_venc );
					$value = date_format($date2, 'd-m-Y');
					echo '<td>' . $value . "</td>";
					$EstadoCuenta = $EstadoCuenta . ";" . $value;
*/

					$value = $registros[$x]->descrip;
					echo '<td>' . $value 	. "</td>";
					$EstadoCuenta = $EstadoCuenta . ";" . $value;
					

					$value = $registros[$x]->tipo;
					echo '<td align="center">' . $value 	. "</td>";
					$EstadoCuenta = $EstadoCuenta . ";" . $value;

					$value = $registros[$x]->total_fac;
					echo '<td type="number" align="right">' . $value 	. "</td>";
					$EstadoCuenta = $EstadoCuenta . ";" . $value;

					$value = $registros[$x]->saldo;
					echo '<td type="number" align="right">' . $value 	. "</td>";
					$EstadoCuenta = $EstadoCuenta . ";" . $value;
					
					echo '</tr>';
				}
				
				
				//echo '$status = ' . $status;
				
				if ($status >= 0)
				{
				//	echo '$saldo = ' . $myxml->NewDataSet->Table->saldo;
				}
			}
			$i++;

		}
	}
	echo "<tr>"  . "<td colspan='6'  align='right'><strong>Total</strong></td><td type='number' align='right'><b>" . $acumulado . "</b></td>"  . "</tr>";
	echo "</table>";
	echo '<div>';
}	

    public function getStatusAccount() {
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
        $url = "http://190.216.224.53:8080/wsServiciosSociosCCC3/wsSociosCCC.asmx?WSDL";
		$user = auth()->user()->username;
        $parametros = [
            'group_id' => $user,
            'token' => $this->getToken(),
        ];
          try{
              $client = new SoapClient($url,$params);

              $response = $client->GetEstadoCuentaXML($parametros)->GetEstadoCuentaXMLResult;
              
			//   $this->EstadoCuenta($response);
				$i = 0;
				$newArray = array();
				foreach ($response as $key => $value) {
					if ($i==1) {
						$myxml = simplexml_load_string($value);				
						$registros= $myxml->NewDataSet->Table;
						$arrlength = @count($registros);
						$acumulado = 0;
						for($x = 0; $x < $arrlength; $x++) {
							$monto = $registros[$x]->total_fac;
							$acumulado = bcadd($acumulado, $monto, 2);
							$registros[$x]->acumulado = $acumulado; 
							array_push($newArray, $registros[$x]);
						}
					}
					$i++;
				}
				return response()->json([
					'success' => true,
					'data' => $newArray,
					'total' => $acumulado
				]);;

          }
          catch(SoapFault $fault) {
              echo '<br>'.$fault;
          }
    }
}
