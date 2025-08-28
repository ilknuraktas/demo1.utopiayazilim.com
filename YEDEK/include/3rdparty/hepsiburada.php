<?php

class HepsiBurada
{
    protected $username;
    protected $password;
    protected $ch;
    protected $token;
    protected $urlPrefix;

    public function __construct()
    {
        global $hb_username,$hb_password;
        $this->username = $hb_username;
        $this->password = $hb_password;
        $this->urlPrefix = 'https://mpop.hepsiburada.com';
        $this->ch = curl_init();
        $token = $this->postJsonCurl('/api/authenticate', array('username' => $this->username, 'password' => $this->password, 'authenticationType' => 'INTEGRATOR'));
        $this->token = ($token->id_token);
        //echo "Token : ".$this->token;
        if (!$this->token)
            exit(debugArray($token));
    }

    private function postJsonCurl($url, $data, $token = false)
    {
        $data_string = json_encode($data);
        curl_setopt($this->ch, CURLOPT_URL, 'https://mpop.hepsiburada.com' . $url);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        $header = array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        );
        if ($token) {
            $header[] = 'Authorization: Bearer ' . $this->token;
        }
        curl_setopt(
            $this->ch,
            CURLOPT_HTTPHEADER,
            $header
        );

        $result = curl_exec($this->ch);
        if (curl_errno($this->ch)) {
            exit('Token Hata : ' . curl_error($this->ch));
        }
        return json_decode($result);
    }

    private function readcURLx($url)
    {
        curl_setopt($this->ch, CURLOPT_URL, $this->urlPrefix . $url);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer ' . $this->token));
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($this->ch);
        if (curl_errno($this->ch)) {
            exit('Okuma Hata : ' . curl_error($this->ch));
        }
        return json_decode($result);
    }

    public static function getShipmentProviders()
    {
        $out = array();
        $j = json_decode(readcURLx('https://api.trendyol.com/sapigw/shipment-providers'));
        foreach ($j as $s) {
            $out[] = $s->id . '|' . $s->name;
        }
        return implode(',', $out);
    }

    public function getProductCategories()
    {
        global $siteDizini, $yonetimDizini;
        $file = $_SERVER['DOCUMENT_ROOT'] . '/' . $siteDizini . '/' . $yonetimDizini . 'bayiXML/hbcatlist.txt';
        if (file_exists($file) && filesize($file) > 1000)
            return unserialize(file_get_contents($file));
        $test = $this->readcURLx('/product/api/categories/get-all-categories?page=0&size=1');
        $pages = (1 + round($test->totalElements / 2000));
        $cats = array();
        for ($i = 0; $i <= $pages; $i++) {
            $cat = $this->readcURLx('/product/api/categories/get-all-categories?page=' . $i . '&size=2000');
            foreach ($cat->data as $cd) {
                if ($cd->status == 'INACTIVE')
                    continue;
                $path = implode(' > ', $cd->paths);
                if ($path)
                    $cats[$cd->categoryId] = $path . '|' . $cd->parentCategoryId;
            }
        }
        asort($cats);
        file_put_contents($file, serialize($cats));
        return $cats;
    }

    public function getCategoryAttributes($catID)
    {
        return $this->readcURLx('/product/api/categories/' . (int)$catID . '/attributes');
    }

    public function getCategoryAttributesData($catID, $aID)
    {
        return $this->readcURLx('/product/api/categories/' . $catID . '/attribute/' . $aID);
    }


    public function updatePriceAndInventory($data)
    {
        $data_json = json_encode(array('items' => $data));
        curl_setopt($this->ch, CURLOPT_URL, 'https://api.trendyol.com/sapigw/suppliers/' . $this->tID . '/products/price-and-inventory');
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        $out  = json_decode(curl_exec($this->ch));
        if (curl_errno($this->ch)) {
            return adminErrorv3(curl_error($this->ch));
        }
        if ($out->errors[0]->message)
            return adminErrorv3($out->errors[0]->message);
        if ($out->batchRequestId)
            my_mysql_query("insert into trendyolrapor (ID,batchRequestId) VALUES (0,'" . addslashes($out->batchRequestId) . "')", 1);
        return adminInfov3('Update Price And Inventory Kontrol ID : <a target="_blank" href="s.php?f=tyRaporlari.php&y=d&raporID=' . $out->batchRequestId . '">' . $out->batchRequestId . '</a>');
    }

    public function createProducts($data)
    {
        $delimiter = '-------------' . uniqid();
        $fileFields = array(
            'file' => array(
                'type' => 'application/json',
                'content' => json_encode($data),
            ),
        );
        $data = '';
        foreach ($fileFields as $name => $file) {
            $data .= "--" . $delimiter . "\r\n";
            $data .= 'Content-Disposition: form-data; name="' . $name . '";' .
                ' filename="' . $name . '.json"' . "\r\n";
            $data .= 'Content-Type: application/json' . "\r\n";
            $data .= "\r\n";
            $data .= $file['content'] . "\r\n";
        }
        $data .= "--" . $delimiter . "--\r\n";
        $handle = curl_init($this->urlPrefix . '/product/api/products/import');
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $this->token,
            'Content-Type: multipart/form-data; boundary=' . $delimiter,
            'Content-Length: ' . strlen($data)
        ));
        curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($handle);
        return json_decode($result);
    }


    public function updateProducts($data)
    {
        $data_json = json_encode(array('ProductFile' => $data));
        curl_setopt($this->ch, CURLOPT_URL, 'https://api.trendyol.com/sapigw/suppliers/' . $this->tID . '/v2/products');
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

        $out  = json_decode(curl_exec($this->ch));
        if (curl_errno($this->ch)) {
            return adminErrorv3('Curl Hata : ' . curl_error($this->ch));
        }

        if ($out->errors[0]->key == 'batchRequest.recurring.product.create.not.allowed') return;
        if ($out->errors[0]->message && (stristr(debugArray($out), 'batchRequest.recurring.product.create.not.allowed') === false))
            return adminErrorv3('<textarea style="width:800px; height:600px;">' . ($data_json) . '</textarea>' . debugArray($out));
        if ($out->batchRequestId)
            my_mysql_query("insert into trendyolrapor (ID,batchRequestId) VALUES (0,'" . addslashes($out->batchRequestId) . "')", 1);
        return adminInfov3('Update Rapor Kontrol ID : <a target="_blank" href="s.php?f=tyRaporlari.php&y=d&raporID=' . $out->batchRequestId . '">' . $out->batchRequestId . '</a>');
    }

    public function getShipmentPackages()
    {
        return json_decode(readcURLx('https://api.trendyol.com/sapigw/suppliers/' . $this->tID . '/orders?orderByField=CreatedDate&size=200', $this->ch));
    }

    public function getTrackingIDResult($batchRequestId)
    {
        return $this->readcURLx('/product/api/products/status/' . $batchRequestId . '?page=0&size=100');
    }
}
