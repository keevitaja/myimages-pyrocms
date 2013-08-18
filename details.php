<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Myimages extends Module
{
    public $version = '1.2.2';

    public function info()
    {
        return array(
            'name' => array(
                'en' => 'MyImages'
            ),
            'description' => array(
                'en' => 'Helps to display images in theme'
            )
        );
    }

    public function install()
    {
        return true;
    }

    public function uninstall()
    {
        return true;
    }

    public function upgrade($old_version)
    {
        return true;
    }
}