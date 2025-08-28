<?php
include_once 'BaseClass.php';
include_once 'Models/PointInquiryResponseData.php';
include_once 'Models/SaleResponseData.php';
include_once 'Models/AuthResponseData.php';
include_once 'Models/CaptureResponseData.php';
include_once 'Models/VftResponseData.php';
include_once 'Models/ReturnResponseData.php';
include_once 'Models/PointUsageResponseData.php';
include_once 'Models/PointUsageReturnResponseData.php';
include_once 'Models/VftQueryResponseData.php';
include_once 'Models/ReverseResponseData.php';
include_once 'Models/KOICampaignQueryData.php';
include_once 'Models/AgreementResponseData.php';
include_once 'Models/TurkcellSaleResponseData.php';
include_once 'Models/TrioSingleResponseData.php';
include_once 'Models/TrioMultipleResponseData.php';
include_once 'Models/TrioFlexibleResponseData.php';
include_once 'Models/TrioFixedResponseData.php';
include_once 'Models/TrioReturnResponseData.php';
include_once 'Models/TrioAvailableLimitInquiryResponseData.php';
include_once 'Models/TrioPaymentListInquiry.php';
include_once 'Models/TrioPaymentDelayResponseData.php';
include_once 'Models/ThreeDSecureData.php';
include_once 'Models/SaleRequestData.php';
include_once 'Models/AuthRequestData.php';
include_once 'Models/VftRequestData.php';
include_once 'Models/VftQueryRequestData.php';
include_once 'Models/KOICampaignQueryRequestData.php';
include_once 'Models/PointInquiryRequestData.php';
include_once 'Models/TurkcellSaleRequestData.php';
include_once 'Models/TrioSingleRequestData.php';
include_once 'Models/TrioMultipleRequestData.php';
include_once 'Models/TrioFlexibleRequestData.php';
include_once 'Models/TrioFixedRequestData.php';
include_once 'Models/TrioPaymentDelayRequestData.php';

class VposPFTDIntegration extends BaseClass
{

    private $requestData = array();

    public $responseData = array();

    public $MAC;

    public $MACParams;

    private $InstallmentCount;

    private $InstallmentType;

    private $IsTDSecureMerchant;

    private $IsEncrypted;

    private $PointAmount;

    private $PaymentInstrumentType;

    private $Amount;

    private $CurrencyCode;

    private $OrderId;

    private $KOICode;

    public $saleResponseData;

    public $authResponseData;

    public $captureResponseData;

    public $VftResponseData;

    public $pointUsageResponseData;

    public $returnResponseData;

    public $pointUsageReturnResponseData;

    public $reverseResponseData;

    public $vftQueryResponseData;

    public $koiCampaignQueryData;

    public $agreementResponseData;

    public $pointInquiryResponseData;

    public $turkcellSaleResponseData;

    public $trioSingleResponseData;

    public $trioMultipleResponseData;

    public $trioFlexibleResponseData;

    public $trioFixedResponseData;

    public $trioReturnResponseData;

    public $trioAvailableLimitInquiryResponseData;

    public $trioPaymentListInquiry;

    public $trioPaymentDelayResponseData;
	
	public $merchantMessageData;

    // TODO: IsTDSecureMerchant Y olacak mý sor
    function __construct($MerchantNo, $TerminalNo, $Url, $EncryptionKey)
    {
        $this->requestData['ApiType'] = $this->ApiType;
        $this->requestData['ApiVersion'] = $this->ApiVersion;
        $this->requestData['MerchantNo'] = $MerchantNo;
        $this->requestData['TerminalNo'] = $TerminalNo;
        $this->requestData['PaymentInstrumentType'] = $this->PaymentInstrumentType = "CARD";
        $this->requestData['IsTDSecureMerchant'] = 'Y';
        $this->macMerchantNo = $MerchantNo;
        $this->macTerminalNo = $TerminalNo;
        $this->url = $Url;
        $this->encryptionKey = $EncryptionKey;
    }

