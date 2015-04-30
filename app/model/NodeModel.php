<?php


namespace App;

/**
 * Description of NodeModel
 *
 * @author Jiri
 */
class NodeModel extends BaseModel{
    
    protected $tNode;
    
    protected $nodes;
    
    
    public function __construct(\DibiConnection $dibi, \Core\ModulesLoader $model) {
        parent::__construct($dibi, $model);
        $this->tNode = self::PREFIX . "node";
    }
    
    public function getNodeFluent() {
        return $this->database
                ->select("*")
                ->from($this->tNode);
    }
    
    public function setNodes() {
        $this->nodes = $this->database->select("*")
                ->from($this->tNode)
                ->where("active = 1")
                ->fetchAssoc('slug');                
    }
    
    public function getNode($slug) {
        if(!$this->nodes) {
            $this->setNodes();
        }
        
        return $this->nodes[$slug];       
    }
    
    /**
     * vraci uzel podle id
     * @param int $id
     * @return \DibiRow
     */
    public function getNodeId($id) {
        return $this->database
                ->select("*")
                ->from($this->tNode)
                ->where('id_node = %i', $id)
                ->fetch();
    }
    
    public function editNode($values) {
        $this->updateNodeSeoSettings($values['id_node'], $values['slug'], $values['seo_description'], $values['title']);
    }
    
    

    
}
