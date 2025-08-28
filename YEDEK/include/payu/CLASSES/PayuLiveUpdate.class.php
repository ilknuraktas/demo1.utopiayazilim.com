<?php

/* Make sure strlen behaves as intended by setting multibyte function overload to 0 */
ini_set("mbstring.func_overload", 0);
if (ini_get("mbstring.func_overload") > 2) { /* check if mbstring.func_overload is still set to overload strings(2) */
    echo "WARNING: mbstring.func_overload is set to overload strings and might cause problems\n";
}

/**
 * LiveUpdate class
 *
 * @package    PayuUtility
 * @subpackage LiveUpdate
 * @author     PAYU
 */
class PayuLu{
    const DEBUG_NONE='0';
    const DEBUG_ALL='9999';
    const DEBUG_FATAL='9990';
    const DEBUG_ERROR='2';
    const DEBUG_WARNING='1';

    const PAY_METHOD_CCVISAMC = 'CCVISAMC';

    private $_debugLevel = 0;
    private $_errorLog = '';
    private $_allErrors = array();
    private $_merchantId = '';
    private $_secretKey = '';
    private $_AutoMode = 0;
    private $_TestMode = 'FALSE';
    private $_luQueryUrl = 'https://secure.payu.com.tr/order/lu.php';
    private $_Discount;
    private $_Instalment;
    private $_Language;
    private $_OrderRef;
    private $_OrderDate;
    private $_PriceCurrency;
    private $_Currency;
    private $_BackRef;
    private $_PayMethod;
    private $_Debug;
    private $_billingAddress;
    private $_deliveryAddress;
    private $_destinationAddress;
    private $_OrderShipping = 0;
    private $_allProducts = array();
    private $_tempProds = array();
    private $_customFields = array();
    private $_htmlFormCode;
    private $_htmlCode;
    private $_htmlHashString;
    private $_hashString;
    private $_HASH;
    public $_explained;
	public $_btnName;
    /**
     * Constructor
     *
     * @param string $merchantId Merchant Id that will be used for the LiveUpdate
     * @param string $secretKey Secret Key that will be used for the LiveUpdate
     * @return int returns 1 upon success
     */
    function __construct($merchantId, $secretKey) {
        $this->_merchantId = $merchantId;   // store the merchant id
        $this->_secretKey = $secretKey;    // store the secretkey
        if (empty($merchantId) && empty($secretKey)) {
            self::_logError("MECHANT id and SECRET KEY missing");
            return 0;
        }
        $this->_allErrors[self::DEBUG_WARNING] = '';
        $this->_allErrors[self::DEBUG_ERROR] = '';
        $this->_allErrors[self::DEBUG_ALL] = '';
        return 1;
    }

    /**
     * Adds Address for the delivery set
     *
     * @param PayuAddress $currentAddress the address to be used as the delivery
     * @return int returns 1 upon success
     */
    public function setDeliveryAddress(PayuAddress $currentAddress) {
        if ($currentAddress) {
            $this->_deliveryAddress = $currentAddress;
            $possibleErrors = $currentAddress->validate(); // read errors for the current product
            $this->_mergeErrorLogs($possibleErrors);
            return 1;
        }
        return 0;
    }

    /**
     * Adds Address for the billing set
     *
     * @param PayuAddress $currentAddress the address to be used as the billing
     * @return int returns 1 upon success
     */
    public function setBillingAddress(PayuAddress $currentAddress) {
        if ($currentAddress) {
			if (empty($currentAddress->email)) {
				$this->_logError("Email is madatory.");
			}
			if (empty($currentAddress->firstName)) {
				$this->_logError("First Name is madatory.");
			}
			if (empty($currentAddress->lastName)) {
				$this->_logError("Last Name is madatory.");
			}
			if ((is_array($this->_errorLog) && count($this->_errorLog) >0) || (is_string($this->_errorLog) && strlen($this->_errorLog) >0)) {
				return 0;
			}
            $this->_billingAddress = $currentAddress;
            $possibleErrors = $currentAddress->validate(); // read errors for the current product
			
            $this->_mergeErrorLogs($possibleErrors);
            return 1;
        }
        return 0;
    }

    /**
     * Adds Address for the destination set
     *
     * @param PayuAddress $currentAddress the address to be used as the billing
     * @return int returns 1 upon success
     */
    public function setDestinationAddress(PayuAddress $currentAddress) {
        if ($currentAddress) {
            $this->_destinationAddress = $currentAddress;
            $possibleErrors = $currentAddress->validate(); // read errors for the current product
            $this->_mergeErrorLogs($possibleErrors);
            return 1;
        }
        return 0;
    }

    /**
     * Adds Products to be sent to PAYU via LiveUpdate
     *
     * @param PayuProduct $currentProduct the product to be added
     * @return int returns 1 upon success
     */
    public function addProduct(PayuProduct $currentProduct) {
        if ($currentProduct) {
            $this->_allProducts[] = $currentProduct; // add the current product
            $possibleErrors = $currentProduct->validate(); // read errors for the current product
            $this->_mergeErrorLogs($possibleErrors);
            return 1;
        }
        return 0;
    }

    /**
     * Method will render all the fields needed for the Payment request
     *
     * @return string contains all the errors encountered
     */
    public function renderPaymentInputs() {
        $this->_validate();
        $this->_setOrderDate();
        $this->_makeHashString();
        $this->_makeHash();
        $this->_makeFields();
        if (!empty($this->_allErrors[$this->_debugLevel]))
            echo $this->_allErrors[$this->_debugLevel]; // print the error level
        echo $this->_htmlFormCode;
        return $this->_allErrors[self::DEBUG_ALL];
    }

    /**
     * Method will render the form needed needed for the Payment request
     *
     * @param  boolean $autoSubmit this will autosubmit the form upon rendering
     * @return string all errors that have been generated
     */
    public function renderPaymentForm($autoSubmit=FALSE) {
        $this->_validate();
        $this->_setOrderDate();
        $this->_makeHashString();
        $this->_makeHash();
        $this->_makeFields();
        if (!empty($this->_allErrors[$this->_debugLevel]))
            return $this->_allErrors[$this->_debugLevel]; // print the error level
        $this->_makeForm($autoSubmit);

        return $this->_htmlCode.$this->_allErrors[self::DEBUG_ALL];;
      //  return 
    }

