<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Myimages_m extends MY_Model
{
    public function get_image($where, $select = false)
    {
        if ($select)
        {
            $this->db->select($select);
        }

        return $this->db->where($where)->like('mimetype', 'image')->get('files')->row_array();
    }

    public function get_folder_id($id, $name, $slug)
    {
        $folder = $this->db
            ->select('id')
            ->where('id', $id)
            ->or_where('name', $name)
            ->or_where('slug', $slug)
            ->get('file_folders')->row();

        return (isset($folder->id)) ? $folder->id : '';
    }

    public function get_images($id)
    {
        return $this->db
            ->select('id')
            ->like('mimetype', 'image')
            ->where('folder_id', $id)
            ->order_by('sort')
            ->get('files')->result_array();
    }
}