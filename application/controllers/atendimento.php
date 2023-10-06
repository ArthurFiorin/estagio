<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Atendimento extends CI_Controller
{
    private $json;
    private $resultado;
    private $codAtendimento;
    private $dataAt;
    private $horaAt;
    private $descricao;
    private $estatus;

    public function getCodAtendimento()
    {
        return $this->codAtendimento;
    }

    public function setCodAtendimento($codAtendimentoFront)
    {
        $this->codAtendimento = $codAtendimentoFront;
    }

    public function getDataAt()
    {
        return $this->dataAt;
    }

    public function setDataAt($dataAtFront)
    {
        $this->dataAt = $dataAtFront;
    }

    public function getHoraAt()
    {
        return $this->horaAt;
    }

    public function setHoraAt($horaAtFront)
    {
        $this->horaAt = $horaAtFront;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricaoFront)
    {
        $this->descricao = $descricaoFront;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }

    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;
    }

    public function inserirAtendimento()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array("ra" => '0', "idProfessor" => '0', 'dataAt' => '0', 'horaAt' => '0', 'descricao' => '0', "estatus" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $ra = $resultado->ra;
            $idProfessor = $resultado->idProfessor;
            $this->setDataAt($resultado->dataAt);
            $this->setHoraAt($resultado->horaAt);
            $this->setDescricao($resultado->descricao);
            $this->setEstatus($resultado->estatus);

            if (empty($ra)) {
                $retorno = array('codigo' => 13, 'msg' => 'ra não informado.');
            } elseif (empty($idProfessor)) {
                $retorno = array('codigo' => 14, 'msg' => 'Id do professor não informado.');
            } elseif (empty($this->getDataAt())) {
                $retorno = array('codigo' => 15, 'msg' => 'Data não informada.');
            } elseif (empty($this->getHoraAt())) {
                $retorno = array('codigo' => 16, 'msg' => 'hora não informada.');
            } elseif (empty($this->getDescricao())) {
                $retorno = array('codigo' => 17, 'msg' => 'Descrição não informada.');
            } elseif ($this->getEstatus() != "C" && $this->getEstatus() != "") {
                $retorno = array('codigo' => 18, 'msg' => 'Status não condiz com o permitido');
            } else {
                $this->load->model('M_atendimento');
                $retorno = $this->M_atendimento->inserirAtendimento($ra, $idProfessor, $this->getDataAt(), $this->getHoraAt(), $this->getDescricao(), $this->getEstatus());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'Os campos vindos do frontend não representam o método de inserção verifique.');
        }
        echo json_encode($retorno);
    }

    public function consultarAtendimento()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array("codAtendimento" => '0', "ra" => '0', "idProfessor" => '0', "dataAt" => '0', "horaAt" => '0', "descricao" => '0', "estatus" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setCodAtendimento($resultado->codAtendimento);
            $ra = $resultado->ra;
            $idProfessor = $resultado->idProfessor;
            $this->setDataAt($resultado->dataAt);
            $this->setHoraAt($resultado->horaAt);
            $this->setDescricao($resultado->descricao);
            $this->setEstatus($resultado->estatus);

            if (trim($this->getEstatus()) != "D" && $this->getEstatus() != "") {
                $retorno = array('codigo' => 18, 'msg' => 'status nao condiz com o permitido');
            } else {
                $this->load->model('M_atendimento');
                $retorno = $this->M_atendimento->consultarAtendimento($this->getCodAtendimento(), $ra, $idProfessor, $this->getDataAt(), $this->getHoraAt(), $this->getDescricao(), $this->getEstatus());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'Os campos vindos do frontend não representam o método de inserção verifique.');
        }
        echo json_encode($retorno);
    }

    public function alteraAtendimento()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array("codAtendimento" => '0', "dataAt" => '0', "horaAt" => '0', "descricao" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setCodAtendimento($resultado->codAtendimento);
            $this->setDataAt($resultado->dataAt);
            $this->setHoraAt($resultado->horaAt);
            $this->setDescricao($resultado->descricao);

            if (empty($this->getCodAtendimento())) {
                $retorno = array('codigo' => 12, 'msg' => 'codAtendimento do atendimento nao informado ou zerado');
            } else {
                $this->load->model('M_atendimento');
                $retorno = $this->M_atendimento->alteraAtendimento($this->getCodAtendimento(), $this->getDataAt(), $this->getHoraAt(), $this->getDescricao());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do frontend nao representam o metodo de consulta');
        }
        echo json_encode($retorno);
    }

    public function apagaAtendimento()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array("codAtendimento" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setCodAtendimento($resultado->codAtendimento);

            if (empty($this->getCodAtendimento())) {
                $retorno = array('codigo' => 12, 'msg' => 'o codigo do atendimento nao informado ou zerado');
            } else {
                $this->load->model('M_atendimento');
                $retorno = $this->M_atendimento->apagaAtendimento($this->getCodAtendimento());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do frontend nao representam o metodo de consulta');
        }
        echo json_encode($retorno);
    }

    public function ativaAtendimento()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
        $lista = array("codAtendimento" => '0');

        if (verificarParam($resultado, $lista) == 1) {
            $this->setCodAtendimento($resultado->codAtendimento);

            if (empty($this->getCodAtendimento())) {
                $retorno = array('codigo' => 12, 'msg' => 'o codigo do atendimento nao informado ou zerado');
            } else {
                $this->load->model('M_atendimento');
                $retorno = $this->M_atendimento->ativaAtendimento($this->getCodAtendimento());
            }
        } else {
            $retorno = array('codigo' => 99, 'msg' => 'os campos vindos do frontend nao representam o metodo de consulta');
        }
        echo json_encode($retorno);
    }
}
?>
