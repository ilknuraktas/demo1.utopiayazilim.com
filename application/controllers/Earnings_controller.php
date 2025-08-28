<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Earnings_controller extends Home_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->auth_check) {
            redirect(lang_base_url());
        }
        if (!is_user_vendor()) {
            redirect(lang_base_url());
        }
        if (!is_sale_active()) {
            redirect(lang_base_url());
        }
        $this->earnings_per_page = 15;
        $this->user_id = $this->auth_user->id;
    }

    /**
     * Earnings
     */
    public function earnings()
    {
        $data['title'] = trans("earnings");
        $data['description'] = trans("earnings") . " - " . $this->app_name;
        $data['keywords'] = trans("earnings") . "," . $this->app_name;
        $data["active_tab"] = "earnings";
        $data['user'] = $this->auth_user;
        $pagination = $this->paginate(generate_url("earnings"), $this->earnings_model->get_earnings_count($this->user_id), $this->earnings_per_page);
        $data['earnings'] = $this->earnings_model->get_paginated_earnings($this->user_id, $pagination['per_page'], $pagination['offset']);

        $this->load->view('earnings/partials/_header', $data);
        $this->load->view('earnings/earnings', $data);
        $this->load->view('earnings/partials/_footer');
    }

    /**
     * Payouts
     */
    public function payouts()
    {
        $data['title'] = trans("payouts");
        $data['description'] = trans("payouts") . " - " . $this->app_name;
        $data['keywords'] = trans("payouts") . "," . $this->app_name;
        $data["active_tab"] = "payouts";
        $data['user'] = $this->auth_user;
        $pagination = $this->paginate(generate_url("earnings"), $this->earnings_model->get_payouts_count($this->user_id), $this->earnings_per_page);
        $data['payouts'] = $this->earnings_model->get_paginated_payouts($this->user_id, $pagination['per_page'], $pagination['offset']);

        $this->load->view('earnings/partials/_header', $data);
        $this->load->view('earnings/payouts', $data);
        $this->load->view('earnings/partials/_footer');
    }

    /**
     * Set Payout Account
     */
    public function set_payout_account()
    {
        $data['title'] = trans("set_payout_account");
        $data['description'] = trans("set_payout_account") . " - " . $this->app_name;
        $data['keywords'] = trans("set_payout_account") . "," . $this->app_name;
        $data["active_tab"] = "set_payout_account";
        $data['user'] = $this->auth_user;
        $data['user_payout'] = $this->earnings_model->get_user_payout_account($data['user']->id);

        if (empty($this->session->flashdata('msg_payout'))) {
            if ($this->payment_settings->payout_paypal_enabled) {
                $this->session->set_flashdata('msg_payout', "paypal");
            } elseif ($this->payment_settings->payout_iban_enabled) {
                $this->session->set_flashdata('msg_payout', "iban");
            } elseif ($this->payment_settings->payout_swift_enabled) {
                $this->session->set_flashdata('msg_payout', "swift");
            }
        }

        $this->load->view('earnings/partials/_header', $data);
        $this->load->view('earnings/set_payout_account', $data);
        $this->load->view('earnings/partials/_footer');
    }

    public function ucretsiz_kargo()
    {
        $data['title'] = "Ücretsiz Kargo";
        $data['description'] = "Ücretsiz Kargo " . " - " . $this->app_name;
        $data['keywords'] = "Ücretsiz Kargo ". "," . $this->app_name;
        $data["active_tab"] = "ucretsiz_kargo";
        $data['user'] = $this->auth_user;
        $data['user_payout'] = $this->earnings_model->get_user_payout_account($data['user']->id);



        $this->load->view('earnings/partials/_header', $data);
        $this->load->view('earnings/ucretsiz_kargo', $data);
        $this->load->view('earnings/partials/_footer');
    }



    public function toplu_veri()
    {
        $data['title'] = "Toplu Ürün Verileri";
        $data['description'] = "Toplu Ürün Verileri" . " - " . $this->app_name;
        $data['keywords'] = "Toplu Ürün Verileri" . "," . $this->app_name;
        $data["active_tab"] = "set_payout_account";
        $data['user'] = $this->auth_user;
        $data['user_payout'] = $this->earnings_model->get_user_payout_account($data['user']->id);



        $this->load->view('earnings/partials/_header', $data);
        $this->load->view('earnings/toplu_veri', $data);
        $this->load->view('earnings/partials/_footer');
    }



    public function entegrasyon_ayarlari()
    {
        $data['title'] = "Entegrasyon Ayarları";
        $data['description'] = "Entegrasyon Ayarları" . " - " . $this->app_name;
        $data['keywords'] = "Entegrasyon Ayarları" . "," . $this->app_name;
        $data["active_tab"] = "kargo_tab";
        $data['user'] = $this->auth_user;



        $this->load->view('earnings/partials/_header', $data);
        $this->load->view('earnings/entegrasyon', $data);
        $this->load->view('earnings/partials/_footer');
    }

    public function sms_ayarlari(){
         $data['title'] = "SMS Ayarları";
        $data['description'] = "SMS Ayarları" . " - " . $this->app_name;
        $data['keywords'] = "SMS Ayarları" . "," . $this->app_name;
        $data["active_tab"] = "sms";
        $data['user'] = $this->auth_user;



        $this->load->view('earnings/partials/_header', $data);
        $this->load->view('earnings/sms', $data);
        $this->load->view('earnings/partials/_footer');
    }
    
    
    public function entegrasyon_kargo_ayarlari($id)
    {


        if ($id == '5d18a5c262c660-27877500-5650333s') {
            // ücretsiz
            $data['title'] = "Ücretsiz Kargo Ayarları";
            $data['description'] = "Entegrasyon Ayarları" . " - " . $this->app_name;
            $data['keywords'] = "Entegrasyon Ayarları" . "," . $this->app_name;
            $data["active_tab"] = "kargo_tab";
            $data['user'] = $this->auth_user;
            $this->load->view('earnings/partials/_header', $data);
            $this->load->view('earnings/cargo/free', $data);
            $this->load->view('earnings/partials/_footer');
        }
        if ($id == '6273fd4e13e618-41460273-99112736') {
            // yurtici
            $data['title'] = "Yurtiçi Kargo Ayarları";
            $data['description'] = "Entegrasyon Ayarları" . " - " . $this->app_name;
            $data['keywords'] = "Entegrasyon Ayarları" . "," . $this->app_name;
            $data["active_tab"] = "kargo_tab";
            $data['user'] = $this->auth_user;
            $this->load->view('earnings/partials/_header', $data);
            $this->load->view('earnings/cargo/yurtici', $data);
            $this->load->view('earnings/partials/_footer');
        }

        if ($id == '6275d53380a934-59502959-22116944') {
            // ücretsiz
            $data['title'] = "PTT Kargo Ayarları";
            $data['description'] = "Entegrasyon Ayarları" . " - " . $this->app_name;
            $data['keywords'] = "Entegrasyon Ayarları" . "," . $this->app_name;
            $data["active_tab"] = "kargo_tab";
            $data['user'] = $this->auth_user;
            $this->load->view('earnings/partials/_header', $data);
            $this->load->view('earnings/cargo/ptt', $data);
            $this->load->view('earnings/partials/_footer');
        }

        if ($id == '6286c5284c9861-06178257-17104784') {
            // ücretsiz
            $data['title'] = "MNG Kargo Ayarları";
            $data['description'] = "Entegrasyon Ayarları" . " - " . $this->app_name;
            $data['keywords'] = "Entegrasyon Ayarları" . "," . $this->app_name;
            $data["active_tab"] = "kargo_tab";
            $data['user'] = $this->auth_user;
            $this->load->view('earnings/partials/_header', $data);
            $this->load->view('earnings/cargo/mng', $data);
            $this->load->view('earnings/partials/_footer');
        }
    }
    
    public function set_ptt_cargo(){
         if ($this->profile_model->set_ptt_api_account($this->user_id)) {
            $this->session->set_flashdata('msg_payout', "Kargo");
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_payout', "Kargo");
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }
    
     public function set_mng_cargo(){
         if ($this->profile_model->set_mng_api_account($this->user_id)) {
            $this->session->set_flashdata('msg_payout', "Kargo");
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_payout', "Kargo");
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }
    
    
     public function set_yurtici_cargo(){
         if ($this->profile_model->set_yurtici_api_account($this->user_id)) {
            $this->session->set_flashdata('msg_payout', "Kargo");
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_payout', "Kargo");
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }
    
    


    public function entegrasyon_ayarlari_kaydet()
    {
    }



    public function urun_listesi()
    {
        $data['title'] = "Ürün Listesi";
        $data['description'] = "Ürün Listesi" . " - " . $this->app_name;
        $data['keywords'] = "Ürün Listesi" . "," . $this->app_name;
        $data["active_tab"] = "set_payout_account";
        $data['user'] = $this->auth_user;
        $data['user_payout'] = $this->earnings_model->get_user_payout_account($data['user']->id);



        $this->load->view('earnings/partials/_header', $data);
        $this->load->view('earnings/urun_listesi', $data);
        $this->load->view('earnings/partials/_footer');
    }


    public function satis_kazanclari()
    {
        $data['title'] = trans("Satış Kazançları");
        $data['description'] = trans("Satış Kazançları") . " - " . $this->app_name;
        $data['keywords'] = trans("Satış Kazançları") . "," . $this->app_name;
        $data["active_tab"] = "satis_kazanclari";
        $data['user'] = $this->auth_user;
        $pagination = $this->paginate(generate_url("satis_kazanclari"), $this->earnings_model->get_earnings_count($this->user_id), $this->earnings_per_page);
        $data['satis_kazanclari'] = $this->earnings_model->get_paginated_earnings($this->user_id, $pagination['per_page'], $pagination['offset']);

        $this->load->view('earnings/partials/_header', $data);
        $this->load->view('earnings/satis_kazanclari', $data);
        $this->load->view('earnings/partials/_footer');
    }

    /**
     * Set Paypal Payout Account Post
     */
    public function set_paypal_payout_account_post()
    {
        if ($this->earnings_model->set_paypal_payout_account($this->user_id)) {
            $this->session->set_flashdata('msg_payout', "iban");
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_payout', "iban");
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    public function ucretsiz_kargo_post()
    {
        if ($this->earnings_model->ucretsiz_kargo_model($this->user_id)) {
            $this->session->set_flashdata('msg_payout', "iban");
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_payout', "iban");
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Set IBAN Payout Account Post
     */
    public function set_iban_payout_account_post()
    {
        if ($this->earnings_model->set_iban_payout_account($this->user_id)) {
            $this->session->set_flashdata('msg_payout', "iban");
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_payout', "iban");
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Set SWIFT Payout Account Post
     */
    public function set_swift_payout_account_post()
    {
        if ($this->earnings_model->set_swift_payout_account($this->user_id)) {
            $this->session->set_flashdata('msg_payout', "swift");
            $this->session->set_flashdata('success', trans("msg_updated"));
        } else {
            $this->session->set_flashdata('msg_payout', "swift");
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }

    /**
     * Withdraw Money Post
     */
    public function withdraw_money_post()
    {
        $data = array(
            'user_id' => $this->user_id,
            'payout_method' => $this->input->post('payout_method', true),
            'amount' => $this->input->post('amount', true),
            'currency' => $this->input->post('currency', true),
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        $data["amount"] = get_price($data["amount"], 'database');

        //check active payouts
        $active_payouts = $this->earnings_model->get_active_payouts($this->user_id);
        if (!empty($active_payouts)) {
            $this->session->set_flashdata('error', trans("active_payment_request_error"));
            redirect($this->agent->referrer());
        }

        $min = 0;
        if ($data["payout_method"] == "paypal") {
            //check PayPal email
            $payout_paypal_email = $this->earnings_model->get_user_payout_account($this->auth_user->id);
            if (empty($payout_paypal_email) || empty($payout_paypal_email->payout_paypal_email)) {
                $this->session->set_flashdata('error', trans("msg_payout_paypal_error"));
                redirect($this->agent->referrer());
            }
            $min = $this->payment_settings->min_payout_paypal;
        }
        if ($data["payout_method"] == "iban") {
            $min = $this->payment_settings->min_payout_iban;
        }
        if ($data["payout_method"] == "swift") {
            $min = $this->payment_settings->min_payout_swift;
        }

        if ($data["amount"] <= 0) {
            $this->session->set_flashdata('error', trans("msg_error"));
            redirect($this->agent->referrer());
        }
        if ($data["amount"] < $min) {
            $this->session->set_flashdata('error', trans("invalid_withdrawal_amount"));
            redirect($this->agent->referrer());
        }
        if ($data["amount"] > $this->auth_user->balance) {
            $this->session->set_flashdata('error', trans("invalid_withdrawal_amount"));
            redirect($this->agent->referrer());
        }
        if (!$this->earnings_model->withdraw_money($data)) {
            $this->session->set_flashdata('error', trans("msg_error"));
        }
        redirect($this->agent->referrer());
    }




    public function my_products()
    {
        $data['page_title'] = 'Ürünlerim';

        $data['title'] = trans("Ürünlerim");
        $data['description'] = trans("Ürünlerim") . " - " . $this->app_name;
        $data['keywords'] = trans("Ürünlerim") . "," . $this->app_name;
        $data['user'] = $this->auth_user;
        $data['products'] = $this->db->query("SELECT products.*,images.image_default,images.image_small  FROM products LEFT JOIN images ON products.id = images.product_id WHERE products.user_id = " . $data['user']->id . " AND products.status = 1 and products.visibility = 1 AND products.is_draft = 0 GROUP BY products.id")->result();


        $this->load->view('earnings/partials/_header', $data);
        $this->load->view('earnings/my_products', $data);
        $this->load->view('earnings/partials/_footer');
    }

    public function toplu_al()
    {
        $data['page_title'] = 'Toplu Al Az Öde';

        $data['title'] = 'Toplu Al Az Öde';
        $data['description'] ='Toplu Al Az Öde' . " - " . $this->app_name;
        $data['keywords'] = 'Toplu Al Az Öde' . "," . $this->app_name;
        $data['user'] = $this->auth_user;
        $data['products'] = $this->db->query("SELECT products.*,images.image_default,images.image_small  FROM products LEFT JOIN images ON products.id = images.product_id WHERE products.user_id = " . $data['user']->id . " AND products.status = 1 and products.visibility = 1 AND products.is_draft = 0 GROUP BY products.id")->result();


        $this->load->view('earnings/partials/_header', $data);
        $this->load->view('earnings/toplual', $data);
        $this->load->view('earnings/partials/_footer');
    }

    public function my_products_view($type)
    {
        
        switch ($type) {
            case 'bekleyen':
                $data['page_title'] = 'Bekleyen Ürünler';
                $data['title'] = trans("Bekleyen Ürünler");
                $data['description'] = trans("Bekleyen Ürünler") . " - " . $this->app_name;
                $data['keywords'] = trans("Bekleyen Ürünler") . "," . $this->app_name;
                $data['user'] = $this->auth_user;
                $data['products'] = $this->db->query("SELECT products.*,images.image_default,images.image_small  FROM products LEFT JOIN images ON products.id = images.product_id WHERE products.user_id =" . $data['user']->id . " AND status = 0 AND products.is_draft = 0")->result();


                $this->load->view('earnings/partials/_header', $data);
                $this->load->view('earnings/my_products', $data);
                $this->load->view('earnings/partials/_footer');
                break;
            case 'pasif':
                $data['page_title'] = 'Pasif Ürünler';
                $data['title'] = trans("Pasif Ürünler");
                $data['description'] = trans("Pasif Ürünler") . " - " . $this->app_name;
                $data['keywords'] = trans("Pasif Ürünler") . "," . $this->app_name;
                $data['user'] = $this->auth_user;
                $data['products'] = $this->db->query("SELECT products.*,images.image_default,images.image_small  FROM products LEFT JOIN images ON products.id = images.product_id WHERE products.user_id =" . $data['user']->id . "  AND products.visibility = 0 GROUP BY products.id")->result();


                $this->load->view('earnings/partials/_header', $data);
                $this->load->view('earnings/my_products', $data);
                $this->load->view('earnings/partials/_footer');
                break;
            case 'taslak':
                $data['page_title'] = 'Taslak Ürünler';
                $data['title'] = trans("Taslak Ürünler");
                $data['description'] = trans("Taslak Ürünler") . " - " . $this->app_name;
                $data['keywords'] = trans("Taslak Ürünler") . "," . $this->app_name;
                $data['user'] = $this->auth_user;
                $data['products'] = $this->db->query("SELECT products.*,images.image_default,images.image_small  FROM products LEFT JOIN images ON products.id = images.product_id WHERE products.user_id =" . $data['user']->id . " AND products.is_draft=1 ")->result();


                $this->load->view('earnings/partials/_header', $data);
                $this->load->view('earnings/my_products', $data);
                $this->load->view('earnings/partials/_footer');
                break;
            default:
                # code...
                break;
        }
    }
}