    /**
     * Method will gather and assemble all the fields needed for the form
     *
     * @return int 1 on success
     */
    private function _makeFields() {
        $this->_htmlFormCode .= $this->_addInput('MERCHANT', $this->_merchantId);
        $this->_htmlFormCode .= $this->_addInput('ORDER_HASH', $this->_HASH);
        $this->_htmlFormCode .= (!empty($this->_BackRef) ? $this->_addInput('BACK_REF', $this->_BackRef) : "");
        $this->_htmlFormCode .= $this->_addInput('LANGUAGE', (empty($this->_Language) ? "" : $this->_Language));
        $this->_htmlFormCode .= $this->_addInput('ORDER_REF', (empty($this->_OrderRef) ? "" : $this->_OrderRef));
        $this->_htmlFormCode .= $this->_addInput('INSTALLMENT_OPTIONS', (empty($this->_Instalment) ? "" : $this->_Instalment));
        $this->_htmlFormCode .= $this->_addInput('ORDER_DATE', (empty($this->_OrderDate) ? "" : $this->_OrderDate));
        $this->_htmlFormCode .= $this->_addInput('DESTINATION_CITY', (empty($this->_destinationAddress->city) ? "" : $this->_destinationAddress->city));
        $this->_htmlFormCode .= $this->_addInput('DESTINATION_STATE', (empty($this->_destinationAddress->state) ? "" : $this->_destinationAddress->state));
        $this->_htmlFormCode .= $this->_addInput('DESTINATION_COUNTRY', (empty($this->_destinationAddress->countryCode) ? "" : $this->_destinationAddress->countryCode));
        $this->_htmlFormCode .= $this->_addInput('ORDER_SHIPPING', (empty($this->_OrderShipping) ? "" : $this->_OrderShipping));

        $this->_htmlFormCode .= (!empty($this->_billingAddress->firstName) ? $this->_addInput('BILL_FNAME', $this->_billingAddress->firstName) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->lastName) ? $this->_addInput('BILL_LNAME', $this->_billingAddress->lastName) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->ciSerial) ? $this->_addInput('BILL_CISERIAL', $this->_billingAddress->ciSerial) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->cnp) ? $this->_addInput('BILL_CNP', $this->_billingAddress->cnp) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->company) ? $this->_addInput('BILL_COMPANY', $this->_billingAddress->company) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->fiscalCode) ? $this->_addInput('BILL_FISCALCODE', $this->_billingAddress->fiscalCode) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->regNumber) ? $this->_addInput('BILL_REGNUMBER', $this->_billingAddress->regNumber) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->bank) ? $this->_addInput('BILL_BANK', $this->_billingAddress->bank) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->bankAccount) ? $this->_addInput('BILL_BANKACCOUNT', $this->_billingAddress->bankAccount) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->email) ? $this->_addInput('BILL_EMAIL', $this->_billingAddress->email) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->phone) ? $this->_addInput('BILL_PHONE', $this->_billingAddress->phone) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->fax) ? $this->_addInput('BILL_FAX', $this->_billingAddress->fax) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->address) ? $this->_addInput('BILL_ADDRESS', $this->_billingAddress->address) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->address2) ? $this->_addInput('BILL_ADDRESS2', $this->_billingAddress->address2) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->zipCode) ? $this->_addInput('BILL_ZIPCODE', $this->_billingAddress->zipCode) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->city) ? $this->_addInput('BILL_CITY', $this->_billingAddress->city) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->state) ? $this->_addInput('BILL_STATE', $this->_billingAddress->state) : "");
        $this->_htmlFormCode .= (!empty($this->_billingAddress->countryCode) ? $this->_addInput('BILL_COUNTRYCODE', $this->_billingAddress->countryCode) : "");

        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->firstName) ? $this->_addInput('DELIVERY_FNAME', $this->_deliveryAddress->firstName) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->lastName) ? $this->_addInput('DELIVERY_LNAME', $this->_deliveryAddress->lastName) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->ciSerial) ? $this->_addInput('DELIVERY_CISERIAL', $this->_deliveryAddress->ciSerial) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->cnp) ? $this->_addInput('DELIVERY_CNP', $this->_deliveryAddress->cnp) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->company) ? $this->_addInput('DELIVERY_COMPANY', $this->_deliveryAddress->company) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->fiscalCode) ? $this->_addInput('DELIVERY_FISCALCODE', $this->_deliveryAddress->fiscalCode) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->regNumber) ? $this->_addInput('DELIVERY_REGNUMBER', $this->_deliveryAddress->regNumber) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->bank) ? $this->_addInput('DELIVERY_BANK', $this->_deliveryAddress->bank) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->bankAccount) ? $this->_addInput('DELIVERY_BANKACCOUNT', $this->_deliveryAddress->bankAccount) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->email) ? $this->_addInput('DELIVERY_EMAIL', $this->_deliveryAddress->email) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->phone) ? $this->_addInput('DELIVERY_PHONE', $this->_deliveryAddress->phone) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->fax) ? $this->_addInput('DELIVERY_FAX', $this->_deliveryAddress->fax) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->address) ? $this->_addInput('DELIVERY_ADDRESS', $this->_deliveryAddress->address) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->address2) ? $this->_addInput('DELIVERY_ADDRESS2', $this->_deliveryAddress->address2) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->zipCode) ? $this->_addInput('DELIVERY_ZIPCODE', $this->_deliveryAddress->zipCode) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->city) ? $this->_addInput('DELIVERY_CITY', $this->_deliveryAddress->city) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->state) ? $this->_addInput('DELIVERY_STATE', $this->_deliveryAddress->state) : "");
        $this->_htmlFormCode .= (!empty($this->_deliveryAddress->countryCode) ? $this->_addInput('DELIVERY_COUNTRYCODE', $this->_deliveryAddress->countryCode) : "");

        $this->_htmlFormCode .= $this->_addInput('DISCOUNT', $this->_Discount);
        $this->_htmlFormCode .= $this->_addInput('PAY_METHOD', $this->_PayMethod);

        $productIterator = 0;
        foreach ($this->_tempProds as $prodCode => $product) {
            $this->_htmlFormCode .=$this->_addInput('ORDER_PNAME[' . $productIterator . ']', $product['prodName']);
            $this->_htmlFormCode .=$this->_addInput('ORDER_PCODE[' . $productIterator . ']', $prodCode);
            $this->_htmlFormCode .=$this->_addInput('ORDER_PINFO[' . $productIterator . ']', (empty($product['prodInfo']) ? '' : $product['prodInfo']));
            $this->_htmlFormCode .=$this->_addInput('ORDER_PRICE[' . $productIterator . ']', $product['prodPrice']);
            $this->_htmlFormCode .=$this->_addInput('ORDER_QTY[' . $productIterator . ']', $product['prodQuantity']);
            $this->_htmlFormCode .=$this->_addInput('ORDER_VAT[' . $productIterator . ']', $product['prodVat']);
            $this->_htmlFormCode .=$this->_addInput('ORDER_PRICE_TYPE[' . $productIterator . ']', $product['prodPriceType']);
            $this->_htmlFormCode .=$this->_addInput('LU_COMPLEX_PDISCOUNT_PERC[' . $productIterator . ']', (empty($product['discount']) ? '' : $product['discount']));

            foreach ($product['customFields'] as $customFieldName => $customFieldValue) {
                $this->_htmlFormCode .=$this->_addInput('ORDER_PCUSTOMFIELD[' . $productIterator . '][' . $customFieldName . ']', $customFieldValue);
            }
            $productIterator++;
        }

        $this->_htmlFormCode .= $this->_addInput('PRICES_CURRENCY', $this->_PriceCurrency);
        $this->_htmlFormCode .= (!empty($this->_Currency) ? $this->_addInput('CURRENCY', $this->_Currency) : "");
        $this->_htmlFormCode .= (!empty($this->_Debug) ? $this->_addInput('DEBUG', "TRUE") : "");
        $this->_htmlFormCode .= (!empty($this->_TestMode) ? $this->_addInput('TESTORDER', $this->_TestMode) : "");
        $this->_htmlFormCode .= (!empty($this->_AutoMode) ? $this->_addInput('AUTOMODE', "1") : "");
        $this->_htmlFormCode .= (!empty($this->_OrderTimeout) ? $this->_addInput('ORDER_TIMEOUT', $this->_OrderTimeout) : "");
        $this->_htmlFormCode .= (!empty($this->_OrderTimeoutUrl) ? $this->_addInput('TIMEOUT_URL', $this->_OrderTimeoutUrl) : "");

        foreach ($this->_customFields as $customFieldName => $customFieldValue) {
            $this->_htmlFormCode .=$this->_addInput(strtoupper($customFieldName), $customFieldValue);
        }
        return 1;
    }

    /**
     * Method will generate the actual FORM
     *
     * @param boolean $autoSubmit makes the form autosubmit
     * @return int 1 on success
     */
    private function _makeForm($autoSubmit=FALSE) {
        $this->_htmlCode .= '<form action="' . $this->_luQueryUrl . '" method="POST" id="payForm" name="payForm"/>' . "\n";
        $this->_htmlCode .=$this->_htmlFormCode;
        if ($autoSubmit === FALSE) {
            $this->_htmlCode .='<input type="submit" value="'.$this->_btnName.'">' . "\n";
        }
        $this->_htmlCode .= '</form>';

        if ($autoSubmit === TRUE) {
            $this->_htmlCode .= "
                    <script>
                    document.payForm.submit();
                    </script>
                    ";
        }
        return 1;
    }

    /**
     * Method will assemble the hash string
     *
     * @return int 1 on success
     */
    private function _makeHashString() {

        $finalPriveType = '';

        $this->_hashString = $this->_addHashValue($this->_merchantId, 'MerchantId');
        $this->_hashString .= $this->_addHashValue($this->_OrderRef, 'OrderRef');
        $this->_hashString .= $this->_addHashValue($this->_OrderDate, 'OrderDate');

        foreach ($this->_allProducts as $product) {
            $tempProd['prodName'] = $product->productName;
            $tempProd['prodInfo'] = $product->productInfo;
            $tempProd['prodPrice'] = $product->productPrice;
            $tempProd['prodQuantity'] = $product->productQuantity;
            $tempProd['prodVat'] = $product->productVat;
            $tempProd['prodPriceType'] = $product->productPriceType;
            $tempProd['customFields'] = $product->customFields;
            $tempProd['discount'] = $product->Discount;

            if (!empty($tempProds[$product->productCode]['prodQuantity'])) {
                if ($tempProds[$product->productCode]['prodPrice'] != $product->productPrice) {
                    $this->_logError("Found more entries with same product code: " . $product->productCode . " (product code must be unique) and different prices");
                    $tempProds[$product->productCode] = $tempProd;
                } else {
                    $this->_logError("Found more entries with same product code: " . $product->productCode . ", merged into 1", 1);
                    $tempProds[$product->productCode]['prodQuantity']+=$product->productQuantity;
                }
            } else {
                $tempProds[$product->productCode] = $tempProd;
            }
        }

        $prodNames = '';
        $prodInfo = '';
        $prodPrice = '';
        $prodQuantity = '';
        $prodVat = '';
        $prodCodes = '';
        $finalPriveType = '';
        $finalPercDiscount = '';

        $iterator = 0;
        foreach ($tempProds as $prodCode => $product) {
            $prodNames .= $this->_addHashValue($product['prodName'], 'ProductName[' . $iterator . ']');
            $prodInfo .= $this->_addHashValue((empty($product['prodInfo']) ? '' : $product['prodInfo']), 'ProductInfo[' . $iterator . ']');
            $prodPrice .= $this->_addHashValue($product['prodPrice'], 'ProductPrice[' . $iterator . ']');
            $prodQuantity .= $this->_addHashValue($product['prodQuantity'], 'ProductQuality[' . $iterator . ']');
            $prodVat .= $this->_addHashValue($product['prodVat'], 'ProductVat[' . $iterator . ']');
            $prodCodes .= $this->_addHashValue($prodCode, 'ProductCode[' . $iterator . ']');
            $finalPriveType .= $this->_addHashValue((empty($product['prodPriceType']) ? '' : $product['prodPriceType']), 'ProductPriceType[' . $iterator . ']');
            $finalPercDiscount .= $this->_addHashValue((empty($product['discount']) ? '' : $product['discount']), 'ProductPercDiscount[' . $iterator . ']');
            $iterator++;
        }

        $this->_hashString .=$prodNames;
        $this->_hashString .=$prodCodes;
        $this->_hashString .=$prodInfo;
        $this->_hashString .=$prodPrice;
        $this->_hashString .=$prodQuantity;
        $this->_hashString .=$prodVat;


        $this->_tempProds = $tempProds;
        $this->_hashString .= $this->_addHashValue(($this->checkEmptyVar($this->_OrderShipping) ? '' : $this->_OrderShipping), 'OrderShipping');
        $this->_hashString .= $this->_addHashValue(($this->checkEmptyVar($this->_PriceCurrency) ? '' : $this->_PriceCurrency), 'PriceCurrency');
        $this->_hashString .= $this->_addHashValue((empty($this->_Discount) ? '' : $this->_Discount), 'Discount');
        $this->_hashString .= $this->_addHashValue((empty($this->_destinationAddress->city) ? '' : $this->_destinationAddress->city), 'DestinationCity');
        $this->_hashString .= $this->_addHashValue((empty($this->_destinationAddress->state) ? '' : $this->_destinationAddress->state), 'DestinationState');
        $this->_hashString .= $this->_addHashValue((empty($this->_destinationAddress->countryCode) ? '' : $this->_destinationAddress->countryCode), 'DestinationCountryCode');
        $this->_hashString .= $this->_addHashValue((empty($this->_PayMethod) ? '' : $this->_PayMethod), 'PayMethod');
        $this->_hashString .= $finalPriveType;
        $this->_hashString .= $finalPercDiscount;
        $this->_hashString .= $this->_addHashValue((empty($this->_Instalment) ? '' : $this->_Instalment), 'Instalment');

        $this->_htmlHashString = $this->_hashString;
        $this->_hashString = strip_tags($this->_hashString);

        return 1;
    }

    private function checkEmptyVar($string) {
        return (strlen(trim($string)) == 0);
    }

    /**
     * Method will calculate the hash string
     *
     * @return int 1 on success
     */
    private function _makeHash() {
        $this->_HASH = self::generateHmac($this->_secretKey, $this->_hashString);
        return 1;
    }

    /**
     * Sets the AUTOMODE for the LU query (the payment process will skip to the last step if all the data for BILLING and DELIVERY is ok)
     *
     * @return int 1 on success
     */
    public function setAutoMode() {
        $this->_AutoMode = 1;
        return 1;
    }


    /**
     * Sets the ORDER_SHIPPING for the LU query
     *
     * @return int 1 on success
     */
    public function setOrderShipping($val) {
        if (!empty($val) && ($val < 0 || !is_numeric($val))) {
            $this->_logError("Shipping must be a positive number");
        }		
        $this->_OrderShipping = $val;
        return 1;
    }	

    /**
     * Sets the TESTORDER for the LU query (Order will be processed as a test)
     *
     * @param boolean testMode parameter is default TRUE
     * @return int 1 on success
     */
    public function setTestMode() {
        $this->_TestMode = TRUE;
        return 1;
    }

    /**
     * Sets the Discount for the order must be positive number
     *
     * @param float $discount value of the Discount for the LU
     * @return int 1 on success
     */
    public function setGlobalDiscount($discount) {
        $this->_Discount = $discount;
        return 1;
    }

    public function setInstalments($Instalment) {
        $this->_Instalment = $Instalment;
        return 1;
    }

    /**
     * Sets the Language for the order
     *
     * @param string $lang value of the Language for the LU (RO, EN, etc)
     * @return int 1 on success
     */
    public function setLanguage($lang) {
        $this->_Language = $lang;
        return 1;
    }

    /**
     * Sets the Order Reference for the order this is your internal order number
     *
     * @param $refno value of the Order Reference  for the LU
     * @return int 1 on success
     */
    public function setOrderRef($refno) {
        $this->_OrderRef = $refno;
        return 1;
    }

    /**
     * Sets the Order Date for the order this is your internal order number
     *
     * @return int 1 on success
     */
    private function _setOrderDate() {
        $this->_OrderDate = date('Y-m-d H:m:s', time());
        return 1;
    }

    /**
     * Sets the Pay Method for the order
     *
     * @param string $payMethod value Payment method (please refer to the static vars in this class)
     * @return int 1 on success
     */
    public function setPayMethod($payMethod) {
        $this->_PayMethod = $payMethod;
        return 1;
    }

    /**
     * Sets the currency in which the prices are sent
     *
     * @param string $currency value of the Currency (RON, USD, GBP, etc )
     * @return int 1 on success
     */
    public function setPaymentCurrency($currency) {
        $this->_PriceCurrency = $currency;
        return 1;
    }

    /**
     * Sets the currency in which the prices will be tentatively interpreted
     *
     * @param string $currency value of the Currency
     * @return int 1 on success
     */
    public function setCurrency($currency) {
        $this->_Currency = $currency;
        return 1;
    }

    /**
     * Sets the order timeout for this order
     *
     * @param int $timeout value of the timeout
     * @return int 1 on success
     */
    public function setOrderTimeout($timeout) {
        $this->_OrderTimeout = $timeout;
        return 1;
    }

    /**
     * Sets the order timeout for this order
     *
     * @param string $url value of the url
     * @return int 1 on success
     */
    public function setTimeoutUrl($url) {
        $this->_OrderTimeoutUrl = $url;
        return 1;
    }

    /**
     * Method will retrieve the hash string
     *
     * @param boolean $debug parameter will render the hashstring more visible with the length of strings highlited
     * @return int 1 on success
     */
    public function getHashString($debug=FALSE) {
        if (!empty($this->_hashString))
            if ($debug === TRUE) {
                return "Hover on the substring for explanation:<br/><style>.puHidden{display:none;}.puInline{display: block;float: left;}</style>" . $this->_htmlHashString . ' <script type="javascript"></script>';
            }
            else
                return $this->_hashString;
        else {
            $this->_logError("Hash String not ready. Try renderPaymentForm or renderPaymentInputs first ", 1);
            return 0;
        }
    }

    /**
     * Sets the BACK_REF for the order must be a http address
     *
     * @param string $url value of the url to be redirected at the end
     * @return int 1 on success
     */
    public function setBackRef($url) {
        $this->_BackRef = $url;
        return 1;
    }

    /**
     * Sets the DEBUG for the LU., this sends a debug request to the Payment page
     *
     * @return int 1 on success
     */
    public function setTrace() {
        $this->_Debug = 1;
        return 1;
    }

    /**
     * Adds a custom field to the Live Update
     *
     * @param  string $fieldName value of the fields name
     * @param  string $fieldValue value of the field
     * @return int 1 on success
     */
    public function addCustomField($fieldName, $fieldValue) {
        if (!$fieldName) {
            self::_logError("Custom field name for PayuLu is not valid, field will be ignored", 1);
            return 0;
        }
        $this->_customFields[$fieldName] = $fieldValue;
        return 1;
    }

    /**
     * Method will do a last minute validation of the object params
     *
     * @return string contains all errors
     */
    private function _validate() {
        if (!empty($this->_Discount) && ($this->_Discount < 0 || !is_numeric($this->_Discount))) {
            $this->_logError("Discount must be a positive number");
        }

        if (!empty($this->_PayMethod) &&
                ($this->_PayMethod != self::PAY_METHOD_CCVISAMC &&
                $this->_PayMethod != self::PAY_METHOD_CCAMEX &&
                $this->_PayMethod != self::PAY_METHOD_CCDINERS &&
                $this->_PayMethod != self::PAY_METHOD_CCJCB &&
                $this->_PayMethod != self::PAY_METHOD_WIRE &&
                $this->_PayMethod != self::PAY_METHOD_PAYPAL &&
                $this->_PayMethod != self::PAY_METHOD_CASH)) {
            $this->_logError("Payment Method: " . $this->_PayMethod . " is not supported reverted to none", 1);
            $this->_PayMethod = '';
        }
        $this->_mergeErrorLogs($this->_errorLog);
        return $this->_errorLog;
    }

    /**
     * Sets the debug mode for the class
     *
     * @param int debug level constants should be used
     * @return int 1 on success
     */
    public function setDebug($debugLevel) {
        $this->_debugLevel = $debugLevel;
        return 1;
    }

    /**
     * Sets the the query url for the LiveUpdate request
     *
     * @param string the url to be used
     * @return int 1 on success
     */
    public function setQueryUrl($url) {
        $this->_luQueryUrl = $url;
        return 1;
    }

    /**
     * Sets the the query url for the LiveUpdate request
     *
     * @param string the url to be used
     * @return int 1 on success
     */
    public function setButtonName($val) {
        $this->_btnName = $val;
        return 1;
    }	
    /**
     * Method will merge all the error logs
     *
     * @param array $newLog this is the new log to be added to the main list of errors
     * @return 1 on success
     */
    private function _mergeErrorLogs($newLog) {
        if (count($newLog)) { // if there are errors and the debug is set
            if (empty($this->_allErrors[$this->_debugLevel]))  // if the entry is not set the set it to a default
                $this->_allErrors[$this->_debugLevel] = '';

            if (!empty($newLog[self::DEBUG_WARNING]) && count($newLog[self::DEBUG_WARNING]) > 0)
                $this->_allErrors[self::DEBUG_ALL].= $newLog[self::DEBUG_WARNING];

            if (!empty($newLog[self::DEBUG_ERROR]) && count($newLog[self::DEBUG_ERROR]) > 0)
                $this->_allErrors[self::DEBUG_ALL].= $newLog[self::DEBUG_ERROR];

            if (!empty($newLog[self::DEBUG_FATAL]) && count($newLog[self::DEBUG_FATAL]) > 0)
                $this->_allErrors[self::DEBUG_ALL].= $newLog[self::DEBUG_FATAL];
        }
        return 1;
    }

    /**
     * Log the errors according to the class
     *
     * @param string $errorString this is the new string to be added to the error log
     * @param int $level this is the level of the error
     * @return 1 on success
     */
    private function _logError($errorString, $level=self::DEBUG_ERROR) {

        switch ($level) {
            case self::DEBUG_FATAL:
                $debug_text = 'FATAL ERROR in';
                break;
            case self::DEBUG_ERROR:
                $debug_text = 'ERROR in';
                break;
            case self::DEBUG_WARNING:
                $debug_text = 'WARNING in';
                break;
        }

        if (empty($this->_errorLog[$level]))
            $this->_errorLog[$level] = '';

        $this->_errorLog[$level] .= $debug_text . ' ' . __CLASS__ . ': ' . $errorString . '<br/>';
        return 1;
    }

    /*
     * Utility used by the assemble function
     *
     * @param string string to be added to the hash
     * @param string name of the string
     */

    private function _addHashValue($string, $name='') {
        if ($this->checkEmptyVar($string)) {
            return '<div class="puInline" onmouseover="document.getElementById(\'' . md5($name) . '\').innerHTML=\'' . $name . '\';document.getElementById(\'' . md5($name) . '\').style.display=\'block\';this.style.border=\'1px solid\'" onmouseout="document.getElementById(\'' . md5($name) . '\').style.display=\'none\';this.style.border=\'0\'"><b style="color:red">0</b><strong id="' . md5($name) . '" class="puHidden"></strong></div>';
        } else {
            return '<div class="puInline" onmouseover="document.getElementById(\'' . md5($name) . '\').innerHTML=\'' . $name . '\';document.getElementById(\'' . md5($name) . '\').style.display=\'block\';this.style.border=\'1px solid\'" onmouseout="document.getElementById(\'' . md5($name) . '\').style.display=\'none\';this.style.border=\'0\'"><b style="color:red">' . strlen($string) . '</b>' . $string . '<strong id="' . md5($name) . '" class="puHidden"></strong></div>';
        }
    }

    /*
     * Add the input html code
     *
     * @param string name of the input
     * @param string value of the input
     */

    private function _addInput($string, $value) {
        return '<input type="hidden" name="' . strtoupper($string) . '" value="' . htmlentities($value, ENT_COMPAT, 'UTF-8') . '"/>' . "\n";
    }

    /*
     * Utility Class for calculation of Hmac sinatures
     *
     * @param string key to be used for the hmac
     * @param string data to be encoded
     */

    public static function generateHmac($key, $data) {
        $b = 64; // byte length for md5
        if (strlen($key) > $b) {
            $key = pack("H*", md5($key));
        }
        $key = str_pad($key, $b, chr(0x00));
        $ipad = str_pad('', $b, chr(0x36));
        $opad = str_pad('', $b, chr(0x5c));
        $k_ipad = $key ^ $ipad;
        $k_opad = $key ^ $opad;
        return md5($k_opad . pack("H*", md5($k_ipad . $data)));
    }

}

