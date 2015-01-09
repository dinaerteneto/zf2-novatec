<?php

namespace Tropa\Model;

use Fgsl\InputFilter\InputFilter;
use Fgsl\Model\AbstractModel;
use Zend\Filter\Int;
use Zend\Filter\StripTags;
use Zend\Filter\StringTrim;
use Zend\Validator\Digits;
use Zend\Validator\StringLength;

class Lanterna {
    public $codigo;
    public $nome;
    public $setor;
    protected $inputFilter;
    
    public function exchangeArray($data) {
        $this->codigo = (isset($data['codigo'])) ? $data['codigo'] : null;
        $this->nome = (isset($data['nome'])) ? $data['nome'] : null;
        $this->setor = new Setor();
        $this->setor->codigo = (isset($data['codigo_setor'])) ? $data['codigo_setor'] : null;
        $this->setor->nome = (isset($data['setor'])) ? $data['setor'] : null;
    }
    
    public function getInputFilter() {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $inputFilter->addFilter('nome', new StripTags());
            $inputFilter->addFilter('nome', new StringTrim());
            $inputFilter->addValidator('nome', new StringLength(array('encoding' => 'UTF-8', 'min' => 2, 'max' => 30)));
            
            $inputFilter->addFilter('codigo_setor', new Int());
            $inputFilter->addValidator('codigo_setor', new Digits());
            
            $this->inputFilter = $inputFilter;
            
        }
        return $this->inputFilter;
    }
    
    public function getArrayCopy() {
        return array(
            'codigo' => $this->codigo,
            'nome' => $this->nome,
            'codigo_setor' => $this->setor->codigo
        );
    }
}
    