<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Story_model extends CI_Model
{
    //add item
    public function add_item()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'text' => $this->input->post('text', true),
            'link' => $this->input->post('link', true),
        );

        $this->load->model('upload_model');
        $temp_path = $this->upload_model->upload_temp_image('file');
        if (!empty($temp_path)) {
            $data["image"] = $this->upload_model->avatar_upload($temp_path);
            $this->upload_model->delete_temp_image($temp_path);
        } else {
            $data["image"] = "";
        }

        return $this->db->insert('stories', $data);
    }

    //update item


    //get slider item
    public function get_slider_item($id)
    {
        $id = clean_number($id);
        $this->db->where('id', $id);
        $query = $this->db->get('stories');
        return $query->row();
    }

    //get slider items
    public function get_slider_items()
    {
        $this->db->where('slider.lang_id', $this->selected_lang->id);
        $this->db->order_by('id');
        $query = $this->db->get('stories');
        return $query->result();
    }

    //get all slider items
    public function get_slider_items_all()
    {
        $this->db->order_by('id');
        $query = $this->db->get('stories');
        return $query->result();
    }


    //update slider settings
    public function update_slider_settings()
    {
        $data = array(
            'story_status' => $this->input->post('story_status', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }


    //delete slider item
    public function delete_slider_item($id)
    {
        $id = clean_number($id);
        $slider_item = $this->get_slider_item($id);
        if (!empty($slider_item)) {
            //delete from s3
            if ($slider_item->storage == "aws_s3") {
                $this->load->model("aws_model");
                $this->aws_model->delete_slider_object($slider_item->image);
            } else {
                delete_file_from_server($slider_item->image);
                delete_file_from_server($slider_item->image_small);
            }
            $this->db->where('id', $id);
            return $this->db->delete('stories');
        }
        return false;
    }
}