/**
 * PayuProduct class
 *
 * @package    PayuProduct
 * @subpackage LiveUpdate
 * @author     PAYU
 */
class PayuProduct {
    const DEBUG_NONE='0';
    const DEBUG_ALL='9999';
    const DEBUG_ERROR='2';
    const DEBUG_WARNING='1';

    const PRICE_TYPE_GROSS = 'GROSS'; // price includes VAT
    const PRICE_TYPE_NET = 'NET';   // price does not include VAT

    const PAY_OPTION_VISA = 'VISA';
    const PAY_OPTION_MASTERCARD = 'MASTERCARD';
    const PAY_OPTION_MAESTRO = 'MAESTRO';
    const PAY_OPTION_VISA_ELECTRON = 'VISA ELECTRON';
    const PAY_OPTION_ALL = 'ALL';

    const PAY_METHOD_CCVISAMC = 'CCVISAMC';
  
    public $productName = '';
    public $productCode = '';
    public $productInfo = '';
    public $productPrice = '';
    public $productPriceType = '';
    public $productQuantity = '';
    public $productVat = '';
    public $Discount = '';
    public $customFields = array();
    private $_errorLog = array();

    /**
     * Constructor
     *
     * @param string $productName name of the product
     * @param string $productCode code of the product
     * @param string $productInfo info of the product
     * @param string $productPrice price of the product
     * @param string $productPriceType prive type for the
     * @param int $productQuantity quantity for the product
     * @param string $productTax tax of the product
     * @return int returns 1 upon success
     */

