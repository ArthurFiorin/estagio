<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Professor extends CI_Controller
{

	private $json;
	private $resultado;

	private $idprofessor;
	private $nome;
	private $usuario;
	private $senha;
	private $estatus;

	public function getIdProfessor()
	{
		return $this->id_professor;
	}

	public function getNome()
	{
		return $this->nome;
	}

	public function getUsuario()
	{
		return $this->usuario;
	}

	public function getSenha()
	{
		return $this->senha;
	}

	public function getEstatus()
	{
		return $this->estatus;
	}

	public function setIdProfessor($id_professorFront)
	{
		$this->id_professor = $id_professorFront;
	}

	public function setNome($nomeFront)
	{
		$this->nome = $nomeFront;
	}

	public function setUsuario($usuario)
	{
		$this->usuario = $usuario;
	}

	public function setSenha($senha)
	{
		$this->senha = $senha;
	}

	public function setEstatus($estatusFront)
	{
		$this->estatus = $estatusFront;
	}

	public function inserirProfessor()
	{
		$json = file_get_contents('php://input');
		$resultado = json_decode($json);

		$lista = array("nome" => '0', "usuario" => '0', "senha" => '0', "estatus" => '0');

		if (verificarParam($resultado, $lista) == 1) {
			$this->setNome($resultado->nome);
			$this->setUsuario($resultado->usuario);
			$this->setSenha($resultado->senha);
			$this->setEstatus($resultado->estatus);

			if (trim($this->getNome()) == 0) {
				$retorno = array('codigo' => 5, 'msg' => 'nome do professor nao informado');
			} elseif ($this->getUsuario() == 0) {
				$retorno = array('codigo' => 8, 'msg' => 'usuario do  professor nao informado');
			} elseif ($this->getSenha() == "" || $this->getSenha() == 0) {
				$retorno = array('codigo' => 10, 'msg' => 'senha nao informada ou zerada');
			} elseif ($this->getEstatus() != "D" && $this->getEstatus() != "") {
				$retorno = array('codigo' => 4, 'msg' => 'status nao condiz com o permitido');
			} else {
				$this->load->model('M_professor');

				$retorno = $this->M_professor->inserirProfessor($this->getNome(), $this->getUsuario(), $this->getSenha(), $this->getEstatus());
			}
		} else {
			$retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de inserçao');
		}

		echo json_encode($retorno);
	}

	public function consultarProfessor()
	{
		$json = file_get_contents('php://input');
		$resultado = json_decode($json);

		$lista = array("id_professor" => '0', "nome" => '0', "usuario" => '0', "senha" => '0', "estatus" => '0');

		if (verificarParam($resultado, $lista) == 1) {
			$this->setIdProfessor($resultado->id_professor);
			$this->setNome($resultado->nome);
			$this->setUsuario($resultado->usuario);
			$this->setSenha($resultado->senha);
			$this->setEstatus($resultado->estatus);

			if ($this->getEstatus() != "D" && $this->getEstatus() != "") {
				$retorno = array('codigo' => 4, 'msg' => 'status nao condiz com o permitido');
			} else {
				$this->load->model('M_professor');

				$retorno = $this->M_professor->consultarProfessor($this->getIdProfessor(), $this->getNome(), $this->getUsuario(), $this->getSenha(), $this->getEstatus());
			}
		} else {
			$retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
		}

		echo json_encode($retorno);
	}

	public function consultarUsuario()
	{
		$json = file_get_contents('php://input');
		$resultado = json_decode($json);

		$lista = array("usuario" => '0', "senha" => '0');

		if (verificarParam($resultado, $lista) == 1) {
			$this->setUsuario($resultado->usuario);
			$this->setSenha($resultado->senha);


			if ($this->getEstatus() != "D" && $this->getEstatus() != "") {
				$retorno = array('codigo' => 4, 'msg' => 'status nao condiz com o permitido');
			} else {
				$this->load->model('M_professor');

				$retorno = $this->M_professor->consultarUsuario($this->getUsuario(), $this->getSenha(), $this->getEstatus());
			}
		} else {
			$retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
		}

		echo json_encode($retorno);
	}

	public function alterarProfessor()
	{
		$json = file_get_contents('php://input');
		$resultado = json_decode($json);

		$lista = array("id_professor" => '0', "nome" => '0', "usuario" => '0', "senha" => '0');

		if (verificarParam($resultado, $lista) == 1) {
			$this->setIdProfessor($resultado->id_professor);
			$this->setNome($resultado->nome);
			$this->setUsuario($resultado->usuario);
			$this->setSenha($resultado->senha);

			if ($this->getIdProfessor() == "" || $this->getIdProfessor() == 0) {
				$retorno = array('codigo' => 3, 'msg' => 'id do professor nao informado ou zerado');
			} else {
				$this->load->model('M_professor');
				$retorno = $this->M_professor->alterarProfessor($this->getIdProfessor(), $this->getNome(), $this->getUsuario(), $this->getSenha());
			}
		} else {
			$retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
		}

		echo json_encode($retorno);
	}

	public function apagarProfessor()
	{
		$json = file_get_contents('php://input');
		$resultado = json_decode($json);

		$lista = array("id_professor" => '0');

		if (verificarParam($resultado, $lista) == 1) {
			$this->setIdProfessor($resultado->id_professor);

			if (strlen($this->getIdProfessor()) == 0) {
				$retorno = array('codigo' => 3, 'msg' => 'id do professor nao informado');
			} else {
				$this->load->model('M_professor');
				$retorno = $this->M_professor->apagarProfessor($this->getIdProfessor());
			}
		} else {
			$retorno = array('codigo' => 4, 'msg' => 'o ra informado nao esta na base de dados');
		}

		echo json_encode($retorno);
	}

	public function ativarProfessor()
	{
		$json = file_get_contents('php://input');
		$resultado = json_decode($json);

		$lista = array("id_professor" => '0');

		if (verificarParam($resultado, $lista) == 1) {
			$this->setIdProfessor($resultado->id_professor);

			if (trim($this->getIdProfessor()) == 0) {
				$retorno = array('codigo' => 3, 'msg' => 'id do professor nao informado');
			} else {
				$this->load->model('M_professor');
				$retorno = $this->M_professor->ativarProfessor($this->getIdProfessor());
			}
		} else {
			$retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
		}

		echo json_encode($retorno);
	}

	///////////////////////////////////////////////////////////////// LOGIN PROFESSOR /////////////////////////////////////////////////////////////////////////////


	public function loginProfessor()
	{
		$json = file_get_contents('php://input');
		$resultado = json_decode($json);

		$lista = array("usuario" => '0', "senha" => '0');

		if (verificarParam($resultado, $lista) == 1) {

			$this->setUsuario($resultado->usuario);
			$this->setSenha($resultado->senha);


			if ($this->getEstatus() != "D" && $this->getEstatus() != "") {
				$retorno = array('codigo' => 4, 'msg' => 'status nao condiz com o permitido');
			} else {
				$this->load->model('M_professor');

				$retorno = $this->M_professor->loginProfessor($this->getUsuario(), $this->getSenha());
			}
		} else {
			$retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
		}

		echo json_encode($retorno);
	}


	///////////////////////////////////////////////////////////////// TABELA CURSO PROFESSOR /////////////////////////////////////////////////////////////////////////////


	public function InserirProfCurso()
	{
		$json = file_get_contents('php://input');
		$resultado = json_decode($json);

		$lista = array("id_professor" => '0', "idCurso" => '0');

		if (verificarParam($resultado, $lista) == 1) {
			$this->setIdProfessor($resultado->id_professor);
			$idCurso = $resultado->idCurso;

			if ($this->getIdProfessor() == "" && $this->getIdProfessor() == 0) {
				$retorno = array('codigo' => '0', 'msg' => 'ID do Professor não informado.');
			} elseif ($idCurso == "" && $idCurso == 0) {
				$retorno = array('codigo' => '1', 'msg' => 'ID do curso não informado');
			} else {
				$this->load->model('M_Professor');
				$retorno = $this->M_Professor->InserirProfCurso($this->getIdProfessor(), $idCurso);
			}
		} else {
			$retorno = array('codigo' => 99, 'msg' => 'Os campos vindos do front end não representam o método de inserção verifique.');
		}

		echo json_encode($retorno);
	}

	public function consultarCursoProf()
	{
		$json = file_get_contents('php://input');
		$resultado = json_decode($json);

		$lista = array("id_professor" => '0', "idCurso" => '0', 'estatus' => 0);

		if (verificarParam($resultado, $lista) == 1) {
			$this->setIdProfessor($resultado->id_professor);
			$this->setEstatus($resultado->estatus);
			$idCurso = $resultado->idCurso;


			if ($this->getIdProfessor() == "" && $this->getIdProfessor() == 0) {
				$retorno = array('codigo' => '0', 'msg' => 'ID do Professor não informado.');
			} elseif ($idCurso == "" && $idCurso == 0) {
				$retorno = array('codigo' => '1', 'msg' => 'ID do curso não informado');
			} else {
				$this->load->model('M_professor');

				$retorno = $this->M_professor->consultarCursoProf($this->getIdProfessor(), $this->getEstatus(), $idCurso);
			}
		} else {
			$retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
		}

		echo json_encode($retorno);
	}

	public function apagarProfCurso()
	{
		$json = file_get_contents('php://input');
		$resultado = json_decode($json);

		$lista = array("id_professor" => '0', "idCurso" => '0');

		if (verificarParam($resultado, $lista) == 1) {
			$this->setIdProfessor($resultado->id_professor);
			$idCurso = $resultado->idCurso;

			if ($this->getIdProfessor() == "" && $this->getIdProfessor() == 0) {
				$retorno = array('codigo' => '0', 'msg' => 'ID do Professor não informado.');
			} elseif ($idCurso == "" && $idCurso == 0) {
				$retorno = array('codigo' => '1', 'msg' => 'ID do curso não informado');
			} else {
				$this->load->model('M_professor');

				$retorno = $this->M_professor->apagarProfCurso($this->getIdProfessor(), $idCurso);
			}
		} else {
			$retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
		}

		echo json_encode($retorno);
		}

		public function ativarProfCurso()
  {

    $json = file_get_contents('php://input');
    $resultado = json_decode($json);

    $lista = array("id_professor" => '0', "idCurso" => '0');

		if (verificarParam($resultado, $lista) == 1) {
			$this->setIdProfessor($resultado->id_professor);
			$idCurso = $resultado->idCurso;

			if ($this->getIdProfessor() == "" && $this->getIdProfessor() == 0) {
				$retorno = array('codigo' => '0', 'msg' => 'ID do Professor não informado.');
			} elseif ($idCurso == "" && $idCurso == 0) {
				$retorno = array('codigo' => '1', 'msg' => 'ID do curso não informado');
			} else {
				$this->load->model('M_professor');

				$retorno = $this->M_professor->ativarProfCurso($this->getIdProfessor(), $idCurso);
			}
		} else {
			$retorno = array('codigo' => 99, 'msg' => 'os campos vindos do front nao representam o metodo de consulta');
		}

		echo json_encode($retorno);
  }
	}

