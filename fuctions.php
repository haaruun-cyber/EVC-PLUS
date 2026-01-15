<?php
//make payment function
function makepayment($status,$responseMsg){
    //include "db.php";
    global $conn;
    //session_start();
        $number = $_POST["number"];
        $amount = $_POST["amount"];
        if(!empty($number)  && !empty($amount)){
            $query = "insert into transactions(number,amount,status,message) values('$number','$amount','$status','$responseMsg')";
            $result = mysqli_query($conn,$query);

            if (!$result) {
                //echo "Database query failed!";
                $_SESSION["toast"] = ["type" => "error", "message" => "database!".mysqli_error($conn).""];
                return;
            }else{
                $_SESSION["toast"] = ["type" => "success", "message" => "succedfully Stored!"];
            }
        }else{
            $_SESSION["toast"] = ["type" => "error", "message" => "fill all the form!"];
        }
}

//list of payment status function
function transactionlist(){
    //include "db.php";
    global $conn;
    $query = "SELECT * FROM transactions";
    $result = mysqli_query($conn,$query);

    if (!$result) {
        $_SESSION["toast"] = ["type" => "error", "message" => "database error!".mysqli_error($conn).""];
        return;
    }

    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_array($result)){
        echo "
        <tr>
            <td>{$data['id']}</td>
            <td>{$data['number']}</td>
            <td>{$data['amount']}$</td>
            <td>{$data['status']}</td>
            <td>{$data['message']}</td>
        </tr>
    ";
    }
    }else{
        echo 
        "
        <div id='noRecordsMessage' class='no-records' >
            <i class='fas fa-inbox'></i>
            <h3>No Records Found</h3>
            <p>There are currently no transactions to display. Transactions will appear here once they are processed.</p>
        </div>
        ";
    }
}

//process payment function
function processpayment() {

    $phonenumber = $_POST["number"];
    $amount = $_POST["amount"];
    $desc = "lacag bixin tijaabo";
    $requestid = (rand(100000,999999));
    $ref = (rand(100000,999999));
    $invoiceid = (rand(100000,999999));
    $timestamp = date("Y-m-d H:i:s");
    $data = array(
        "schemaVersion" => '1.1',
        "requestId" => $requestid,
        "timestamp" => $timestamp,
        "channelName" => 'web',
        "serviceName" => 'API_PURCHASE',
        "serviceParams" => array(
            "merchantUid" => 'M0913716',
            "apiUserId" => '1007632',
            "apiKey" => 'API-69429711AHX',
            "paymentMethod"=> "MWALLET_ACCOUNT",
             "payerInfo"=> array(
             "accountNo"=> $phonenumber,
             ),
        "transactionInfo" =>array( 
            "referenceId"=> $ref,
            "invoiceId"=> $invoiceid,
            "amount"=> $amount,
            "currency"=> "USD",
            "description"=> $desc,
         )
        ),
    );
    // CURL
    $post_data = json_encode($data,JSON_UNESCAPED_SLASHES);
    $url = "https://api.waafipay.net/asm";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $excutecurl = curl_exec($ch);
    print_r($excutecurl);
    curl_close($ch);
    $returndata = json_decode($excutecurl,true);
    $responseMsg = $returndata['responseMsg'];
    $responseCode = $returndata['responseCode'];
    if($responseCode == 2001){
        $status = 'Success';
        makepayment($status, $responseMsg);
    }else{
        $status = 'failed';
        makepayment($status, $responseMsg);
    }
}
?>