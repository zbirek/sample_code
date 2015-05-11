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
class ArticleModel extends \App\BaseModel {

    protected $tArticle;
    protected $tUser;

    const MODEL = "Article";

    public function __construct(\DibiConnection $dibi, \Core\ModulesLoader $modules = NULL) {
        parent::__construct($dibi, $modules);
        $this->tArticle = self::PREFIX . "article";
        $this->tUser = self::PREFIX . "user";
    }

    /**
     * 
     * @return \DibiFluent
     */
    public function getFluentArticle() {
        return $this->database->select("article.*, user.name, node.slug")
                        ->from("$this->tArticle article")
                        ->leftJoin("$this->tUser user ON article.id_author = user.id_user")
                        ->leftJoin("$this->tNode node ON node.id_node = article.id_node");
    }

    
    public function getArticle($id) {
        return $this->database->select("*")
                ->from($this->tArticle)
                ->where("id_node = %i", $id)
                ->fetch();
    }
    
    /**
     * pridani clanku
     * @param array $values
     */
    public function addArticle($values) {
        $this->database->begin();
        
        $module = $this->modules->getModuleByUid(self::MODEL);
        $id_node = $this->initNode($module['id_module']);
        $values['id_node'] = $id_node;
        // pridani clanku
        $this->database->insert($this->tArticle, $values)
                ->execute();
        $this->updateNodeSeoSettings($id_node, $values['title'], NULL, $values['title']);

        $this->database->commit();
    }

    public function editArticle($id_article, $values) {
        $this->database->update($this->tArticle, $values)
                ->where('id_node = %i', $id_article)
                ->execute();
    }
    
    public function deleteArticle($id_node){
        $this->database->begin();		
		
		$this->database->delete($this->tArticle)
				->where("id_node = %i", $id_node)
				->execute();
		
		$this->deleteNode($id_node);
		$this->database->commit();
    }

}
