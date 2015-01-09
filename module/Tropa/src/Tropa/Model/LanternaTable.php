<?php
namespace Tropa\Model;

use Fgsl\Db\TableGateway\AbstractTableGateway;
use Fgsl\Model\AbstractModel;

class LanternaTable extends AbstractTableGateway {

    protected $primaryKey = 'codigo';
    
    public function getData(AbstractModel $model) {
        $data = array(
            'nome' => $model->nome,
            'codigo_setor' => $model->setor->codigo
        );
        return $data;
    }
    
    public function get($key) {
        $key = (int) $key;
        $select = $this->getSelect()->where(array('lanterna.codigo' => $key));
        $rowset = $this->tableGateway->selectWidth($select);
        $row = $rowset->current();
        return $row;
    }
    
    public function getSelect() {
        $select = new Select();
        $select->from('lanterna')
               ->columns(array('codigo', 'nome', 'codigo_setor'))
               ->join(array('s' => 'setor'), 'lanterna.codigo_setor = s.codigo', array('setor' => 'nome'));
        return $select;
    }
}
