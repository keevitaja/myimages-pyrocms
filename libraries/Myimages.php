<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Myimages
{
    private $ci;

    public function __construct()
    {
        $this->ci =& get_instance();

        $this->ci->load->model('myimages_m');
        $this->ci->load->helper('myimages');
    }

    // get thumb url
    public function url_thumb($params, $image_data = false)
    {
        if ( ! $image_data)
        {
            if ( ! isset($params['id']))
            {
                return '';
            }

            $image_data = $this->ci->myimages_m->get_image(array('id' => $params['id']), 'name');

            if (empty($image_data))
            {
                return '';
            }
        }

        $width = (isset($params['width'])) ? $params['width'] : 'auto';
        $height = (isset($params['height'])) ? $params['height'] : 'auto';

        $mode = (isset($params_raw['mode'])) ? 'fill'  : 'fit';

        $segments = array('files', 'thumb', $params['id'], $width, $height, $mode, $image_data['name']);

        return site_url(implode('/', $segments));
    }

    // get large url
    public function url_large($params, $image_data = false)
    {
        if ( ! $image_data)
        {
            if ( ! isset($params['id']))
            {
                return '';
            }

            $image_data = $this->ci->myimages_m->get_image(array('id' => $params['id']), 'name');

            if (empty($image_data))
            {
                return '';
            }
        }

        $segments = array('files', 'large', $params['id'], $image_data['name']);

        return site_url(implode('/', $segments));
    }

    // get image data
    public function image_data($params)
    {
        if ( ! isset($params['id']))
        {
            return '';
        }

        $select_fields = 'id, folder_id, name, description as title, mimetype, width, height, alt_attribute as alt';

        $image_data = $this->ci->myimages_m->get_image(array('id' => $params['id']), $select_fields);

        if (empty($image_data))
        {
            return '';
        }

        $image_data['url_thumb'] = $this->url_thumb($params, $image_data);
        $image_data['url_large'] = $this->url_large($params, $image_data);

        return $image_data;
    }

    // get image
    public function image($params)
    {
        if ( ! isset($params['id']))
        {
            return '';
        }

        $image_data = $this->ci->myimages_m->get_image(array('id' => $params['id']), 'name, alt_attribute as alt');

        if (empty($image_data))
        {
            return '';
        }

        $url_type = ( ! isset($params['width']) and ! isset($params['height'])) ? 'url_large' : 'url_thumb';

        $attributes = array(
            'src' => $this->$url_type($params, $image_data),
            'alt' => $image_data['alt']
        );

        if (isset($params['class']))
        {
            $attributes['class'] = $params['class'];
        }

        return '<img ' . myimages_attributes($attributes) . '>';
    }

    // get anchor
    public function anchor($params)
    {
        if ( ! isset($params['id']))
        {
            return '';
        }

        $select_fields = 'name, alt_attribute as alt, description as title';

        $image_data = $this->ci->myimages_m->get_image(array('id' => $params['id']), $select_fields);

        if (empty($image_data))
        {
            return '';
        }

        $attributes = array(
            'src' => $this->url_thumb($params, $image_data),
            'alt' => $image_data['alt']
        );

        $image = '<img ' . myimages_attributes($attributes) . '>';

        if (isset($params['wrap']))
        {
            $image = sprintf($params['wrap'], $image);
        }

        $attributes = array(
            'href' => $this->url_large($params, $image_data),
            'title' => $image_data['title']
        );

        if (isset($params['class']))
        {
            $attributes['class'] = $params['class'];
        }

        if (isset($params['params']))
        {
            $extra_params = explode(',', $params['params']);

            foreach ($extra_params as $param)
            {
                list($key, $val) = explode('|', $param);

                $attributes[$key] = $val;
            }
        }

        return '<a ' . myimages_attributes($attributes) . '>' . $image . '</a>';
    }

    // get all image ids from folder
    public function folder_images($params)
    {
        $id = (isset($params['id'])) ? $params['id'] : '';
        $name = (isset($params['name'])) ? $params['name'] : '';
        $slug = (isset($params['slug'])) ? $params['slug'] : '';

        $folder_id = $this->ci->myimages_m->get_folder_id($id, $name, $slug);

        if (empty($folder_id))
        {
            return '';
        }

        return $this->ci->myimages_m->get_images($folder_id);
    }

    // used by folder functions
    // not usable by plugin
    private function folder_array($params, $type)
    {
        $image_ids = $this->folder_images($params);

        if (empty($image_ids))
        {
            return '';
        }

        $data = array();

        foreach ($image_ids as $item)
        {
            $params['id'] = $item['id'];

            switch ($type)
            {
                case 'images_data':
                    $data[] = $this->image_data($params);
                    break;
                case 'images':
                    $data[] = array('image' => $this->image($params));
                    break;
                case 'anchors':
                    $data[] = array('anchor' => $this->anchor($params));
                    break;
            }
        }

        return $data;
    }

    // get images data
    public function images_data($params)
    {
        return $this->folder_array($params, 'images_data');
    }

    // get images
    public function images($params)
    {
        return $this->folder_array($params, 'images');
    }

    // get anchors
    public function anchors($params)
    {
        return $this->folder_array($params, 'anchors');
    }
}