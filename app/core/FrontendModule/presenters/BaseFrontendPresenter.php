<?php

namespace App\FrontendModule\Presenters;


/**
 * Description of BaseFrontendPresenter
 *
 * @author Jiri Jelinek <jelinekvb@gmail.com>
 * @version 25.2.2015
 * 
 */
class BaseFrontendPresenter extends \App\Presenters\BasePresenter {

    public function startup() {
        parent::startup();

        $this->setLayout($this->context->parameters['appDir'] . '/core/FrontendModule/templates/@layout.latte');
    }

    public function createComponentMenu() {
        return new \MenuControl($this, 'menu');
    }

    protected function createComponentCss() {
        $files = new \WebLoader\FileCollection(WWW_DIR . '/css');
        $files->addFiles(array(
            'style.css',
                //WWW_DIR . '/colorbox/colorbox.css',
        ));

        $compiler = \WebLoader\Compiler::createCssCompiler($files, WWW_DIR . '/webtemp');
        $compiler->addFileFilter(new \WebLoader\Filter\LessFilter());
        //$compiler->addFilter(new WebLoader\Filter\VariablesFilter(array('foo' => 'bar')));
         $compiler->addFilter(function ($code) {
          return \CssMin::minify($code, array("remove-last-semicolon"));
          });
         
        $control = new \WebLoader\Nette\CssLoader($compiler, '/webtemp');
        $control->setMedia('screen');

        return $control;
    }

    protected function createComponentJs() {
        $files = new \WebLoader\FileCollection(WWW_DIR . '/js');
        $files->addFiles(array(
            'jquery.js',
            'netteForms.js',
            'main.js'
        ));
        
        $compiler = \WebLoader\Compiler::createJsCompiler($files, WWW_DIR . "/webtemp");        
        $compiler->addFilter(function ($code){
            return \JShrink\Minifier::minify($code);            
        });
        
        
        $control = new \WebLoader\Nette\JavaScriptLoader($compiler, "/webtemp");     
        ///ddump($control);
        return $control;
    }

}
