<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("M_aluno.php");
include_once("M_curso.php");
include_once("M_professor.php");

class M_professor extends CI_Model
{
  public function inserirProfessor($nome, $usuario, $senha, $estatus)
  {

    $sql = "insert into professor (nome, usuario, senha, estatus) values('$nome','$usuario','$senha','$estatus')";
    $this->db->query($sql);

    if ($this->db->affected_rows() > 0) {
      $dados = array('codigo' => 1, 'msg' => 'professor cadastrado corretamente');
    } else {
      $dados = array('codigo' => 2, 'msg' => 'Houve algum problema na inserção na tabela professor');
    }

    return $dados;
  }

  public function consultarProfessor($id_professor, $nome, $usuario, $senha, $estatus)
  {
		
    $sql = "select * from professor where estatus = '$estatus'";


    if (($id_professor) != '') {
      $sql = $sql . "and id_professor = '$id_professor'";
    }

    if (trim($nome)) {
      $sql = $sql . " and nome = '%$nome%'";
    }

    if (trim($usuario)) {
      $sql = $sql . "and usuario = '%$usuario%'";
    }

    if (trim($senha)) {
      $sql = $sql . "and senha = '$senha'";
    }

    $retorno = $this->db->query($sql);

    if ($retorno->num_rows() > 0) {
      $dados = array(
        'codigo' => 1, 'msg' => 'consulta efetuada com sucesso',
        'dados' => $retorno->result()
      );
    } else {
      $dados = array('codigo' => 2, 'msg' => 'dados nao encontrados');
    }
    return $dados;
  }


  public function consultarSoProfessor($id_professor)
  {
    $sql = "select * from professor where id_professor = '$id_professor'";

    $retorno = $this->db->query($sql);

    if ($retorno->num_rows() > 0) {
      $dados = array('codigo' => 1, 'msg' => 'consulta efetuada com sucesso');
    } else {
      $dados = array('codigo' => 2, 'msg' => 'dados nao encontrados');
    }

    return $dados;
  }


  public function alterarProfessor($id_professor, $nome, $usuario, $senha)
  {
    $retornoProfessor = $this->consultarSoProfessor($id_professor);

    if ($retornoProfessor['codigo'] == 1) {
      $sql = "update professor set ";

      if (!empty($nome)) {
        $sql .= "nome = '$nome', ";
      }

      if (!empty($usuario)) {
        $sql .= "usuario = '$usuario', ";
      }

      if (!empty($senha)) {
        $sql .= "senha = '$senha', ";
      }

      $sql = rtrim($sql, ', ');
      $sql .= " where id_professor = $id_professor";

      $this->db->query($sql);

      if ($this->db->affected_rows() > 0) {
        $dados = array('codigo' => 1, 'msg' => 'Dados do professor atualizados corretamente');
      } else {
        $dados = array('codigo' => 2, 'msg' => 'Houve algum problema na atualização do professor.');
      }
    } else {
      $dados = array('codigo' => 6, 'msg' => 'ID do professor não está na base de dados');
    }

    return $dados;
  }

  public function apagarProfessor($id_professor)
  {
    $retornoProfessor = $this->consultarSoProfessor($id_professor);

    if ($retornoProfessor['codigo'] == 1) {
      $sql = "update professor set estatus = 'D' where id_professor = $id_professor";

      $this->db->query($sql);

      if ($this->db->affected_rows() > 0) {
        $dados = array('codigo' => 1, 'msg' => 'Professor desativado corretamente');
      } else {
        $dados = array('codigo' => 2, 'msg' => 'Houve um problema na desativação do professor');
      }
    } else {
      $dados = array('codigo' => 4, 'msg' => 'O professor informado não está na base de dados');
    }

    return $dados;
  }

  public function ativarProfessor($id_professor)
  {
    $retornoProfessor = $this->consultarSoProfessor($id_professor);

    if ($retornoProfessor['codigo'] == 1) {
      $sql = "update professor set estatus = '' where id_professor = $id_professor";

      $this->db->query($sql);

      if ($this->db->affected_rows() > 0) {
        $dados = array('codigo' => 1, 'msg' => 'Professor reativado corretamente');
      } else {
        $dados = array('codigo' => 2, 'msg' => 'Houve um problema na reativação do professor');
      }
    } else {
      $dados = array('codigo' => 4, 'msg' => 'O ID informado não está na base de dados');
    }

    return $dados;
  }


