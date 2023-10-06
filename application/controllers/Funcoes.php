<?php
defined('BASEPATH') OR exit('No direct script access alowed');

class Funcoes extends CI_Controller{
	// Métodos da classe
	// Chamada da view de login
	public function index(){
		$this->load->view('professor/index');
	}

	public function insertaluno(){
		$this->load->view('professor/home');
	}
}
