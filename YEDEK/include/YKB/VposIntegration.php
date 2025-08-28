<?php
include_once 'BaseClass.php';
include_once 'Models//PointInquiryResponseData.php';
include_once 'Models//SaleResponseData.php';
include_once 'Models//AuthResponseData.php';
include_once 'Models//CaptureResponseData.php';
include_once 'Models//VftResponseData.php';
include_once 'Models//ReturnResponseData.php';
include_once 'Models//PointUsageResponseData.php';
include_once 'Models//PointUsageReturnResponseData.php';
include_once 'Models//VftQueryResponseData.php';
include_once 'Models//ReverseResponseData.php';
include_once 'Models//KOICampaignQueryData.php';
include_once 'Models//AgreementResponseData.php';
include_once 'Models//TurkcellSaleResponseData.php';
include_once 'Models//TrioSingleResponseData.php';
include_once 'Models//TrioMultipleResponseData.php';
include_once 'Models//TrioFlexibleResponseData.php';
include_once 'Models//TrioFixedResponseData.php';
include_once 'Models//TrioReturnResponseData.php';
include_once 'Models//TrioAvailableLimitInquiryResponseData.php';
include_once 'Models//TrioPaymentListInquiry.php';
include_once 'Models//TrioPaymentDelayResponseData.php';

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
include_once 'Models/UnmatchedReturnRequestData.php';
include_once 'Models/UnmatchedReturnResponseData.php';

