<?php
namespace App;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseModel
 *
 * @author Jiri
 */
class BaseModel{
    
    /** @var \DibiConnection */
    protected $database;
    
    const PREFIX = "cms_";

    public function __construct(\DibiConnection $dibi) {
        $this->database = $dibi;
    }
    
    
}
