<?php
namespace MyApp\Model;
use Phalcon\Mvc\Model;
class L3 extends ModelBase
{

    public $id;

    public $content;

    public $image;

    public function getSource()
    {
        return 'l3_com';
    }
    
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Products
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    
    public function findBySiteId($siteId) {
        return self::find(array("site_id = :site_id: AND deleted = 0" ,
                    "order"  => "updated_at DESC",
                    "bind" => array("site_id" => $siteId)
                ));
    }
}