    function __construct($productName='', $productCode='', $productInfo='', $productPrice='', $productPriceType='', $productQuantity='', $productTax='') {
        $this->setName($productName);
        $this->setCode($productCode);
        $this->setInfo($productInfo);
        $this->setPrice($productPrice);
        $this->setPriceType($productPriceType);
        $this->setQuantity($productQuantity);
        $this->setTax($productTax);

        return 1;
    }

    /**
     * Adds a custom field to the product
     *
     * @param string $fieldName value of the fields name
     * @param string $fieldValue value of the field
     * @return int 1 on success
     */
    public function addCustomField($fieldName, $fieldValue) {
        if (!$fieldName) {
            self::_logError("Custom field name for product with name " . $this->productName . " is not valid, field will be ignored", 1);
            return 0;
        }
        $this->customFields[$fieldName] = $fieldValue;
        return 1;
    }

    /**
     * Sets the product code for the current product must be unique for each product
     *
     * @param string $productName value of the product code
     * @return int 1 on success
     */
    public function setName($productName) {
        $this->productName = $productName;
        return 1;
    }

    /**
     * Sets the product code for the current product must be unique for each product
     *
     * @param string $setCode value of the product code
     * @return int 1 on success
     */
    public function setCode($setCode) {
        $this->productCode = $setCode;
        return 1;
    }

