<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once("M_atendimento.php");
include_once("M_professor.php");
include_once("M_aluno.php");

class M_atendimento extends CI_Model
{
    public function inserirAtendimento($ra, $idProfessor, $dataAt, $horaAt, $descricao, $estatus)
    {

        $aluno = new M_aluno();
        $retornoAluno = $aluno->consultarSoAluno($ra);

        if ($retornoAluno['codigo'] == 1) {
            $professor = new M_professor();
            $retornoProfessor = $professor->consultarSoProfessor($idProfessor);

            if ($retornoProfessor['codigo'] == 1) {
                $sql = "INSERT INTO atendimento (ra, id_professor, data_atendimento, hora_atendimento, descricao, estatus) VALUES ('$ra', $idProfessor, '$dataAt', '$horaAt', '$descricao','$estatus')";
                $this->db->query($sql);

                if ($this->db->affected_rows() > 0) {
                    $dados = array('codigo' => 1, 'msg' => 'Atendimento registrado com sucesso.');
                } else {
                    $dados = array('codigo' => 2, 'msg' => 'Houve algum problema no atendimento');
                }
            } else {
                $dados = array('codigo' => 3, 'msg' => 'Professor não existente no banco de dados.');
            }
        } else {
            $dados = array('codigo' => 4, 'msg' => 'Aluno não existente na banco de dados.');
        }

        return $dados;
    }

    public function consultarAtendimento($codAtendimento, $ra, $idProfessor, $dataAt, $horaAt, $descricao, $estatus)
    {
        $sql = "SELECT * FROM atendimento WHERE estatus = '$estatus'";

        if (!empty($codAtendimento)) {
            $sql .= " AND cod_atendimento = '$codAtendimento'";
        }

        if (trim($ra) != '') {
            $sql .= " AND ra = '$ra'";
        }

        if (!empty($idProfessor)) {
            $sql .= " AND id_professor = '$idProfessor'";
        }

        if ($dataAt != '') {
            $sql .= " AND data_atendimento = '$dataAt'";
        }

        if ($horaAt != '') {
            $sql .= " AND hora_atendimento = '$horaAt'";
        }

        if ($descricao != '') {
            $sql .= " AND descricao LIKE '%$descricao%'";
        }

        $retorno = $this->db->query($sql);

        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso', 'dados' => $retorno->result());
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Dados não encontrados');
        }

        return $dados;
    }

    public function consultaSoAtendimento($codAtendimento)
    {
        $sql = "SELECT * FROM atendimento WHERE cod_atendimento = $codAtendimento";
        $retorno = $this->db->query($sql);

        if ($retorno->num_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso');
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Dados não encontrados');
        }

        return $dados;
    }

    public function alteraAtendimento($codAtendimento, $dataAt, $horaAt, $descricao)
    {
        $retornoAtendimento = $this->consultaSoAtendimento($codAtendimento);

        if ($retornoAtendimento['codigo'] == 1) {
            $sql = "UPDATE atendimento SET ";

            if (!empty($dataAt)) {
                $sql .= "data_atendimento = '$dataAt', ";
            }

            if (!empty($horaAt)) {
                $sql .= "hora_atendimento = '$horaAt', ";
            }

            if (!empty($descricao)) {
                $sql .= "descricao = '$descricao', ";
            }

            $sql = rtrim($sql, ', ');
            $sql .= " WHERE cod_atendimento = $codAtendimento";

            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 1, 'msg' => 'Atendimento atualizado com sucesso.');
            } else {
                $dados = array('codigo' => 2, 'msg' => 'Problemas ao atualizar o atendimento.');
            }
        } else {
            $dados = array('codigo' => 6, 'msg' => 'Código de atendimento não está na base de dados.');
        }

        return $dados;
    }

    public function apagaAtendimento($codAtendimento)
    {
        $retornoAtendimento = $this->consultaSoAtendimento($codAtendimento);

        if ($retornoAtendimento['codigo'] == 1) {
            $sql = "SELECT * FROM atendimento WHERE cod_atendimento = $codAtendimento and estatus = 'C'";
            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 0, 'msg' => 'Atendimento já concluído.');
            } else {
                $sql = "UPDATE atendimento SET estatus = 'C' WHERE cod_atendimento = $codAtendimento";
                $this->db->query($sql);

                if ($this->db->affected_rows() > 0) {
                    $dados = array('codigo' => 1, 'msg' => 'Atendimento concluído com sucesso');
                } else {
                    $dados = array('codigo' => 2, 'msg' => 'Houve algum problema ao concluir o atendimento, tente novamente.');
                }
            }
        } else {
            $dados = array('codigo' => 4, 'msg' => 'Atendimento não registrado no nosso banco de dados');
        }

        return $dados;
    }

    public function ativaAtendimento($codAtendimento)
    {
        $retornoAtendimento = $this->consultaSoAtendimento($codAtendimento);

        if ($retornoAtendimento['codigo'] == 1) {
            $sql = "SELECT * FROM atendimento WHERE cod_atendimento = $codAtendimento and estatus = ''";
            $this->db->query($sql);

            if ($this->db->affected_rows() > 0) {
                $dados = array('codigo' => 0, 'msg' => 'Atendimento já ativo');
            } else {
                $sql = "UPDATE atendimento SET estatus = '' WHERE cod_atendimento = $codAtendimento";
                $this->db->query($sql);

                if ($this->db->affected_rows() > 0) {
                    $dados = array('codigo' => 1, 'msg' => 'Atendimento reativado com sucesso');
                } else {
                    $dados = array('codigo' => 2, 'msg' => 'Houve algum problema ao reativar o atendimento');
                }
            }
        } else {
            $dados = array('codigo' => 4, 'msg' => 'O código de atendimento informado não está na base de dados.');
        }

        return $dados;
    }
}
?>
