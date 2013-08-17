<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_Myimages extends Plugin
{
    public $version = '1.2.0';

    public $name = array(
        'en' => 'MyImages',
    );

    public $description = array(
        'en' => 'Helps to display images in theme',
    );

    // try to get called method
    public function __call($method, $args)
    {
        $this->load->library('myimages');

        $excluded = array('folder_array');

        if ( ! method_exists($this->myimages, $method) or in_array($method, $excluded))
        {
            show_error('MyImages: plugin function "' . $method . '" is not available', 500);
        }

        $params = $this->attributes();

        return $this->myimages->$method($params);
    }
}