<?php
namespace Tropa\Controller;

use Fgsl\Mvc\Controller\AbstractCrudController;

class SetorController extends AbstractCrudController {

    public function __construct() {
        $this->formClass = 'Tropa\Form\SetorForm';
        $this->modelClass = 'Tropa\Model\Setor';
        $this->namespaceTableGateway = 'Tropa\Model\SetorTable';
        $this->route = 'setor';
        $this->title = 'Cadastro de Setores Espaciais';
        $this->label = array(
            'yes' => 'Sim',
            'no' => 'Não',
            'add' => 'Incluir',
            'edit' => 'Alterar'
        );
    }

}