  public function consultarUsuario($usuario, $senha)
  {
    $sql = "select * from professor where usuario = '$usuario' and senha = '$senha'";

    $retorno = $this->db->query($sql);

    if ($retorno->num_rows() > 0) {
      $dados = array('codigo' => 1, 'msg' => 'consulta efetuada com sucesso');
    } else {
      $dados = array('codigo' => 2, 'msg' => 'dados nao encontrados');
    }

    return $dados;
  }

	///////////////////////////////////////////////////////////////// LOGIN PROFESSOR /////////////////////////////////////////////////////////////////////////////

  public function loginProfessor($usuario, $senha)
  {
    $sql = "select * from professor where usuario = '$usuario' and senha = '$senha'";

    $retorno = $this->db->query($sql);

    if ($retorno->num_rows() > 0) {
      $dados = array('codigo' => 1, 'msg' => 'Usuario é professor');
    } else {
      $dados = array('codigo' => 2, 'msg' => 'dados nao encontrados');
    }

    return $dados;
  }

	///////////////////////////////////////////////////////////////// TABELA CURSO PROFESSOR /////////////////////////////////////////////////////////////////////////////

  public function InserirProfCurso($id_professor, $idCurso)
  {
    $retornoProfessorCurso = $this->consultarSoCursoProf($id_professor, $idCurso);

    if ($retornoProfessorCurso['codigo'] == 2) {
      $sql = "insert into cursoprof (id_professor, id_curso) values ('$id_professor', '$idCurso')";
      $this->db->query($sql);

      if ($this->db->affected_rows() > 0) {
        $dados = array('codigo' => 1, 'msg' => 'Designação do professor ao curso completa com sucesso.');
      } else {
        $dados = array('codigo' => 2, 'msg' => 'Houve algum problema na designação.');
      }
    } else {
      $dados = array('codigo' => 0, 'msg' => 'Professor já designado para esse curso');
    }

    return $dados;
  }

  public function consultarCursoProf($idCurso, $idProfessor, $estatus)
	{
			$sql = "SELECT * FROM cursoprof WHERE estatus = '$estatus'";
	
			if (!empty($idProfessor)) {
					$sql .= " AND id_professor = '$idProfessor'";
			}
	
			if (!empty($idCurso)) {
					$sql .= " AND id_curso = '$idCurso'";
			}
	
			$retorno = $this->db->query($sql);
	
			if ($retorno->num_rows() > 0) {
					$dados = array(
							'codigo' => 1,
							'msg' => 'Consulta efetuada com sucesso',
							'dados' => $retorno->result()
					);
			} else {
					$dados = array(
							'codigo' => 2,
							'msg' => 'Dados não encontrados'
					);
			}
	
			return $dados;
	}

	public function consultarSoCursoProf($idCurso, $id_professor)
{
    $sql = "select * from cursoprof where id_professor = $id_professor AND id_curso = $idCurso";
    $retorno = $this->db->query($sql);

    if ($retorno->num_rows() > 0) {
        $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso.');
    } else {
        $dados = array('codigo' => 2, 'msg' => 'Dados não encontrados.');
    }

    return $dados;
}


	public function apagarProfCurso($idCurso, $id_professor)
{
    $retornoProfCurso = $this->consultarSoCursoProf($id_professor, $idCurso);

    if ($retornoProfCurso['codigo'] == 1) {
        $sql = "update cursoprof set estatus = 'D' where id_professor = $id_professor and id_curso = $idCurso";
        $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Professor curso desativado corretamente');
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Houve um problema na desativação do Professor curso');
        }
    } else {
        $dados = array('codigo' => 4, 'msg' => 'Prof Curso informado não está na base de dados');
    }

    return $dados;
}

public function ativarProfCurso($idCurso, $id_professor)
{
    $retornoProfCurso = $this->consultarSoCursoProf($id_professor, $idCurso);

    if ($retornoProfCurso['codigo'] == 1) {
        $sql = "update cursoprof set estatus = '' where id_professor = $id_professor and id_curso = $idCurso";
        $this->db->query($sql);

        if ($this->db->affected_rows() > 0) {
            $dados = array('codigo' => 1, 'msg' => 'Professor curso ativado corretamente');
        } else {
            $dados = array('codigo' => 2, 'msg' => 'Houve um problema na ativação do Professor curso');
        }
    } else {
        $dados = array('codigo' => 4, 'msg' => 'Prof Curso informado não está na base de dados');
    }

    return $dados;
}

}
