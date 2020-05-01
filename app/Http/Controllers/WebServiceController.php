<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Doctrine\DBAL\Driver\PDOConnection;

use SoapClient;
use App\Services\SoapService;

class WebServiceController extends Controller
{

  public function __construct(SoapService $soapService)
	{
		$this->soapService = $soapService;
    }

  public function getBalance()  { 
    $data = $this->soapService->getSaldo();
    $data[0]->saldo = number_format((float)$data[0]->saldo,2);
    return response()->json([
      'success' => true,
      'data' => $data,
    ]);;
  }

  public function getUnpaidInvoices()  { 
    return $this->soapService->getUnpaidInvoices();
  }

  public function getReportedPayments()  {
    $data = $this->soapService->getReportedPayments();
    return response()->json([
      'success' => true,
      'data' => $data,
    ]);;
  }
  // @group_id = N'0010-0010',
  // @invoices = N'0010-0010-4-2020-00',
  // @amount = 120,
  // @paymentNumber = N'96459089232984613'
  
  public function getOrder(Request $request){
    
    $user = auth()->user()->username;
    $data = \DB::connection('sqlsrv_backoffice')->statement('exec backoffice.dbo.sp_PortalProcesarPagoFactura ?,?,?,?', 
    array($user,$request['invoice'], $request['amount'],$request['order']));  
    return response()->json([
      'success' => true,
      'message' => $data
    ]);
    // $data = \DB::connection('sqlsrv_backoffice')->select('
    // EXEC backoffice.dbo.sp_PortalProcesarPagoFactura group_id,invoices,amount,paymentNumber', 
    // array("'3453453'",'"34534"', 120,'345345'));

    // $db = DB::connection('sqlsrv_backoffice')->getPdo();
    // $db->setAttribute(PDOConnection::ATTR_ERRMODE, PDOConnection::ERRMODE_EXCEPTION);
    // $a = 'assas';
    // $amount = 120;
    // $queryResult = $db->prepare('exec backoffice.dbo.sp_PortalProcesarPagoFactura group_id,invoices,amount,paymentNumber');
    // $queryResult->bindParam(1, $a, PDOConnection::PARAM_STR);
    // $queryResult->bindParam(2, $a, PDOConnection::PARAM_STR);
    // $queryResult->bindParam(3, $amount, PDOConnection::PARAM_INT);
    // $queryResult->bindParam(4, $a, PDOConnection::PARAM_STR);
    // $queryResult->execute();
    // $result_set = $queryResult->fetchAll(PDOConnection::FETCH_ASSOC);
    // $queryResult->closeCursor();
    // return $result_set;

//     $pdo = \DB::connection('sqlsrv_backoffice')->getPdo();
//     $sql = 'EXEC backoffice.dbo.sp_PortalProcesarPagoFactura group_id,invoices,amount,paymentNumber';
    
//     $stmt = $pdo->query($sql);
//     $stmt->bindParam(1, 'asdasd', PDO::PARAM_STR, 4000);
//     $stmt->bindParam(2, 'asdasd', PDO::PARAM_STR, 4000);
//     $stmt->bindParam(3, 120);
//     $stmt->bindParam(4, 'asdasd', PDO::PARAM_STR, 4000);
//     do {
//       $rows = $stmt->fetchAll(\PDO::FETCH_NUM); // Keys will be start from zero , one, two
//       $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC); // Column names will be assigned for each value

//       if ($rows) {
//         $sheetData[] = $rows;
//       }
// } while ($stmt->nextRowset());

  }
   
}