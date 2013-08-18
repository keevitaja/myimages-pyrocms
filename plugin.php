<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Plugin_Myimages extends Plugin
{
    public $version = '1.2.2';

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

        $error = 'MyImages: plugin function "' . $method . '" is not available';

        if ( ! method_exists($this->myimages, $method))
        {
            show_error($error, 500);
        }

        $reflection = new ReflectionMethod($this->myimages, $method);

        if ( ! $reflection->isPublic())
        {
            show_error($error, 500);
        }

        $params = $this->attributes();

        return $this->myimages->$method($params);
    }
}