    /**
     * Sets the information for the current product (long description) it is optional
     *
     * @param string $productInfo value of the information
     * @return int 1 on success
     */
    public function setInfo($productInfo) {
        $this->productInfo = $productInfo;
        return 1;
    }

    /**
     * Sets the Price for the current product must be above zero
     *
     * @param float $productPrice value of the price must be a above zero
     * @return int 1 on success
     */
    public function setPrice($productPrice) {
        $this->productPrice = $productPrice;
        return 1;
    }

    /**
     * Sets the Price Type for the current product must be either NET or GROSS
     *
     * @param string $productPriceType value of the Price Type must be either NET or GROSS
     * @return int 1 on success
     */
    public function setPriceType($productPriceType) {
        $this->productPriceType = $productPriceType;
        return 1;
    }

    /**
     * Sets the Quantity for the current product
     *
     * @param int $productQuantity value of the quantity must be a integer
     * @return int 1 on success
     */
    public function setQuantity($productQuantity) {
        $this->productQuantity = $productQuantity;
        return 1;
    }

    /**
     * Sets the VAT (TAX) for the current product
     *
     * @param int $productVat value of the VAT
     * @return int 1 on success
     */
    public function setTax($productVat) {
        $this->productVat = $productVat;
        return 1;
    }

    /**
     * Sets the discount per product
     *
     * @param int $discountPercent value of the discount to be applied
     * @param string $discountPaymentMethod the payment method for which the discount applies
     * @param string $discountPaymentOptions the payment option for which the discount applies
     * @return int 1 on success
     */
    public function setDiscount($discountPercent, $discountPaymentMethod, $discountPaymentOptions = PayuProduct::PAY_OPTION_ALL) {

        if (!empty($discountPaymentOptions)) {
            if (!in_array($discountPaymentOptions, array(self::PAY_OPTION_VISA, self::PAY_OPTION_VISA_ELECTRON, self::PAY_OPTION_MASTERCARD, self::PAY_OPTION_MAESTRO, self::PAY_OPTION_ALL))) {
                $discountPaymentOptions = self::PAY_OPTION_ALL;
                self::_logError(" Payment Option for product with name " . $this->productName . " is not valid assumed ALL", 1);
            }
        } else {
            $discountPaymentOptions = self::PAY_OPTION_ALL;
            self::_logError(" Payment Option for product with name " . $this->productName . " is not valid assumed ALL", 1);
        }

        if (empty($discountPaymentMethod)) {
            self::_logError(" Payment Method is missing for product with name " . $this->productName . " discount will be ignored", 1);
            return 0;
        } else {
            if (!in_array($discountPaymentMethod, array(self::PAY_METHOD_CCVISAMC, self::PAY_METHOD_CCAMEX, self::PAY_METHOD_CCDINERS, self::PAY_METHOD_CCJCB, self::PAY_METHOD_WIRE, self::PAY_METHOD_PAYPAL, self::PAY_METHOD_CASH))) {
                self::_logError(" Payment Method is missing for product with name " . $this->productName . " discount will be ignored", 1);
                return 0;
            }

            if ($discountPaymentMethod != self::PAY_METHOD_CCVISAMC && $discountPaymentOptions != self::PAY_OPTION_ALL) {
                self::_logError(" Payment Method is incompatible with Payment Option for product with name " . $this->productName . " Payment Option will be assumed as  PayuProduct::PAY_OPTION_ALL", 1);
            }
            $discountPaymentOptions = self::PAY_OPTION_ALL;
        }

        $formatedDiscountPercent = number_format($discountPercent, 2);
        if (!empty($discountPercent)) {
            if ($formatedDiscountPercent != $discountPercent) {
                self::_logError(" Discount percent for product with name " . $this->productName . " has more then 2 zecimals and was truncated ", 1);
                $discountPercent = $formatedDiscountPercent;
            }

            if ($discountPercent <= 0)
                self::_logError(" Discount percent for product with name " . $this->productName . " must be a positive number ", 2);

            if ($discountPercent > 99.9)
                self::_logError(" Discount percent for product with name " . $this->productName . " must be a below 99.9 ", 2);
        } else {
            self::_logError(" Payment Method is missing for product with name " . $this->productName . " discount will be ignored", 1);
            return 0;
        }

        if ($discountPercent && $discountPaymentMethod && $discountPaymentOptions)
            $this->Discount = $discountPercent . "|" . $discountPaymentMethod . "|" . $discountPaymentOptions;
        return 1;
    }

