<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'username' => remove_special_characters($this->input->post('username', true)),
            'email' => $this->input->post('email', true),
            'first_name' => $this->input->post('first_name', true),
            'last_name' => $this->input->post('last_name', true),
            'password' => $this->input->post('password', true)
        );
        return $data;
    }

    //login
    public function login()
    {
        $this->load->library('bcrypt');

        $data = $this->input_values();
        $user = $this->get_user_by_email($data['email']);

        if (!empty($user)) {
            //check password
            if (!$this->bcrypt->check_password($data['password'], $user->password)) {
                $this->session->set_flashdata('error', trans("login_error"));
                return false;
            }
            if ($user->email_status != 1) {
                $this->session->set_flashdata('error', trans("msg_confirmed_required") . "&nbsp;<a href='javascript:void(0)' class='link-resend-activation-email' onclick=\"send_activation_email('" . $user->id . "','" . $user->token . "');\">" . trans("resend_activation_email") . "</a>");
                return false;
            }
            if ($user->banned == 1) {
                $this->session->set_flashdata('error', trans("msg_ban_error"));
                return false;
            }
            //set user data
            $user_data = array(
                'modesy_sess_user_id' => $user->id,
                'modesy_sess_user_email' => $user->email,
                'modesy_sess_user_role' => $user->role,
                'modesy_sess_logged_in' => true,
                'modesy_sess_app_key' => $this->config->item('app_key'),
            );
            $this->session->set_userdata($user_data);
            return true;
        } else {
            $this->session->set_flashdata('error', trans("login_error"));
            return false;
        }
    }

    //login direct
    public function login_direct($user)
    {
        //set user data
        $user_data = array(
            'modesy_sess_user_id' => $user->id,
            'modesy_sess_user_email' => $user->email,
            'modesy_sess_user_role' => $user->role,
            'modesy_sess_logged_in' => true,
            'modesy_sess_app_key' => $this->config->item('app_key'),
        );

        $this->session->set_userdata($user_data);
    }

    //login with facebook
    public function login_with_facebook($fb_user)
    {
        if (!empty($fb_user)) {
            $user = $this->get_user_by_email($fb_user->email);
            //check if user registered
            if (empty($user)) {
                if (empty($fb_user->name)) {
                    $fb_user->name = "user-" . uniqid();
                }
                $username = $this->generate_uniqe_username($fb_user->name);
                $slug = $this->generate_uniqe_slug($username);
                //add user to database
                $data = array(
                    'facebook_id' => $fb_user->id,
                    'email' => $fb_user->email,
                    'email_status' => 1,
                    'token' => generate_token(),
                    'role' => "member",
                    'username' => $username,
                    'first_name' => $fb_user->name,
                    'slug' => $slug,
                    'avatar' => "https://graph.facebook.com/" . $fb_user->id . "/picture?type=large",
                    'user_type' => "facebook",
                    'created_at' => date('Y-m-d H:i:s')
                );
                if ($this->general_settings->vendor_verification_system != 1) {
                    $data['role'] = "vendor";
                }
                if (!empty($data['email'])) {
                    $this->db->insert('users', $data);
                    $user = $this->get_user_by_email($fb_user->email);
                    $this->login_direct($user);
                }
            } else {
                //login
                $this->login_direct($user);
            }
        }
    }

    //login with google
    public function login_with_google($g_user)
    {
        if (!empty($g_user)) {
            $user = $this->get_user_by_email($g_user->email);
            //check if user registered
            if (empty($user)) {
                if (empty($g_user->name)) {
                    $g_user->name = "user-" . uniqid();
                }
                $username = $this->generate_uniqe_username($g_user->name);
                $slug = $this->generate_uniqe_slug($username);
                //add user to database
                $data = array(
                    'google_id' => $g_user->id,
                    'email' => $g_user->email,
                    'email_status' => 1,
                    'token' => generate_unique_id(),
                    'role' => "member",
                    'username' => $username,
                    'first_name' => $g_user->name,
                    'slug' => $slug,
                    'avatar' => $g_user->avatar,
                    'user_type' => "google",
                    'created_at' => date('Y-m-d H:i:s')
                );
                if ($this->general_settings->vendor_verification_system != 1) {
                    $data['role'] = "vendor";
                }
                if (!empty($data['email'])) {
                    $this->db->insert('users', $data);
                    $user = $this->get_user_by_email($g_user->email);
                    $this->login_direct($user);
                }
            } else {
                //login
                $this->login_direct($user);
            }
        }
    }

    //login with vk
    public function login_with_vk($vk_user)
    {
        if (!empty($vk_user)) {
            $user = $this->get_user_by_email($vk_user->email);
            //check if user registered
            if (empty($user)) {
                if (empty($vk_user->name)) {
                    $vk_user->name = "user-" . uniqid();
                }
                $username = $this->generate_uniqe_username($vk_user->name);
                $slug = $this->generate_uniqe_slug($username);
                //add user to database
                $data = array(
                    'google_id' => $vk_user->id,
                    'email' => $vk_user->email,
                    'email_status' => 1,
                    'token' => generate_unique_id(),
                    'role' => "member",
                    'username' => $username,
                    'first_name' => $vk_user->name,
                    'slug' => $slug,
                    'avatar' => $vk_user->avatar,
                    'user_type' => "vkontakte",
                    'created_at' => date('Y-m-d H:i:s')
                );
                if ($this->general_settings->vendor_verification_system != 1) {
                    $data['role'] = "vendor";
                }
                if (!empty($data['email'])) {
                    $this->db->insert('users', $data);
                    $user = $this->get_user_by_email($vk_user->email);
                    $this->login_direct($user);
                }
            } else {
                //login
                $this->login_direct($user);
            }
        }
    }

    //generate uniqe username
    public function generate_uniqe_username($username)
    {
        $new_username = $username;
        if (!empty($this->get_user_by_username($new_username))) {
            $new_username = $username . " 1";
            if (!empty($this->get_user_by_username($new_username))) {
                $new_username = $username . " 2";
                if (!empty($this->get_user_by_username($new_username))) {
                    $new_username = $username . " 3";
                    if (!empty($this->get_user_by_username($new_username))) {
                        $new_username = $username . "-" . uniqid();
                    }
                }
            }
        }
        return $new_username;
    }

    //generate uniqe slug
    public function generate_uniqe_slug($username)
    {
        $slug = str_slug($username);
        if (!empty($this->get_user_by_slug($slug))) {
            $slug = str_slug($username . "-1");
            if (!empty($this->get_user_by_slug($slug))) {
                $slug = str_slug($username . "-2");
                if (!empty($this->get_user_by_slug($slug))) {
                    $slug = str_slug($username . "-3");
                    if (!empty($this->get_user_by_slug($slug))) {
                        $slug = str_slug($username . "-" . uniqid());
                    }
                }
            }
        }
        return $slug;
    }

    //register
    public function register()
    {
        $this->load->library('bcrypt');

        $data = $this->auth_model->input_values();
        $data['username'] = remove_special_characters($data['username']);
        //secure password
        $data['password'] = $this->bcrypt->hash_password($data['password']);
        $data['role'] = "member";
        $data['user_type'] = "registered";
        $data["slug"] = $this->generate_uniqe_slug($data["username"]);
        $data['banned'] = 0;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['token'] = generate_token();
        $data['email_status'] = 1;
        if ($this->general_settings->email_verification == 1) {
            $data['email_status'] = 0;
        }
        if ($this->general_settings->vendor_verification_system != 1) {
            $data['role'] = "vendor";
        }
        if ($this->db->insert('users', $data)) {
            $last_id = $this->db->insert_id();
            if ($this->general_settings->email_verification == 1) {
                $user = $this->get_user($last_id);
                if (!empty($user)) {
                    $this->session->set_flashdata('success', trans("msg_register_success") . " " . trans("msg_send_confirmation_email") . "&nbsp;<a href='javascript:void(0)' class='link-resend-activation-email' onclick=\"send_activation_email_register('" . $user->id . "','" . $user->token . "');\">" . trans("resend_activation_email") . "</a>");
                    $this->send_email_activation_ajax($user->id, $user->token);
                }
            }
            return $last_id;
        } else {
            return false;
        }
    }

    //send email activation
    public function send_email_activation($user_id, $token)
    {
        if (!empty($user_id)) {
            $user = $this->get_user($user_id);
            if (!empty($user)) {
                if (!empty($user->token) && $user->token != $token) {
                    exit();
                }
                //check token
                $data['token'] = $user->token;
                if (empty($data['token'])) {
                    $data['token'] = generate_token();
                    $this->db->where('id', $user->id);
                    $this->db->update('users', $data);
                }
                //send email
                $email_data = array(
                    'template_path' => "email/email_general",
                    'to' => $user->email,
                    'subject' => trans("confirm_your_account"),
                    'email_content' => trans("msg_confirmation_email"),
                    'email_link' => lang_base_url() . "confirm?token=" . $data['token'],
                    'email_button_text' => trans("confirm_your_account")
                );
                $this->load->model("email_model");
                $this->email_model->send_email($email_data);
            }
        }
    }

    //send email activation
    public function send_email_activation_ajax($user_id, $token)
    {
        if (!empty($user_id)) {
            $user = $this->get_user($user_id);
            if (!empty($user)) {
                if (!empty($user->token) && $user->token != $token) {
                    exit();
                }
                //check token
                $data['token'] = $user->token;
                if (empty($data['token'])) {
                    $data['token'] = generate_token();
                    $this->db->where('id', $user->id);
                    $this->db->update('users', $data);
                }

                //send email
                $email_data = array(
                    'email_type' => 'email_general',
                    'to' => $user->email,
                    'subject' => trans("confirm_your_account"),
                    'email_content' => trans("msg_confirmation_email"),
                    'email_link' => lang_base_url() . "confirm?token=" . $data['token'],
                    'email_button_text' => trans("confirm_your_account")
                );
                $this->session->set_userdata('mds_send_email_data', json_encode($email_data));
            }
        }
    }

    //add administrator
    public function add_administrator()
    {
        $this->load->library('bcrypt');

        $data = $this->auth_model->input_values();
        //secure password
        $data['password'] = $this->bcrypt->hash_password($data['password']);
        $data['user_type'] = "registered";
        $data["slug"] = $this->generate_uniqe_slug($data["username"]);
        $data['role'] = "admin";
        $data['banned'] = 0;
        $data['email_status'] = 1;
        $data['token'] = generate_token();
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('users', $data);
    }

    //update slug
    public function update_slug($id)
    {
        $id = clean_number($id);
        $user = $this->get_user($id);

        if (empty($user->slug) || $user->slug == "-") {
            $data = array(
                'slug' => "user-" . $user->id,
            );
            $this->db->where('id', $id);
            $this->db->update('users', $data);

        } else {
            if ($this->check_is_slug_unique($user->slug, $id) == true) {
                $data = array(
                    'slug' => $user->slug . "-" . $user->id
                );

                $this->db->where('id', $id);
                $this->db->update('users', $data);
            }
        }
    }

    //logout
    public function logout()
    {
        //unset user data
        $this->session->unset_userdata('modesy_sess_user_id');
        $this->session->unset_userdata('modesy_sess_user_email');
        $this->session->unset_userdata('modesy_sess_user_role');
        $this->session->unset_userdata('modesy_sess_logged_in');
        $this->session->unset_userdata('modesy_sess_app_key');
    }

    //reset password
    public function reset_password($id)
    {
        $id = clean_number($id);
        $this->load->library('bcrypt');
        $new_password = $this->input->post('password', true);
        $data = array(
            'password' => $this->bcrypt->hash_password($new_password),
            'token' => generate_token()
        );
        //change password
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    //delete user
    public function delete_user($id)
    {
        $id = clean_number($id);
        $user = $this->get_user($id);
        if (!empty($user)) {
            $this->db->where('id', $id);
            return $this->db->delete('users');
        }
        return false;
    }

    //add shop opening requests
    public function add_shop_opening_requests($data)
    {
        if ($this->is_logged_in()) {
            if (empty($data['country_id'])) {
                $data['country_id'] = 0;
            }
            if (empty($data['state_id'])) {
                $data['state_id'] = 0;
            }

            $user = $this->auth_user;
            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        }
    }

    //approve shop opening request
    public function approve_shop_opening_request($user_id)
    {
        $user_id = clean_number($user_id);
        if ($this->is_logged_in()) {
            //approve request
            if ($this->input->post('submit', true) == 1) {
                $data = array(
                    'role' => 'vendor',
                    'is_active_shop_request' => 0,
                );
            } else {
                //decline request
                $data = array(
                    'is_active_shop_request' => 2,
                );
            }

            $this->db->where('id', $user_id);
            return $this->db->update('users', $data);
        }
    }

    public function magaza_aktif($user_id)
    {
        $user_id = clean_number($user_id);
        if ($this->is_logged_in()) {
            //approve request
            if ($this->input->post('submit', true) == 1) {
                $data = array(
                    'magaza_sozlesmesi_access' => '5',
                );
            } else {
                //decline request
                $data = array(
                    'magaza_sozlesmesi_access' => '3',
                );
            }

            $this->db->where('id', $user_id);
            return $this->db->update('users', $data);
        }
    }
    public function vergi_aktif($user_id)
    {
        $user_id = clean_number($user_id);
        if ($this->is_logged_in()) {
            //approve request
            if ($this->input->post('submit', true) == 1) {
                $data = array(
                    'vergi_access' => '5',
                );
            } else {
                //decline request
                $data = array(
                    'vergi_access' => '3',
                );
            }

            $this->db->where('id', $user_id);
            return $this->db->update('users', $data);
        }
    }
    public function nufus_aktif($user_id)
    {
        $user_id = clean_number($user_id);
        if ($this->is_logged_in()) {
            //approve request
            if ($this->input->post('submit', true) == 1) {
                $data = array(
                    'nufus_access' => '5',
                );
            } else {
                //decline request
                $data = array(
                    'nufus_access' => '3',
                );
            }

            $this->db->where('id', $user_id);
            return $this->db->update('users', $data);
        }
    }
    public function imza_aktif($user_id)
    {
        $user_id = clean_number($user_id);
        if ($this->is_logged_in()) {
            //approve request
            if ($this->input->post('submit', true) == 1) {
                $data = array(
                    'imza_access' => '5',
                );
            } else {
                //decline request
                $data = array(
                    'imza_access' => '3',
                );
            }

            $this->db->where('id', $user_id);
            return $this->db->update('users', $data);
        }
    }
    public function satici_aktif($user_id)
    {
        $user_id = clean_number($user_id);
        if ($this->is_logged_in()) {
            //approve request
            if ($this->input->post('submit', true) == 1) {
                $data = array(
                    'satici_sozlesmesi_access' => '5',
                );
            } else {
                //decline request
                $data = array(
                    'satici_sozlesmesi_access' => '3',
                );
            }

            $this->db->where('id', $user_id);
            return $this->db->update('users', $data);
        }
    }
    public function gizlilik_aktif($user_id)
    {
        $user_id = clean_number($user_id);
        if ($this->is_logged_in()) {
            //approve request
            if ($this->input->post('submit', true) == 1) {
                $data = array(
                    'gizlilik_sozlesmesi_access' => '5',
                );
            } else {
                //decline request
                $data = array(
                    'gizlilik_sozlesmesi_access' => '3',
                );
            }

            $this->db->where('id', $user_id);
            return $this->db->update('users', $data);
        }
    }

    //update last seen time
    public function update_last_seen()
    {
        if ($this->auth_check) {
            //update last seen
            $data = array(
                'last_seen' => date("Y-m-d H:i:s"),
            );
            $this->db->where('id', $this->auth_user->id);
            $this->db->update('users', $data);
        }
    }

    //is logged in
    public function is_logged_in()
    {
        //check if user logged in
        if ($this->session->userdata('modesy_sess_logged_in') == true && $this->session->userdata('modesy_sess_app_key') == $this->config->item('app_key')) {
            $user = $this->get_user($this->session->userdata('modesy_sess_user_id'));
            if (!empty($user)) {
                if ($user->banned == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    //function get user
    public function get_logged_user()
    {
        if ($this->is_logged_in()) {
            $user_id = $this->session->userdata('modesy_sess_user_id');
            $this->db->where('id', $user_id);
            $query = $this->db->get('users');
            return $query->row();
        }
    }

    //get user by id
    public function get_user($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by email
    public function get_user_by_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by username
    public function get_user_by_username($username)
    {
        $username = remove_special_characters($username);
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by shop name
    public function get_user_by_shop_name($shop_name)
    {
        $shop_name = remove_special_characters($shop_name);
        $this->db->where('shop_name', $shop_name);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by slug
    public function get_user_by_slug($slug)
    {
        $this->db->where('slug', $slug);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by token
    public function get_user_by_token($token)
    {
        $token = remove_special_characters($token);
        $this->db->where('token', $token);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get users
    public function get_users()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    //get users count
    public function get_users_count()
    {
        $query = $this->db->get('users');
        return $query->num_rows();
    }

    //get members
    public function get_members()
    {
        $this->db->where('role', "member");
        $query = $this->db->get('users');
        return $query->result();
    }

    public function get_bayi()
    {
        $this->db->where('role', "bayi");
        $query = $this->db->get('users');
        return $query->result();
    }

    //get vendors
    public function get_vendors()
    {
        $this->db->where('role', "vendor");
        $query = $this->db->get('users');
        return $query->result();
    }

    //get latest members
    public function get_latest_members($limit)
    {
        $limit = clean_number($limit);
        $this->db->limit($limit);
        $this->db->order_by('users.id', 'DESC');
        $query = $this->db->get('users');
        return $query->result();
    }

    //get members count
    public function get_members_count()
    {
        $this->db->where('role', "member");
        $query = $this->db->get('users');
        return $query->num_rows();
    }

    //get administrators
    public function get_administrators()
    {
        $this->db->where('role', "admin");
        $query = $this->db->get('users');
        return $query->result();
    }

    //get shop opening requests
    public function get_shop_opening_requests()
    {
        $this->db->where('is_active_shop_request', 1);
        $query = $this->db->get('users');
        return $query->result();
    }

    //get last users
    public function get_last_users()
    {
        $this->db->order_by('users.id', 'DESC');
        $this->db->limit(7);
        $query = $this->db->get('users');
        return $query->result();
    }

    //check slug
    public function check_is_slug_unique($slug, $id)
    {
        $id = clean_number($id);
        $this->db->where('users.slug', $slug);
        $this->db->where('users.id !=', $id);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //check if email is unique
    public function is_unique_email($email, $user_id = 0)
    {
        $user_id = clean_number($user_id);
        $user = $this->auth_model->get_user_by_email($email);

        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //email taken
                return false;
            } else {
                return true;
            }
        }
    }

    //check if username is unique
    public function is_unique_username($username, $user_id = 0)
    {
        $user = $this->get_user_by_username($username);

        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //username taken
                return false;
            } else {
                return true;
            }
        }
    }

    //check if shop name is unique
    public function is_unique_shop_name($shop_name, $user_id = 0)
    {
        $user = $this->get_user_by_shop_name($shop_name);

        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //shop name taken
                return false;
            } else {
                return true;
            }
        }
    }

    //verify email
    public function verify_email($user)
    {
        if (!empty($user)) {
            $data = array(
                'email_status' => 1,
                'token' => generate_token()
            );
            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        }
        return false;
    }

    //ban or remove user ban
    public function ban_remove_ban_user($id)
    {
        $id = clean_number($id);
        $user = $this->get_user($id);

        if (!empty($user)) {
            $data = array();
            if ($user->banned == 0) {
                $data['banned'] = 1;
            }
            if ($user->banned == 1) {
                $data['banned'] = 0;
            }

            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }

        return false;
    }
    public function sms_send($tel, $message)
    {
        $sms_ayar = $this->db->query("SELECT * FROM `sms_sablon`");
        $sms_a = $sms_ayar->row();

        $sms = $this->db->query("SELECT * FROM  gsm_api_users  WHERE status =1 ");
        $sms_c = $sms->row();

        if ($sms_c->api_id == 1) {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.netgsm.com.tr/sms/send/get',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('usercode' => $sms_c->username,'password' => $sms_c->password,'gsmno' => $tel,'message' => $message,'msgheader' => $sms_c->username,'filter' => '0','startdate' => '230520221650','stopdate' => '230520221830'),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

        } else if ($sms_c->api_id == 2) {
            header('Content-Type: text/html; charset=utf-8');
            $postUrl = 'http://panel.vatansms.com/panel/smsgonder1Npost.php';
            $noa = $sms_c->customer_id; //5 haneli müşteri numarası
            $KULLANICIADI = $sms_c->username;
            $SIFRE = $sms_c->password;
            $ORGINATOR = $sms_c->phone;

            $TUR = 'Turkce';  // Normal yada Turkce
            $ZAMAN = '2014-04-07 10:00:00';

            $mesaj1 = $message;
            $numara1 = $tel;

            $xmlString = 'data=<sms>
<kno>' . $noa . '</kno>
<kulad>' . $KULLANICIADI . '</kulad>
<sifre>' . $SIFRE . '</sifre>
<gonderen>' . $ORGINATOR . '</gonderen>
<mesaj>' . $mesaj1 . '</mesaj>
<numaralar>' . $numara1 . '</numaralar>
<tur>' . $TUR . '</tur>
</sms>';

// Xml içinde aşağıdaki alanlarıda gönderebilirsiniz.
//<zaman>'. $ZAMAN.'</zaman> İleri tarih için kullanabilirsiniz

            $Veriler = $xmlString;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $postUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $Veriler);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $response = curl_exec($ch);
            curl_close($ch);

        }else if ($sms_c->api_id == 3) {

            function sendRequest($site_name,$send_xml,$header_type) {

                //die('SITENAME:'.$site_name.'SEND XML:'.$send_xml.'HEADER TYPE '.var_export($header_type,true));
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,$site_name);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$send_xml);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                curl_setopt($ch, CURLOPT_HTTPHEADER,$header_type);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 120);

                $result = curl_exec($ch);

                return $result;
            }

            $username   = $sms_c->username;
            $password   = $sms_c->password;
            $orgin_name = $sms_c->phone;

            $xml = <<<EOS
   		 <request>
   			 <authentication>
   				 <username>{$username}</username>
   				 <password>{$password}</password>
   			 </authentication>

   			 <order>
   	    		 <sender>{$orgin_name}</sender>
   	    		 <sendDateTime>01/05/2013 18:00</sendDateTime>
   	    		 <message>
   	        		 <text>{$message}</text>
   	        		 <receipents>
   	            		 <number>{$phone}</number>
   	        		 </receipents>
   	    		 </message>
   			 </order>
   		 </request>
EOS;


            $result = sendRequest('http://api.iletimerkezi.com/v1/send-sms',$xml,array('Content-Type: text/xml'));

        }


    }

    public function bayi_users($id)
    {
        $id = clean_number($id);
        $user = $this->get_user($id);

        if (!empty($user)) {
            $data = array();
            if ($user->role == "bayi") {
                $data['role'] = "member";
            }
            if ($user->role == "member") {
                $data['role'] = "bayi";
            }




            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }

        return false;
    }

    //open close user shop
    public function open_close_user_shop($id)
    {
        $id = clean_number($id);
        $user = $this->get_user($id);

        if (!empty($user)) {
            $data = array();
            if ($user->role == 'member') {
                $data['role'] = 'vendor';
            } else {
                $data['role'] = 'member';
            }
            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        }

        return false;
    }

}
