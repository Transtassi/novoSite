<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;

class RoutesController extends Controller
{

  public function __construct()
  {
    $this->objBlog = new Blog();
  }

  // Função para mostrar a pagina inicial do site
  public function index()
  {
    $blogs = $this->objBlog->all();
    return view('pages.index', compact('blogs'));
  }

  // Função para mostrar a pagina Quem Somos
  public function whoWeAre()
  {
    return view('pages.whoWeAre');
  }

  // Função para mostrar a pagina Historia
  public function history()
  {
    return view('pages.history');
  }

  // Função para mostrar a pagina Politicas
  public function policy()
  {
    return view('pages.policy');
  }

  // Função para mostrar a pagina  Certificações e Licenças
  public function certifications()
  {
    return view('pages.certifications');
  }

  // Função para mostrar a pagina Serviços
  public function services()
  {
    return view('pages.services');
  }

  // Função para mostrar a pagina Blog
  public function blog()
  {
    $blogs = $this->objBlog->all();
    return view('pages.blog', compact('blogs'));
  }

  // Função para mostrar a pagina Fale Conosco
  public function contactUs()
  {
    return view('pages.contactUs');
  }

  // Função para mostrar a pagina Cotação
  public function price()
  {
    return view('pages.price');
  }

  // Função para mostrar a pagina Vendas
  public function sale()
  {
    return view('pages.sale');
  }

  // Função para mostrar a pagina de Locação
  public function location()
  {
    return view('pages.location');
  }

  // Função para mostrar a pagina Politica de Privacidade
  public function securityPolicy()
  {
    return view('pages.securityPolicy');
  }

  // Função para mostrar a noticia do blog
  public function premiodesustentabilidade()
  {
    return view('pages.premiodesustentabilidade');
  }

  // Função para mostrar a noticia do blog
  public function entrevistalogweb()
  {
    return view('pages.entrevistalogweb');
  }

  // Função para mostrar a noticia do blog
  public function simulacaodeemergencia()
  {
    return view('pages.simulacaodeemergencia');
  }

  // Função para mostrar a noticia do blog
  public function premiomaioresemelhores2021()
  {
    return view('pages.premiomaioresemelhores2021');
  }

  // Função para mostrar a noticia do blog
  public function diadascriancas2021()
  {
    return view('pages.diadascriancas2021');
  }

  // Função para mostrar a noticia do blog
  public function mascotes()
  {
    return view('pages.mascotes');
  }

  // Função para mostrar a noticia do blog
  public function unilever()
  {
    return view('pages.unilever');
  }

  // Função para mostrar a noticia do blog
  public function anostassi()
  {
    return view('pages.anostassi');
  }

  // Função para mostrar a noticia do blog
  public function frotaagas()
  {
    return view('pages.frotaagas');
  }
}