    /**
     * Method will check for the product integrity and needed values
     *
     * @return int 1 on success
     */
    public function checkProduct() {

        if (strlen($this->productName) > 155) {
            $this->_logError('Product Name for product with name ' . $this->productName . ' must not exceede 155 chars. String was truncated.', 1);
            $this->productName = substr($this->productName, 0, 155);
        }

        if (strlen($this->productInfo) > 255) {
            $this->_logError('Product Info for product with name ' . $this->productName . ' must not exceede 255 chars. String was truncated.', 1);
            $this->productInfo = substr($this->productInfo, 0, 255);
        }

        if (strlen($this->productCode) > 50) {
            $this->_logError('Product Code for product with name ' . $this->productName . ' must not exceede 50 chars. String was truncated.');
            $this->productCode = substr($this->productCode, 0, 50);
        }
        if ($this->productPrice < 0 || !is_numeric($this->productPrice) || $this->productPrice == 0)
            $this->_logError('Price for product with name ' . $this->productName . ' must be a positive number above 0');

        if ($this->productQuantity < 0 || !is_numeric($this->productQuantity) || (int) $this->productQuantity == 0)
            $this->_logError('Quantity for product with name ' . $this->productName . ' must be a positive number above 0');

        if ($this->productQuantity != (int) $this->productQuantity) {
            $this->_logError('Quantity for product with name ' . $this->productName . ' must be a integer number recieved: ' . $this->productQuantity . ' assumed: ' . (int) $this->productQuantity, 1);
            $this->productQuantity = (int) $this->productQuantity;
        }


        if ((string) $this->productVat == (string) (float) $this->productVat) {
            if ($this->productVat < 0)
                $this->_logError('Tax for ' . $this->productName . ' must be a positive number');
        } else {
            $this->_logError('Tax for ' . $this->productName . ' must be a positive number');
        }

        if ($this->productVat > 0 && $this->productVat < 1)
            $this->_logError('Tax for ' . $this->productName . ' must be a number above 1 or 0');

        if (!$this->productName)
            $this->_logError('Name is missing' . ($this->productCode ? ' for product with code:' . $this->productCode : ""));

        if (!$this->productCode)
            $this->_logError('Code is missing' . ($this->productName ? ' for product with name:' . $this->productName : ""));

        if (!$this->productPriceType || ($this->productPriceType != self::PRICE_TYPE_GROSS && $this->productPriceType != self::PRICE_TYPE_NET)) {
            $this->_logError('PriceType is missing' . ($this->productName ? ' for product with name:' . $this->productName : "") . " assumed NET", 1);
            $this->productPriceType = self::PRICE_TYPE_NET;
        }
        return 1;
    }

