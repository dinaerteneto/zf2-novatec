<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Tropa\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Tropa\Form\SetorForm;
use Tropa\Model\Setor;

class SetorController extends AbstractActionController {

    protected $setorTable;

    public function indexAction() {
        return new ViewModel(array(
            'setores' => $this->getSetorTable()->fetchAll()
        ));
    }

    public function addAction() {
        $form = new SetorForm();
        $form->get('submit')->setValue('Cadastrar');
        $request = $this->getRequest();
        if($request->isPost()) {
            $setor = new Setor();
            $form->setInputFilter($setor->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()) {
                $setor->exchangeArray($form->getData());
                $this->getSetorTable()->saveSetor($setor);
                return $this->redirect()->toRoute('setor');
            }
        }
        return array('form' => $form);
    }

    public function editAction() {
        $codigo = (int) $this->params()->fromRoute('codigo', null);
        if(is_null($codigo)) {
            return $this->redirect()->toRoute('setor', array('action' => 'add'));
        }
        $setor = $this->getSetorTable()->getSetor($codigo);
        $form = new SetorForm();
        $form->bind($setor);
        $form->get('submit')->setAttribute('value', 'Editar');
        $request = $this->getRequest();
        if($request->isPost()) {
            $form->setInputFilter($setor->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid()) {
                $this->getSetorTable()->saveSetor($form->getData());
                return $this->redirect()->toRoute('setor');
            }
        }
        return array(
            'codigo' => $codigo,
            'form' => $form
        );
    }

    public function deleteAction() {
        $codigo = (int) $this->params()->fromRoute('codigo', null);
        if(is_null($codigo)) {
            return $this->redirect()->toRoute('setor');
        }
        $request = $this->getRequest();
        if($request->isPost()) {
            $del = $request->getPost('del', 'Nao');
            if($del == 'Sim') {
                $this->getSetorTable()->deleteSetor($codigo);
            }
            return $this->redirect()->toRoute('setor');
        }
        return array(
            'codigo' => $codigo,
            'form' => $this->getDeleteForm($codigo)
        );
    }
    
    public function getDeleteForm($codigo) {
        $form = new SetorForm();
        $form->remove('codigo');
        $form->remove('nome');
        $form->remove('submit');
        $form->add(array(
            'name' => 'del',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Sim',
                'id' => 'del'
            )
        ));
        $form->add(array(
            'name' => 'return',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Não',
                'id' => 'return'
            )
        ));
        return $form;
    }

    public function getSetorTable() {
        if (!$this->setorTable) {
            $sm = $this->getServiceLocator();
            $this->setorTable = $sm->get('Tropa\Model\SetorTable');
        }
        return $this->setorTable;
    }

}