class VposIntegration extends BaseClass
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

    private $cardInformationData;

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
	
	public $merchantMessageData;
	
	public $UnmatchedReturnRequestData;
	
	public $UnmatchedReturnResponseData;

    public $trioPaymentDelayResponseData;
    public $merchantNo = "";
    public $terminalNo = "";
    function __construct($MerchantNo, $TerminalNo, $Url, $EncryptionKey)
    {
        $this->requestData['ApiType'] = $this->ApiType;
        $this->requestData['ApiVersion'] = $this->ApiVersion;
        $this->requestData['MerchantNo'] = $MerchantNo;
        $this->requestData['TerminalNo'] = $TerminalNo;
        $this->requestData['PaymentInstrumentType'] = $this->PaymentInstrumentType = "CARD";
        $this->macMerchantNo = $MerchantNo;
        $this->macTerminalNo = $TerminalNo;
        $this->requestData['IsTDSecureMerchant'] = 'N';
        $this->requestData['IsEncrypted'] = 'N';
        $this->url = $Url;
        $this->encryptionKey = $EncryptionKey;
    }

    // Sale
    function doSale(CardInformationData $cardInformationData, $Amount, $CurrencyCode, $OrderId , $koiCode , $merchantMessageData)
    {
		if( $koiCode != "")
		{
			$this->requestData['KOICode'] = $this->koiCode;
		}
		if( $merchantMessageData != "")
		{
			$this->requestData['merchantMessageData'] = $this->merchantMessageData;

		}
		
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->requestData['PointAmount'] = $this->PointAmount = "0";
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "N";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = '0';
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Sale");
        $this->saleresponseData = new SaleResponseData();
        $this->saleresponseData = $this->array_to_obj($this->responseData, $this->saleresponseData);
        return $this->saleresponseData;
    }

    function doSaleWithPoint(CardInformationData $cardInformationData, $Amount, $CurrencyCode, $OrderId, $Point ,  $koiCode , $merchantMessageData)
    {

		
		if( $koiCode != "")
		{
			$this->requestData['KOICode'] = $this->koiCode;
		}
		if( $merchantMessageData != "")
		{
			$this->requestData['merchantMessageData'] = $this->merchantMessageData;

		}
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
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

    function doSaleWithInstallment(CardInformationData $cardInformationData, $Amount, $CurrencyCode, $OrderId, $InstallmentCount ,  $koiCode , $merchantMessageData)
    {
		
		if( $koiCode != "")
		{
			$this->requestData['KOICode'] = $this->koiCode;
		}
		if( $merchantMessageData != "")
		{
			$this->requestData['merchantMessageData'] = $this->merchantMessageData;

		}
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->requestData['PointAmount'] = $this->PointAmount = "0";
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "Y";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = $InstallmentCount;
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Sale");
        $this->saleresponseData = new SaleResponseData();
        $this->saleresponseData = $this->array_to_obj($this->responseData, $this->saleresponseData);
        return $this->saleresponseData;
    }

    function doSaleWithPointAndInstalment(CardInformationData $cardInformationData, $Amount, $CurrencyCode, $OrderId, $Point, $InstallmentCount , $koiCode , $merchantMessageData)
    {
		
		if( $koiCode != "")
		{
			$this->requestData['KOICode'] = $this->koiCode;
		}
		if( $merchantMessageData != "")
		{
			$this->requestData['merchantMessageData'] = $this->merchantMessageData;
		}
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
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
        $saleRequestData->MAC = $this->getMAcWithCardInfo($saleRequestData->CardInformationData);
        $saleRequestData->MACParams = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        if($saleRequestData->InstallmentCount>1)
            $saleRequestData->InstallmentType = 'Y';
        else
            $saleRequestData->InstallmentType = 'N';
        $saleRequestData->MerchantNo = $this->requestData['MerchantNo'];  
        $saleRequestData->TerminalNo = $this->requestData['TerminalNo']; 
        $this->requestData = $saleRequestData;
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Sale");
        $this->saleresponseData = new SaleResponseData();
        $this->saleresponseData = $this->array_to_obj($this->responseData, $this->saleresponseData);
        return $this->saleresponseData;
    }

    // Auth
    function doAuth(CardInformationData $cardInformationData, $Amount, $CurrencyCode, $OrderId , $koiCode , $merchantMessageData)
    {
		
		if( $koiCode != "")
		{
			$this->requestData['KOICode'] = $this->koiCode;
		}
		if( $merchantMessageData != "")
		{
			$this->requestData['merchantMessageData'] = $this->merchantMessageData;
		}
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->requestData['PointAmount'] = $this->PointAmount = "0";
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "N";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = '0';
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Auth");
        $this->authResponseData = new AuthResponseData();
        $this->authResponseData = $this->array_to_obj($this->responseData, $this->authResponseData);
        return $this->authResponseData;
    }

    function doAuthWithInstallment(CardInformationData $cardInformationData, $Amount, $CurrencyCode, $OrderId, $InstallmentCount , $koiCode , $merchantMessageData )
    {
		
				
		if( $koiCode != "")
		{
			$this->requestData['KOICode'] = $this->koiCode;
		}
		if( $merchantMessageData != "")
		{
			$this->requestData['merchantMessageData'] = $this->merchantMessageData;
		}
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
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
        $authRequestData->MAC = $this->getMAcWithCardInfo($saleRequestData->CardInformationData);
        $authRequestData->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        if($authRequestData->InstallmentCount>1)
            $authRequestData->InstallmentType = 'Y';
            else
                $authRequestData->InstallmentType = 'N';
        $authRequestData->MerchantNo = $this->requestData['MerchantNo'];
        $authRequestData->TerminalNo = $this->requestData['TerminalNo']; 
        $this->responseData = $this->doTransaction(json_encode($authRequestData, true, JSON_UNESCAPED_UNICODE), "Auth");
        $this->authResponseData = new AuthResponseData();
        $this->authResponseData = $this->array_to_obj($this->responseData, $this->authResponseData);
        return $this->authResponseData;
    }

    // Capture
    function doCapture($Amount, $CurrencyCode, $ReferenceCode)
    {
        $this->requestData['MAC'] = $this->getMac();
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo";
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['ReferenceCode'] = $ReferenceCode;
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = 0;
        unset($this->requestData['PaymentInstrumentType']);
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Capture");
        $this->captureResponseData = new CaptureResponseData();
        $this->captureResponseData = $this->array_to_obj($this->responseData, $this->captureResponseData);
        return $this->captureResponseData;
    }

    function doCaptureWithInstallment($Amount, $CurrencyCode, $ReferenceCode, $InstallmentCount)
    {
        $this->requestData['MAC'] = $this->getMac();
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo";
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = $InstallmentCount;
        $this->requestData['ReferenceCode'] = $ReferenceCode;
        unset($this->requestData['PaymentInstrumentType']);
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Capture");
        $this->captureResponseData = new CaptureResponseData();
        $this->captureResponseData = $this->array_to_obj($this->responseData, $this->captureResponseData);
        return $this->captureResponseData;
    }

    // Vft
    function doVft(CardInformationData $cardInformationData, $Amount, $CurrencyCode, $OrderID, $InstallmentCount, $VftCode ,$koiCode , $merchantMessageData )
    {
		
		if( $koiCode != "")
		{
			$this->requestData['KOICode'] = $this->koiCode;
		}
		if( $merchantMessageData != "")
		{
			$this->requestData['merchantMessageData'] = $this->merchantMessageData;
		}
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
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
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($vftRequestData->CardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->responseData = $this->doTransaction(json_encode($vftRequestData, true, JSON_UNESCAPED_UNICODE), "Vft");
        $this->vftResponseData = new VftResponseData();
        $this->vftResponseData = $this->array_to_obj($this->responseData, $this->vftResponseData);
        return $this->vftResponseData;
    }

    // DoPointUsage
    function doPointUsage(CardInformationData $cardInformationData, $Amount, $CurrencyCode, $OrderId)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->requestData['PointAmount'] = $this->PointAmount = "0";
        $this->requestData['OrderId'] = $OrderId;
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "PointUsage");
        $this->pointUsageResponseData = new PointUsageResponseData();
        $this->pointUsageResponseData = $this->array_to_obj($this->responseData, $this->pointUsageResponseData);
        return $this->pointUsageResponseData;
    }

    function doPointUsagetWithCustom(PointUsageRequestData $pointUsageRequestData)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($pointUsageRequestData->CardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->responseData = $this->doTransaction(json_encode($pointUsageRequestData, true, JSON_UNESCAPED_UNICODE), "PointUsage");
        $this->pointUsageResponseData = new PointUsageResponseData();
        $this->pointUsageResponseData = $this->array_to_obj($this->responseData, $this->pointUsageResponseData);
        return $this->pointUsageResponseData;
    }

    // DoReturn
    function doReturnWithOrederId($Amount, $CurrencyCode, $OrderId)
    {
        $this->requestData['MAC'] = $this->getMACOrderId($OrderId);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:OrderId";
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        unset($this->requestData['PaymentInstrumentType']);
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Return");
        $this->returnResponseData = new ReturnResponseData();
        $this->returnResponseData = $this->array_to_obj($this->responseData, $this->returnResponseData);
        return $this->returnResponseData;
    }

    function doReturnWithReferenceCode($Amount, $CurrencyCode, $ReferenceCode)
    {
        $this->requestData['MAC'] = $this->getMACReference($ReferenceCode);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:ReferenceCode";
        $this->requestData['ReferenceCode'] = $ReferenceCode;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        unset($this->requestData['PaymentInstrumentType']);
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Return");
        $this->returnResponseData = new ReturnResponseData();
        $this->returnResponseData = $this->array_to_obj($this->responseData, $this->returnResponseData);
        return $this->returnResponseData;
    }
	
	function doUnmatchedReturn(CardInformationData $cardInformationData, $Amount, $CurrencyCode, $OrderId)
    {
		$this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo";
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "UnmatchedReturn");
        $this->UnmatchedReturnResponseData = new UnmatchedReturnResponseData();
        $this->UnmatchedReturnResponseData = $this->array_to_obj($this->responseData, $this->UnmatchedReturnResponseData);
        return $this->UnmatchedReturnResponseData;
    }

    function doPointUsageReturnWithOrederId($Amount, $CurrencyCode, $OrderId)
    {
        $this->requestData['MAC'] = $this->getMACOrderId($OrderId);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:OrderId";
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        unset($this->requestData['PaymentInstrumentType']);
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "PointReturn");
        $this->pointUsageReturnResponseData = new PointUsageReturnResponseData();
        $this->pointUsageReturnResponseData = $this->array_to_obj($this->responseData, $this->pointUsageReturnResponseData);
        return $this->pointUsageReturnResponseData;
    }

    function doPointUsageReturnWithReferenceCode($Amount, $CurrencyCode, $ReferenceCode)
    {
        $this->requestData['MAC'] = $this->getMACReference($ReferenceCode);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:ReferenceCode";
        $this->requestData['ReferenceCode'] = $ReferenceCode;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        unset($this->requestData['PaymentInstrumentType']);
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "PointReturn");
        $this->pointUsageReturnResponseData = new PointUsageReturnResponseData();
        $this->pointUsageReturnResponseData = $this->array_to_obj($this->responseData, $this->pointUsageReturnResponseData);
        return $this->pointUsageReturnResponseData;
    }

    // DoReverse
    function doReverseWithReferenceCode( $ReferenceCode)
    {
        $this->requestData['MAC'] = $this->getMACReference($ReferenceCode);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:ReferenceCode";
        $this->requestData['ReferenceCode'] = $ReferenceCode;
        unset($this->requestData['PaymentInstrumentType']);
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Reverse");
        $this->reverseResponseData = new ReverseResponseData();
        $this->reverseResponseData = $this->array_to_obj($this->responseData, $this->reverseResponseData);
        return $this->reverseResponseData;
    }

    function doReverseWithOrderId( $OrderId)
    {
        $this->requestData['MAC'] = $this->getMACOrderId($OrderId);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:OrderId";
        $this->requestData['OrderId'] = $OrderId;
        unset($this->requestData['PaymentInstrumentType']);
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Reverse");
        $this->reverseResponseData = new ReverseResponseData();
        $this->reverseResponseData = $this->array_to_obj($this->responseData, $this->reverseResponseData);
        return $this->reverseResponseData;
    }

    /*
     * yaln�z belge i�lemi �in a�a��daki fonksiyon kullan�lmal�, di�erlerinde yukaridakilerden biri
     */
    function doReverse( $ReferenceCode, $OrderId)
    {
        $this->requestData['MAC'] = $this->getMACReferenceAndOrderId($ReferenceCode, $OrderId);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:ReferenceCode:OrderId";
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['ReferenceCode'] = $ReferenceCode;
        unset($this->requestData['PaymentInstrumentType']);
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Reverse");
        $this->reverseResponseData = new ReverseResponseData();
        $this->reverseResponseData = $this->array_to_obj($this->responseData, $this->reverseResponseData);
        return $this->reverseResponseData;
    }

    // DoVftQuery
    function doVftQuery(CardInformationData $cardInformationData, $Amount, $InstallmentCount, $VftCode)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->requestData['InstallmentType'] = $this->InstallmentType = "Y";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = $InstallmentCount;
        $this->requestData['VFTCode'] = $VftCode;
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "VftQuery");
        $this->vftQueryResponseData = new VftQueryResponseData();
        $this->vftQueryResponseData = $this->array_to_obj($this->responseData, $this->vftQueryResponseData);
        return $this->vftQueryResponseData;
    }

    function doVftQueryWithCustom(VftQueryRequestData $vftQueryRequestData)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($vftQueryRequestData->CardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->responseData = $this->doTransaction(json_encode($vftQueryRequestData, true, JSON_UNESCAPED_UNICODE), "VftQuery");
        $this->vftQueryResponseData = new VftQueryResponseData();
        $this->vftQueryResponseData = $this->array_to_obj($this->responseData, $this->vftQueryResponseData);
        return $this->vftQueryResponseData;
    }

    // DoKOICampaignQuery
    function doKOICampaignQuery(CardInformationData $cardInformationData)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "KOICampaignQuery");
        $this->koiCampaignQueryData = new KOICampaignQueryData();
        $this->koiCampaignQueryData = $this->array_to_obj($this->responseData, $this->koiCampaignQueryData);
        return $this->koiCampaignQueryData;
    }

    function doKOICampaignQueryWithCustom(KOICampaignQueryRequestData $koiCampaignQueryRequestData)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($koiCampaignQueryRequestData->cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->responseData = $this->doTransaction(json_encode($koiCampaignQueryRequestData, true, JSON_UNESCAPED_UNICODE), "KOICampaignQuery");
        $this->koiCampaignQueryData = new KOICampaignQueryData();
        $this->koiCampaignQueryData = $this->array_to_obj($this->responseData, $this->koiCampaignQueryData);
        return $this->koiCampaignQueryData;
    }

    // PointInquiry
    function doPointInquiry(CardInformationData $cardInformationData)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "PointInquiry");
        $this->pointInquiryResponseData = new PointInquiryResponseData();
        $this->pointInquiryResponseData = $this->array_to_obj($this->responseData, $this->pointInquiryResponseData);
        return $this->pointInquiryResponseData;
    }

    function doPointInquiryWithCustom(PointInquiryRequestData $pointInquiryRequestData)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($pointInquiryRequestData->CardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->responseData = $this->doTransaction(json_encode($pointInquiryRequestData, true, JSON_UNESCAPED_UNICODE), "PointInquiry");
        $this->pointInquiryResponseData = new PointInquiryResponseData();
        $this->pointInquiryResponseData = $this->array_to_obj($this->responseData, $this->pointInquiryResponseData);
        return $this->pointInquiryResponseData;
    }

    // Turkcell
    function doTurkcellSale(CardInformationData $cardInformationData, $OrderId, $packetCode, $gsmNo)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['PacketCode'] = $packetCode;
        $this->requestData['GsmNo'] = $gsmNo;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "TurkcellSale");
        $this->turkcellSaleResponseData = new TurkcellSaleResponseData();
        $this->turkcellSaleResponseData = $this->array_to_obj($this->responseData, $this->turkcellSaleResponseData);
        return $this->turkcellSaleResponseData;
    }

    function doTurkcellSaleWithCustom(TurkcellSaleRequestData $turkcellSaleRequestData)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($turkcellSaleRequestData->CardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->responseData = $this->doTransaction(json_encode($turkcellSaleRequestData, true, JSON_UNESCAPED_UNICODE), "Turkcell");
        $this->turkcellSaleResponseData = new TurkcellSaleResponseData();
        $this->turkcellSaleResponseData = $this->array_to_obj($this->responseData, $this->turkcellSaleResponseData);
        return $this->turkcellSaleResponseData;
    }

    // DoAgreement
    function doAgreement($OrderId)
    {
        $this->requestData['MAC'] = $this->getMac();
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo";
        $this->requestData['OrderId'] = $OrderId;
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "Agreement");
        $this->agreementResponseData = new AgreementResponseData();
        $this->agreementResponseData = $this->array_to_obj($this->responseData, $this->agreementResponseData);
        return $this->agreementResponseData;
    }

    //
    // TRIO
    //
    function doTrioSingleWithTerminalDayCount(CardInformationData $cardInformationData, $Amount, $CurrencyCode, $OrderId, $firmTerminalId, $extraRefNo, $terminalDayCount)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['FirmTerminalId'] = $firmTerminalId;
        $this->requestData['ExtraRefNo'] = $extraRefNo;
        $this->requestData['TerminalDayCount'] = $terminalDayCount;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "TrioSingle");
        $this->trioSingleResponseData = new TrioSingleResponseData();
        $this->trioSingleResponseData = $this->array_to_obj($this->responseData, $this->trioSingleResponseData);
        return $this->trioSingleResponseData;
    }

    function doTrioSingleWithDueDate(CardInformationData $cardInformationData, $Amount, $CurrencyCode, $OrderId, $firmTerminalId, $extraRefNo, $dueDate)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['FirmTerminalId'] = $firmTerminalId;
        $this->requestData['ExtraRefNo'] = $extraRefNo;
        $this->requestData['DueDate'] = $dueDate;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "TrioSingle");
        $this->trioSingleResponseData = new TrioSingleResponseData();
        $this->trioSingleResponseData = $this->array_to_obj($this->responseData, $this->trioSingleResponseData);
        return $this->trioSingleResponseData;
    }

    function doTrioSingleWithCustom(TrioSingleRequestData $trioSingleRequestData)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($trioSingleRequestData->CardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->responseData = $this->doTransaction(json_encode($trioSingleRequestData, true, JSON_UNESCAPED_UNICODE), "TrioSingle");
        $this->trioSingleResponseData = new TrioSingleResponseData();
        $this->trioSingleResponseData = $this->array_to_obj($this->responseData, $this->trioSingleResponseData);
        return $this->trioSingleResponseData;
    }

    function doTrioMultipleWithTerminalDayCount(CardInformationData $cardInformationData, $Amount, $CurrencyCode, $OrderId, $InstallmentCount, $firmTerminalId, $extraRefNo, $terminalDayCount)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "Y";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = $InstallmentCount;
        $this->requestData['FirmTerminalId'] = $firmTerminalId;
        $this->requestData['ExtraRefNo'] = $extraRefNo;
        $this->requestData['TerminalDayCount'] = $terminalDayCount;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "TrioMultiple");
        $this->trioMultipleResponseData = new TrioMultipleResponseData();
        $this->trioMultipleResponseData = $this->array_to_obj($this->responseData, $this->trioMultipleResponseData);
        return $this->trioMultipleResponseData;
    }

    function doTrioMultipleWithDueDate(CardInformationData $cardInformationData, $Amount, $CurrencyCode, $OrderId, $InstallmentCount, $firmTerminalId, $extraRefNo, $dueDate)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['Amount'] = $Amount;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "Y";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = $InstallmentCount;
        $this->requestData['FirmTerminalId'] = $firmTerminalId;
        $this->requestData['ExtraRefNo'] = $extraRefNo;
        $this->requestData['DueDate'] = $dueDate;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "TrioMultiple");
        $this->trioMultipleResponseData = new TrioMultipleResponseData();
        $this->trioMultipleResponseData = $this->array_to_obj($this->responseData, $this->trioMultipleResponseData);
        return $this->trioMultipleResponseData;
    }

    function doTrioMultipleWithCustom(TrioMultipleRequestData $trioMultipleRequestData)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($trioMultipleRequestData->CardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->responseData = $this->doTransaction(json_encode($trioMultipleRequestData, true, JSON_UNESCAPED_UNICODE), "TrioMultiple");
        $this->trioMultipleResponseData = new TrioMultipleResponseData();
        $this->trioMultipleResponseData = $this->array_to_obj($this->responseData, $this->trioMultipleResponseData);
        return $this->trioMultipleResponseData;
    }

    // TODO: response
    function doTrioFlexible(CardInformationData $cardInformationData, $CurrencyCode, $OrderId, $InstallmentCount, $firmTerminalId, $extraRefNo, $terminalDayCount, $dueInfoList)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['CurrencyCode'] = $CurrencyCode;
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "Y";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = $InstallmentCount;
        $this->requestData['firmTerminalId'] = $firmTerminalId;
        $this->requestData['extraRefNo'] = $extraRefNo;
        $this->requestData['terminalDayCount'] = $terminalDayCount;
        $this->requestData['DueInfo'] = $dueInfoList;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "TrioFlexible");
        $this->TrioFlexibleResponseData = new TrioFlexibleResponseData();
        $this->TrioFlexibleResponseData = $this->array_to_obj($this->responseData, $this->TrioFlexibleResponseData);
        return $this->TrioFlexibleResponseData;
    }

    function doTrioFlexiblWithCustom(TrioFlexibleRequestData $trioFlexibleRequestData)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($trioFlexibleRequestData->CardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->responseData = $this->doTransaction(json_encode($trioFlexibleRequestData, true, JSON_UNESCAPED_UNICODE), "TrioFlexible");
        $this->TrioFlexibleResponseData = new TrioFlexibleResponseData();
        $this->TrioFlexibleResponseData = $this->array_to_obj($this->responseData, $this->TrioFlexibleResponseData);
        return $this->TrioFlexibleResponseData;
    }

    function doTrioFixed(CardInformationData $cardInformationData, $noWarranty, $amount, $currencyCode, $OrderId, $firmTerminalId, $extraRefNo)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['NoWarranty'] = $noWarranty;
        $this->requestData['Amount'] = $amount;
        $this->requestData['CurrencyCode'] = $currencyCode;
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['firmTerminalId'] = $firmTerminalId;
        $this->requestData['extraRefNo'] = $extraRefNo;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "TrioFixed");
        $this->trioFixedResponseData = new TrioFixedResponseData();
        $this->trioFixedResponseData = $this->array_to_obj($this->responseData, $this->trioFixedResponseData);
        return $this->trioFixedResponseData;
    }

    function doTrioFixedlWithCustom(TrioFixedRequestData $trioFixedRequestData)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($trioFixedRequestData->CardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->responseData = $this->doTransaction(json_encode($trioFixedRequestData, true, JSON_UNESCAPED_UNICODE), "TrioFixed");
        $this->trioFixedResponseData = new TrioFixedResponseData();
        $this->trioFixedResponseData = $this->array_to_obj($this->responseData, $this->trioFixedResponseData);
        return $this->trioFixedResponseData;
    }

    function doTrioReturnWithReferenceCode($AuthCode, $ReferenceCode)
    {
        $this->requestData['MAC'] = $this->getMACReference($ReferenceCode);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:ReferenceCode";
        ;
        $this->requestData['AuthCode'] = $AuthCode;
        $this->requestData['ReferenceCode'] = $ReferenceCode;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "TrioReturn");
        $this->trioReturnResponseData = new TrioReturnResponseData();
        $this->trioReturnResponseData = $this->array_to_obj($this->responseData, $this->trioReturnResponseData);
        return $this->trioReturnResponseData;
    }

    function doTrioReturnWithOrderId($AuthCode, $OrderId)
    {
        $this->requestData['MAC'] = $this->getMACOrderId($OrderId);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:OrderId";
        $this->requestData['AuthCode'] = $AuthCode;
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "TrioReturn");
        $this->trioReturnResponseData = new TrioReturnResponseData();
        $this->trioReturnResponseData = $this->array_to_obj($this->responseData, $this->trioReturnResponseData);
        return $this->trioReturnResponseData;
    }

    function doTrioAvailableLimitInquiry(CardInformationData $cardInformationData)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "TrioAvailableLimitInquiry");
        $this->trioAvailableLimitInquiryResponseData = new TrioAvailableLimitInquiryResponseData();
        $this->trioAvailableLimitInquiryResponseData = $this->array_to_obj($this->responseData, $this->trioAvailableLimitInquiryResponseData);
        return $this->trioAvailableLimitInquiryResponseData;
    }

    function doTrioPaymentListInquiry(CardInformationData $cardInformationData)
    {
        $this->requestData['MAC'] = $this->getMAcWithCardInfo($cardInformationData);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:CardNo:Cvc2:ExpireDate";
        $this->requestData['CardInformationData'] = $cardInformationData;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "TrioPaymentListInquiry");
        $this->trioPaymentListInquiry = new TrioPaymentListInquiry();
        $this->trioPaymentListInquiry = $this->array_to_obj($this->responseData, $this->trioPaymentListInquiry);
        return $this->trioPaymentListInquiry;
    }

    function doTrioPaymentDelayWithOrederId($OrderId, $AuthCode, $InstallmentCount, $DueDate)
    {
        $this->requestData['MAC'] = $this->getMACOrderId($OrderId);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:OrderId";
        $this->requestData['AuthCode'] = $AuthCode;
        $this->requestData['OrderId'] = $OrderId;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "Y";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = $InstallmentCount;
        $this->requestData['DueDate'] = $dueDate;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "TrioPaymentDelay");
        $this->trioPaymentDelayResponseData = new TrioPaymentDelayResponseData();
        $this->trioPaymentDelayResponseData = $this->array_to_obj($this->responseData, $this->trioPaymentDelayResponseData);
        return $this->trioPaymentDelayResponseData;
    }

    function doTrioPaymentDelayWithReferenceCode($ReferenceCode, $AuthCode, $InstallmentCount, $DueDate)
    {
        $this->requestData['MAC'] = $this->getMACReference($ReferenceCode);
        $this->requestData['MACParams'] = "MerchantNo:TerminalNo:ReferenceCode";
        $this->requestData['AuthCode'] = $AuthCode;
        $this->requestData['ReferenceCode'] = $ReferenceCode;
        $this->requestData['InstallmentType'] = $this->InstallmentType = "Y";
        $this->requestData['InstallmentCount'] = $this->InstallmentCount = $InstallmentCount;
        $this->requestData['DueDate'] = $DueDate;
        $this->requestData['IsTDSecureMerchant'] = $this->IsTDSecureMerchant = "N";
        $this->responseData = $this->doTransaction(json_encode($this->requestData, true, JSON_UNESCAPED_UNICODE), "TrioPaymentDelay");
        $this->trioPaymentDelayResponseData = new TrioPaymentDelayResponseData();
        $this->trioPaymentDelayResponseData = $this->array_to_obj($this->responseData, $this->trioPaymentDelayResponseData);
        return $this->trioPaymentDelayResponseData;
    }

    function doTrioPaymentDelayWithCustom(TrioPaymentDelayRequestData $trioPaymentDelayRequestData)
    {
        $trioPaymentDelayRequestData->MAC = $this->getMAC();
        $trioPaymentDelayRequestData->MACParams = "MerchantNo:TerminalNo";
        $this->responseData = $this->doTransaction(json_encode($trioPaymentDelayRequestData, true, JSON_UNESCAPED_UNICODE), "TrioPaymentDelay");
        $this->trioPaymentDelayResponseData = new TrioPaymentDelayResponseData();
        $this->trioPaymentDelayResponseData = $this->array_to_obj($this->responseData, $this->trioPaymentDelayResponseData);
        return $this->trioPaymentDelayResponseData;
    }
}
?>