    // Sale
    function doSale($Amount, $CurrencyCode, $OrderId, $merchantMessageData , ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData)
    {
		
		if( $merchantMessageData != "")
		{
			$this->requestData['merchantMessageData'] = $merchantMessageData;
		}
		
        $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
        $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
        $this->requestData['MAC'] = $this->getMac3D($ThreeDSecureData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['PointAmount'] = $this->PointAmount = "0";
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "N";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = '0';
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Sale");
        $this->saleresponseData = new SaleResponseData();
        $this->saleresponseData = $this->array_to_obj($this->responseData, $this->saleresponseData);
        return $this->saleresponseData;
    }

    function doSaleWithPoint($Amount, $CurrencyCode, $OrderId, $Point,$merchantMessageData , ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData)
    {	

		if( $merchantMessageData != "")
		{
			$this->requestData['merchantMessageData'] = $merchantMessageData;
		}
        $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
        $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
        $this->requestData['MAC'] = $this->getMac3D($ThreeDSecureData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['PointAmount'] = $this->PointAmount = $Point;
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "N";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = '0';
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Sale");
        $this->saleresponseData = new SaleResponseData();
        $this->saleresponseData = $this->array_to_obj($this->responseData, $this->saleresponseData);
        return $this->saleresponseData;
    }

    function doSaleWithInstallment($Amount, $CurrencyCode, $OrderId, $InstallmentCount, $merchantMessageData ,ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData)
    {
		if( $merchantMessageData != "")
		{
			$this->requestData['merchantMessageData'] = $merchantMessageData;
		}
		
        $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
        $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
        $this->requestData['MAC'] = $this->getMac3D($ThreeDSecureData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['PointAmount'] = $this->PointAmount = "0";
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "Y";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = $InstallmentCount;
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Sale");
        $this->saleresponseData = new SaleResponseData();
        $this->saleresponseData = $this->array_to_obj($this->responseData, $this->saleresponseData);
        return $this->saleresponseData;
    }

    function doSaleWithPointAndInstalment($Amount, $CurrencyCode, $OrderId, $Point, $InstallmentCount, $merchantMessageData ,ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData)
    {
		if( $merchantMessageData != "")
		{
			$this->requestData['merchantMessageData'] = $merchantMessageData;
		}
		
        $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
        $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
        $this->requestData['MAC'] = $this->getMac3D($ThreeDSecureData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['PointAmount'] = $this->PointAmount = $Point;
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "Y";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = $InstallmentCount;
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Sale");
        $this->saleresponseData = new SaleResponseData();
        $this->saleresponseData = $this->array_to_obj($this->responseData, $this->saleresponseData);
        return $this->saleresponseData;
    }

    function doSaleWithCustom(SaleRequestData $saleRequestData)
    {
        $saleRequestData->MAC = $this->getMac3D($saleRequestData->ThreeDSecureData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
        $this->responseData = $this->doTransaction(json_encode($saleRequestData, true, JSON_UNESCAPED_UNICODE), "Sale");
        $this->saleresponseData = new SaleResponseData();
        $this->saleresponseData = $this->array_to_obj($this->responseData, $this->saleresponseData);
        return $this->saleresponseData;
    }

    // Auth
    function doAuth($Amount, $CurrencyCode, $OrderId, $merchantMessageData, ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData)
    {
		
		if( $merchantMessageData != "")
		{
			$this->requestData['merchantMessageData'] = $merchantMessageData;
		}
        $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
        $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
        $this->requestData['MAC'] = $this->getMac3D($ThreeDSecureData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['PointAmount'] = $this->PointAmount = "0";
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "N";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = '0';
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Auth");
        $this->authResponseData = new AuthResponseData();
        $this->authResponseData = $this->array_to_obj($this->responseData, $this->authResponseData);
        return $this->authResponseData;
    }

    function doAuthWithInstallment($Amount, $CurrencyCode, $OrderId, $InstallmentCount, $merchantMessageData, ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData)
    {
		
		if( $merchantMessageData != "")
		{
			$this->requestData['merchantMessageData'] = $merchantMessageData;
		}
        $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
        $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
        $this->requestData['MAC'] = $this->getMac3D($ThreeDSecureData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['PointAmount'] = $this->PointAmount = "0";
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "Y";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = $InstallmentCount;
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Auth");
        $this->authResponseData = new AuthResponseData();
        $this->authResponseData = $this->array_to_obj($this->responseData, $this->authResponseData);
        return $this->authResponseData;
    }

    function doAuthWithCustom(AuthRequestData $authRequestData)
    {
        $this->requestData['MAC'] = $this->getMac3D($authRequestData->ThreeDSecureData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
        $this->responseData = $this->doTransaction(json_encode($authRequestData, true, JSON_UNESCAPED_UNICODE), "Auth");
        $this->authResponseData = new AuthResponseData();
        $this->authResponseData = $this->array_to_obj($this->responseData, $this->authResponseData);
        return $this->authResponseData;
    }

    // Vft
    function doVft($Amount, $CurrencyCode, $OrderID, $InstallmentCount, $VftCode, $merchantMessageData,ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData)
    {
		
		if( $merchantMessageData != "")
		{
			$this->requestData['merchantMessageData'] = $merchantMessageData;
		}
        $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
        $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
        $this->requestData['MAC'] = $this->getMac3D($ThreeDSecureData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "Y";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = $InstallmentCount;
        $this->requestData['PointAmount'] = $this->PointAmount = "0";
        $this->requestData['OrderId'] = $OrderID;
        $this->requestData['VFTCode'] = $VftCode;
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Vft");
        $this->vftREsponseData = new VftResponseData();
        $this->vftREsponseData = $this->array_to_obj($this->responseData, $this->vftREsponseData);
        return $this->vftREsponseData;
    }

    function doVftWithCustom(VftRequestData $vftRequestData)
    {
        $this->requestData['MAC'] = $this->getMac3D($vftRequestData->ThreeDSecureData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
        $this->responseData = $this->doTransaction(json_encode($vftRequestData, true, JSON_UNESCAPED_UNICODE), "Vft");
        $this->vftResponseData = new VftResponseData();
        $this->vftResponseData = $this->array_to_obj($this->responseData, $this->vftResponseData);
        return $this->vftResponseData;
    }

    // DoPointUsage
    function doPointUsage($Amount, $CurrencyCode, $OrderId, ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData)
    {
        $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
        $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
        $this->requestData['MAC'] = $this->getMac3D($ThreeDSecureData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['PointAmount'] = $this->PointAmount = "0";
        $this->requestData['OrderId'] = $OrderId;
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "PointUsage");
        $this->pointUsageResponseData = new PointUsageResponseData();
        $this->pointUsageResponseData = $this->array_to_obj($this->responseData, $this->pointUsageResponseData);
        return $this->pointUsageResponseData;
    }

    function doPointUsagetWithCustom(PointUsageRequestData $pointUsageRequestData)
    {
        $this->requestData['MAC'] = $this->getMac3D($pointUsageRequestData->ThreeDSecureData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
        $this->responseData = $this->doTransaction(json_encode($pointUsageRequestData, true, JSON_UNESCAPED_UNICODE), "PointUsage");
        $this->pointUsageResponseData = new PointUsageResponseData();
        $this->pointUsageResponseData = $this->array_to_obj($this->responseData, $this->pointUsageResponseData);
        return $this->pointUsageResponseData;
    }

    // Turkcell
    function doTurkcellSale($OrderId, $packetCode, $gsmNo, ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData)
    {
        $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
        $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
        $this->requestData['MAC'] = $this->getMac3D($ThreeDSecureData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['PacketCode'] = $packetCode;
        $this->requestData['GsmNo'] = $gsmNo;
        
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "TurkcellSale");
        $this->turkcellSaleResponseData = new TurkcellSaleResponseData();
        $this->turkcellSaleResponseData = $this->array_to_obj($this->responseData, $this->turkcellSaleResponseData);
        return $this->turkcellSaleResponseData;
    }

    function doTurkcellSaleWithCustom(TurkcellSaleRequestData $turkcellSaleRequestData)
    {
        $this->requestData['MAC'] = $this->getMac3D($turkcellSaleRequestData->ThreeDSecureData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
        $this->responseData = $this->doTransaction(json_encode($turkcellSaleRequestData, true, JSON_UNESCAPED_UNICODE), "TurkcellSale");
        $this->turkcellSaleResponseData = new TurkcellSaleResponseData();
        $this->turkcellSaleResponseData = $this->array_to_obj($this->responseData, $this->turkcellSaleResponseData);
        return $this->turkcellSaleResponseData;
    }
    
    // //
    // //TRIO
    // //
    
    // function doTrioSingleWithTerminalDayCount($Amount, $CurrencyCode,$OrderId ,$firmTerminalId, $extraRefNo, $terminalDayCount,ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData){
    // $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
    // $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
    // $this->requestData['MAC']= $this->getMac3D($ThreeDSecureData);
    // $this->requestData['MACParams']="MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
    // $this->requestData['Amount']=$Amount;
    // $this->requestData['CurrencyCode']=$CurrencyCode;
    // $this->requestData['OrderId']=$OrderId;
    // $this->requestData['FirmTerminalId'] = $firmTerminalId;
    // $this->requestData['ExtraRefNo'] = $extraRefNo;
    // $this->requestData['TerminalDayCount'] = $terminalDayCount;
    
    // $this->responseData=$this->doTransaction(json_encode($this->requestData,true,JSON_UNESCAPED_UNICODE), "TrioSingle");
    // $this->trioSingleResponseData = new TrioSingleResponseData();
    // $this->trioSingleResponseData = $this->array_to_obj($this->responseData, $this->trioSingleResponseData);
    // return $this->trioSingleResponseData;
    // }
    // function doTrioSingleWithDueDate($Amount, $CurrencyCode, $OrderId, $firmTerminalId, $extraRefNo, $dueDate,ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData){
    // $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
    // $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
    // $this->requestData['MAC']= $this->getMac3D($ThreeDSecureData);
    // $this->requestData['MACParams']="MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
    // $this->requestData['Amount']=$Amount;
    // $this->requestData['CurrencyCode']=$CurrencyCode;
    // $this->requestData['OrderId']=$OrderId;
    // $this->requestData['FirmTerminalId'] = $firmTerminalId;
    // $this->requestData['ExtraRefNo'] = $extraRefNo;
    // $this->requestData['DueDate'] = $dueDate;
    
    // $this->responseData=$this->doTransaction(json_encode($this->requestData,true,JSON_UNESCAPED_UNICODE), "TrioSingle");
    // $this->trioSingleResponseData = new TrioSingleResponseData();
    // $this->trioSingleResponseData = $this->array_to_obj($this->responseData, $this->trioSingleResponseData);
    // return $this->trioSingleResponseData;
    // }
    
    // function doTrioSingleWithCustom(TrioSingleRequestData $trioSingleRequestData){
    // $this->requestData['MAC']= $this->getMac3D($trioSingleRequestData->ThreeDSecureData);
    // $this->requestData['MACParams']="MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
    // $this->responseData = $this->doTransaction(json_encode($trioSingleRequestData,true,JSON_UNESCAPED_UNICODE), "TrioSingle");
    // $this->trioSingleResponseData = new TrioSingleResponseData();
    // $this->trioSingleResponseData = $this->array_to_obj($this->responseData, $this->trioSingleResponseData);
    // return $this->trioSingleResponseData;
    // }
    
    // function doTrioMultipleWithTerminalDayCount ($Amount, $CurrencyCode,$OrderId , $InstallmentCount, $firmTerminalId, $extraRefNo, $terminalDayCount,ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData){
    // $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
    // $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
    // $this->requestData['MAC']= $this->getMac3D($ThreeDSecureData);
    // $this->requestData['MACParams']="MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
    // $this->requestData['Amount']=$Amount;
    // $this->requestData['CurrencyCode']=$CurrencyCode;
    // $this->requestData['OrderId']=$OrderId;
    // $this->requestData['InstallmentType']=$this->InstallmentType="Y";
    // $this->requestData['InstallmentCount']=$this->InstallmentCount=$InstallmentCount;
    // $this->requestData['FirmTerminalId'] = $firmTerminalId;
    // $this->requestData['ExtraRefNo'] = $extraRefNo;
    // $this->requestData['TerminalDayCount'] = $terminalDayCount;
    
    // $this->responseData=$this->doTransaction(json_encode($this->requestData,true,JSON_UNESCAPED_UNICODE), "TrioMultiple");
    // $this->trioMultipleResponseData = new TrioMultipleResponseData();
    // $this->trioMultipleResponseData = $this->array_to_obj($this->responseData, $this->trioMultipleResponseData);
    // return $this->trioMultipleResponseData;
    // }
    
    // function doTrioMultipleWithDueDate ($Amount, $CurrencyCode,$OrderId , $InstallmentCount, $firmTerminalId, $extraRefNo, $dueDate,ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData){
    // $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
    // $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
    // $this->requestData['MAC']= $this->getMac3D($ThreeDSecureData);
    // $this->requestData['MACParams']="MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
    // $this->requestData['Amount']=$Amount;
    // $this->requestData['CurrencyCode']=$CurrencyCode;
    // $this->requestData['OrderId']=$OrderId;
    // $this->requestData['InstallmentType']=$this->InstallmentType="Y";
    // $this->requestData['InstallmentCount']=$this->InstallmentCount=$InstallmentCount;
    // $this->requestData['FirmTerminalId'] = $firmTerminalId;
    // $this->requestData['ExtraRefNo'] = $extraRefNo;
    // $this->requestData['DueDate'] = $dueDate;
    
    // $this->responseData=$this->doTransaction(json_encode($this->requestData,true,JSON_UNESCAPED_UNICODE), "TrioMultiple");
    // $this->trioMultipleResponseData = new TrioMultipleResponseData();
    // $this->trioMultipleResponseData = $this->array_to_obj($this->responseData, $this->trioMultipleResponseData);
    // return $this->trioMultipleResponseData;
    // }
    // function doTrioMultipleWithCustom(TrioMultipleRequestData $trioMultipleRequestData){
    // $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
    // $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
    // $this->requestData['MAC']= $this->getMac3D($trioMultipleRequestData->ThreeDSecureData);
    // $this->requestData['MACParams']="MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
    // $this->responseData = $this->doTransaction(json_encode($trioMultipleRequestData,true,JSON_UNESCAPED_UNICODE), "TrioMultiple");
    // $this->trioMultipleResponseData = new TrioMultipleResponseData();
    // $this->trioMultipleResponseData = $this->array_to_obj($this->responseData, $this->trioMultipleResponseData);
    // return $this->trioMultipleResponseData;
    // }
    
    // //TODO: response
    // function doTrioFlexibleWithTerminalDayCount ($CurrencyCode, $OrderId, $InstallmentCount, $firmTerminalId, $extraRefNo, $terminalDayCount,$dueInfoList,ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData){
    // $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
    // $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
    // $this->requestData['MAC']= $this->getMac3D($ThreeDSecureData);
    // $this->requestData['MACParams']="MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
    // $this->requestData['CurrencyCode']=$CurrencyCode;
    // $this->requestData['OrderId']=$OrderId;
    // $this->requestData['InstallmentType']=$this->InstallmentType="Y";
    // $this->requestData['InstallmentCount']=$this->InstallmentCount=$InstallmentCount;
    // $this->requestData['firmTerminalId'] = $firmTerminalId;
    // $this->requestData['extraRefNo'] = $extraRefNo;
    // $this->requestData['terminalDayCount'] = $terminalDayCount;
    // $this->requestData['DueInfo'] = $dueInfoList;
    
    // $this->responseData=$this->doTransaction(json_encode($this->requestData,true,JSON_UNESCAPED_UNICODE), "TrioFlexible");
    // $this->TrioFlexibleResponseData = new TrioFlexibleResponseData();
    // $this->TrioFlexibleResponseData = $this->array_to_obj($this->responseData, $this->TrioFlexibleResponseData);
    // return $this->TrioFlexibleResponseData;
    // }
    
    // function doTrioFlexiblWithCustom(TrioFlexibleRequestData $trioFlexibleRequestData){
    // $this->requestData['MAC']= $this->getMac3D($ThreeDSecureData);
    // $this->requestData['MACParams']="MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
    // $this->responseData = $this->doTransaction(json_encode($trioFlexibleRequestData,true,JSON_UNESCAPED_UNICODE), "TrioFlexible");
    // $this->TrioFlexibleResponseData = new TrioFlexibleResponseData();
    // $this->TrioFlexibleResponseData = $this->array_to_obj($this->responseData, $this->TrioFlexibleResponseData);
    // return $this->TrioFlexibleResponseData;
    // }
    
    // function doTrioFixed($noWarranty, $amount, $currencyCode,$OrderId, $firmTerminalId, $extraRefNo,ThreeDSecure $ThreeDSecureData, PaymentFacilitatorData $PaymentFacilitatorData){
    // $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
    // $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
    // $this->requestData['MAC']= $this->getMac3D($ThreeDSecureData);
    // $this->requestData['MACParams']="MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
    // $this->requestData['NoWarranty'] = $noWarranty;
    // $this->requestData['Amount'] = $amount;
    // $this->requestData['CurrencyCode']=$currencyCode;
    // $this->requestData['OrderId']=$OrderId;
    // $this->requestData['firmTerminalId'] = $firmTerminalId;
    // $this->requestData['extraRefNo'] = $extraRefNo;
    
    // $this->responseData=$this->doTransaction(json_encode($this->requestData,true,JSON_UNESCAPED_UNICODE), "TrioFixed");
    // $this->trioFixedResponseData = new TrioFixedResponseData();
    // $this->trioFixedResponseData = $this->array_to_obj($this->responseData, $this->trioFixedResponseData);
    // return $this->trioFixedResponseData;
    // }
    
    // function doTrioFixedlWithCustom(TrioFixedRequestData $trioFixedRequestData){
    // $this->requestData['ThreeDSecureData'] = $ThreeDSecureData;
    // $this->requestData['PaymentFacilitatorData'] = $PaymentFacilitatorData;
    // $this->requestData['MAC']= $this->getMac3D($trioFixedRequestData->ThreeDSecureData);
    // $this->requestData['MACParams']="MerchantNo:TerminalNo:SecureTransactionId:CavvData:Eci:MdStatus";
    // $this->responseData = $this->doTransaction(json_encode($trioFixedRequestData,true,JSON_UNESCAPED_UNICODE), "TrioFixed");
    // $this->trioFixedResponseData = new TrioFixedResponseData();
    // $this->trioFixedResponseData = $this->array_to_obj($this->responseData, $this->trioFixedResponseData);
    // return $this->trioFixedResponseData;
    // }
}
?>