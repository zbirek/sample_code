<?php
namespace App\FrontendModule\Presenters;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SitemapPresenter
 *
 * @author Jiri
 */
class SitemapPresenter extends BaseFrontendPresenter{
    
    /** @var \App\MenuModel @inject */
    public $menuModel;
    
    public function renderDefault() {
        $this->template->sitemap = $this->menuModel->getMenu();
        //ddump($this->template->sitemap);
    }
}