    /**
     * Read errors for the current class and assert if there are any more errors regarding the current product
     *
     * @return int 1 on success
     */
    public function validate() {
        self::checkProduct();
        return $this->_errorLog;
    }

    /**
     * Log the errors according to the class
     *
     * @param string $errorString the error string to be loged
     * @param string $level the level of the error
     * @return int 1 on success
     */
    private function _logError($errorString, $level=self::DEBUG_ERROR) {

        switch ($level) {
            case self::DEBUG_ERROR:
                $debug_text = 'ERROR in';
                break;
            case self::DEBUG_WARNING:
                $debug_text = 'WARNING in';
                break;
        }

        if (empty($this->_errorLog[$level]))
            $this->_errorLog[$level] = '';

        $this->_errorLog[$level] .= $debug_text . ' ' . __CLASS__ . ': ' . $errorString . '<br/>';
        return 1;
    }

}

class PayuAddress {
    const DEBUG_NONE='0';
    const DEBUG_ALL='9999';
    const DEBUG_ERROR='2';
    const DEBUG_WARNING='1';

    public $firstName;
    public $lastName;
    public $ciSerial;
    public $ciNumber;
    public $ciIssuer;
    public $cnp;
    public $company;
    public $fiscalCode;
    public $regNumber;
    public $bank;
    public $bankAccount;
    public $email;
    public $phone;
    public $fax;
    public $address;
    public $address2;
    public $zipCode;
    public $city;
    public $state;
    public $countryCode;
    private $_errorLog = array();

