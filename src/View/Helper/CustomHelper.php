<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class CustomHelper extends Helper
{
    public function category_name($id)
    {
        /*$this->Categories = TableRegistry::get('categories');
    	return $this->Categories->get($id)->name;*/
    }

    public function color_name($id)
    {
        
    }

    public function get_gallery_images($id)
    {
    	
    }

    public function get_gallery_reviews($id)
    {
    	
    }

    public function get_ticket_count()
    {
        
    }
}