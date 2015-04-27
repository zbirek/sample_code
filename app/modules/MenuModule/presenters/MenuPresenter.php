<?php
namespace App\AdminModule\Presenters;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuPresenter
 *
 * @author Jiri
 */
class MenuPresenter extends BaseBackendPresenter{
    
    /** @var \App\MenuModel @inject */
    public $menuModel;
    
    public function renderDefault() {
        $this->template->items = $this->menuModel->getMenu();
    }
}
