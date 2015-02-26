<?php
namespace App\ArticleModule;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArticleModel
 *
 * @author Jiri
 */
class ArticleModel extends \App\BaseModel{
    
    protected $tArticle;
	
	public function __construct(\DibiConnection $dibi) {
		parent::__construct($dibi);
		$this->tArticle = self::PREFIX."article";
	}
	
	public function getFluentArticle() {
		return $this->database->select("*")
				->from($this->tArticle);
	}
	
	
	
	
}
