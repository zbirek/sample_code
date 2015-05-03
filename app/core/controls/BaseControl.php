<?php


/**
 * Description of BaseControl
 *
 * @author Jiri
 */
abstract class BaseControl extends Nette\Application\UI\Control {
    
    
    
    protected function setTemplate($file) {
        $template = $this->template;
        if($f = file_exists("page_custom.latte")){
            $template->setFile($f);
        }else{
            $template->setFile("page.latte");
        }
        
       return $template;
    }
    
    
    public function render() {}
    
}