    /**
     * Constructor
     *
     * @param string $firstName name of the client
     * @param string $lastName last name of the client
     * @param string $ciSerial id serial
     * @param string $ciNumber id serial number
     * @param string $ciIssuer issuer for the id
     * @param string $cnp private numeric identification
     * @param string $company company of the client
     * @param string $fiscalCode fiscal code for the company
     * @param string $regNumber registration number for the company
     * @param string $bank bank for the client
     * @param string $bankAccount bank account for the client
     * @param string $email email for the client
     * @param string $phone phone number for the client
     * @param string $fax fax number for the client
     * @param string $address address for the client
     * @param string $address2 optional address for the client
     * @param string $zipCode zipcode for the client
     * @param string $city city for the client
     * @param string $state state/province for the client
     * @param string $countryCode iso country code
     * @return int returns 1 upon success
     */
    function __construct($firstName='', $lastName='', $ciSerial='', $ciNumber='', $ciIssuer='', $cnp='', $company='', $fiscalCode='', $regNumber='', $bank='', $bankAccount='', $email='', $phone='', $fax='', $address='', $address2='', $zipCode='', $city='', $state='', $countryCode='') {
        if (!empty($firstName))
            $this->setFirstName($firstName);

        if (!empty($lastName))
            $this->setLastName($lastName);

        if (!empty($ciSerial))
            $this->setCiSerial($ciSerial);

        if (!empty($ciNumber))
            $this->setCiNumber($ciNumber);

        if (!empty($ciIssuer))
            $this->setCiIssuer($ciIssuer);

        if (!empty($cnp))
            $this->setCnp($cnp);

        if (!empty($company))
            $this->setCompany($company);

        if (!empty($fiscalCode))
            $this->setFiscalCode($fiscalCode);

        if (!empty($regNumber))
            $this->setRegNumber($regNumber);

        if (!empty($bank))
            $this->setBank($bank);

        if (!empty($bankAccount))
            $this->setBankAccount($bankAccount);

        if (!empty($email))
            $this->setEmail($email);

        if (!empty($phone))
            $this->setPhone($phone);

        if (!empty($fax))
            $this->setFax($fax);

        if (!empty($address))
            $this->setAddress($address);

        if (!empty($address2))
            $this->setAddress2($address2);

        if (!empty($zipCode))
            $this->setZipCode($zipCode);

        if (!empty($city))
            $this->setCity($city);

        if (!empty($state))
            $this->setState($state);

        if (!empty($countryCode))
            $this->setCountryCode($countryCode);

        return 1;
    }

    /**
     *  Set first name for the client
     *
     * @param string $firstName
     * @return int 1 on success
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
        return 1;
    }

    /**
     *  Set last name for the client
     *
     * @param string $lastName
     * @return int 1 on success
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
        return 1;
    }

    /**
     *  Set ci serial
     *
     * @param string $ciSerial
     * @return int 1 on success
     */
    public function setCiSerial($ciSerial) {
        $this->ciSerial = $ciSerial;
        return 1;
    }

    /**
     *  Set ci serial number
     *
     * @param string $ciNumber
     * @return int 1 on success
     */
    public function setCiNumber($ciNumber) {
        $this->ciNumber = $ciNumber;
        return 1;
    }

    /**
     *  Set the issuer for the ci
     *
     * @param string $ciIssuer
     * @return int 1 on success
     */
    public function setCiIssuer($ciIssuer) {
        $this->ciIssuer = $ciIssuer;
        return 1;
    }

    /**
     *  Set cnp
     *
     * @param string $cnp
     * @return int 1 on success
     */
    public function setCnp($cnp) {
        $this->cnp = $cnp;
        return 1;
    }

    /**
     *  Set company
     *
     * @param string $company
     * @return int 1 on success
     */
    public function setCompany($company) {
        $this->company = $company;
        return 1;
    }

    /**
     *  Set the fiscal code
     *
     * @param string $fiscalCode
     * @return int 1 on success
     */
    public function setFiscalCode($fiscalCode) {
        $this->fiscalCode = $fiscalCode;
        return 1;
    }

    /**
     *  Set the registration number
     *
     * @param string $regNumber
     * @return int 1 on success
     */
    public function setRegNumber($regNumber) {
        $this->regNumber = $regNumber;
        return 1;
    }

    /**
     *  Set the bank
     *
     * @param string $bank
     * @return int 1 on success
     */
    public function setBank($bank) {
        $this->bank = $bank;
        return 1;
    }

    /**
     *  Set the bank account
     *
     * @param string $bankAccount
     * @return int 1 on success
     */
    public function setBankAccount($bankAccount) {
        $this->bankAccount = $bankAccount;
        return 1;
    }

    /**
     *  Set email
     *
     * @param string $email
     * @return int 1 on success
     */
    public function setEmail($email) {
        $this->email = $email;
        return 1;
    }

    /**
     *  Set phone number
     *
     * @param string $phone
     * @return int 1 on success
     */
    public function setPhone($phone) {
        $this->phone = $phone;
        return 1;
    }

    /**
     *  Set the fax number
     *
     * @param string $fax
     * @return int 1 on success
     */
    public function setFax($fax) {
        $this->fax = $fax;
        return 1;
    }

    /**
     *  Set address
     *
     * @param string $address
     * @return int 1 on success
     */
    public function setAddress($address) {
        $this->address = $address;
        return 1;
    }

    /**
     *  Set optional address
     *
     * @param string $address2
     * @return int 1 on success
     */
    public function setAddress2($address2) {
        $this->address2 = $address2;
        return 1;
    }

    /**
     *  Set zip code
     *
     * @param string $zipCode
     * @return int 1 on success
     */
    public function setZipCode($zipCode) {
        $this->zipCode = $zipCode;
        return 1;
    }

    /**
     *  Set the city
     *
     * @param string $City
     * @return int 1 on success
     */
    public function setCity($City) {
        $this->city = $City;
        return 1;
    }

    /**
     *  Set state
     *
     * @param string $State
     * @return int 1 on success
     */
    public function setState($State) {
        $this->state = $State;
        return 1;
    }

    /**
     *  Set country code
     *
     * @param string $CountryCode
     * @return int 1 on success
     */
    public function setCountryCode($CountryCode) {
        $this->countryCode = $CountryCode;
        return 1;
    }

    /**
     * Method will check for the address integrity and needed values
     *
     * @return int 1 on success
     */
    public function checkAddress() {
        if ($this->ciNumber && !is_numeric($this->ciNumber)) {
            $this->_logError("CI Number is not a number");
        }

        if ($this->email && preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $this->email) === 0) {
            $this->_logError("Email is invalid");
        }

        return 1;
    }

    /**
     * Read errors for the current class and assert if there are any more errors regarding the current product
     *
     * @return int 1 on success
     */
    public function validate() {
        self::checkAddress();
        return $this->_errorLog;
    }

    /**
     * Log the errors according to the class
     *
     * @return int 1 on success
     */
    private function _logError($errorString, $level=self::DEBUG_ERROR) {

        switch ($level) {
            case self::DEBUG_ERROR:
                $debug_text = 'ERROR in';
                break;
            case self::DEBUG_WARNING:
                $debug_text = 'WARNING in';
                break;
        }

        if (empty($this->_errorLog[$level]))
            $this->_errorLog[$level] = '';

        $this->_errorLog[$level] .= $debug_text . ' ' . __CLASS__ . ': ' . $errorString . '<br/>';
        return 1;
    }

}

?>
