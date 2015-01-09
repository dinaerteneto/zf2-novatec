<?php
namespace Tropa\Controller;

use Fgsl\Mvc\Controller\AbstractCrudController;
use Tropa\Form\LanternaForm;
use Tropa\Model\Lanterna;

class LanternaController extends AbstractCrudController {
    
    public function __construct() {
        $this->formClass = 'Tropa\Form\LanternaForm';
        $this->modelClass = 'Tropa\Model\Lanterna';
        $this->namespaceTableGateway = 'Tropa\Model\LanternaTable';
        $this->route = 'lanterna';
        $this->title = 'Cadastro de lanternas verdes';
        $this->label = array(
            'yes' => 'Sim',
            'no' => 'Não',
            'add' => 'Incluir',
            'edit' => 'Alterar'
        );        
    }
 
}
