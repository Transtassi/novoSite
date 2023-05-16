<?php

namespace App\Http\Controllers;

use App\Models\ListCity;
use App\Models\ListUf;
use App\Models\ListCourse;
use DOMDocument;
use Illuminate\Http\Request;

class FieldsController extends Controller
{
  // Importar Dados do Excel e salva os dados no banco de dados
  private $objListCity;
  private $objListUf;
  private $objListCourse;

  public function __construct()
  {
    // Inicia os objetos
    $this->objListCity = new ListCity();
    $this->objListUf = new ListUf();
    $this->objListCourse = new ListCourse();
  }

  // Função para mostrar a tela para fazer o upload dos arquivos
  public function index()
  {
    $listCity = $this->objListCity->all();
    $listUf = $this->objListUf->all();
    $listCourse = $this->objListCourse->all();
    return view('pages.field', compact('listCity', 'listUf', 'listCourse'));
  }

  // Criar a lista de cidades do Brasil
  public function createListCity()
  {
    if (!empty($_FILES['arquivo']['tmp_name'])) {
      $arquivo = new DOMDocument();
      $arquivo->load($_FILES['arquivo']['tmp_name']);

      $linhas = $arquivo->getElementsByTagName("Row");

      $primeira_linha = true;

      foreach ($linhas as $linha) {
        if ($primeira_linha == false) {

          if (!empty($linha->getElementsByTagName("Data")->item(0)->nodeValue)) {
            $uf = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
          }

          if (!empty($linha->getElementsByTagName("Data")->item(1)->nodeValue)) {
            $city = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
          }

          $cad = $this->objListCity->create([
            'uf' => $uf,
            'city' => $city,
          ]);
        }
        $primeira_linha = false;
      }
    }
  }

  // Criar a lista de estados do Brasil
  public function createListUf()
  {
    if (!empty($_FILES['arquivo']['tmp_name'])) {

      $arquivo = new DOMDocument();
      $arquivo->load($_FILES['arquivo']['tmp_name']);

      $linhas = $arquivo->getElementsByTagName("Row");

      $primeira_linha = true;

      foreach ($linhas as $linha) {
        if ($primeira_linha == false) {

          if (!empty($linha->getElementsByTagName("Data")->item(0)->nodeValue)) {
            $name = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
          }

          if (!empty($linha->getElementsByTagName("Data")->item(1)->nodeValue)) {
            $uf = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
          }

          $cad = $this->objListUf->create([
            'name' => $name,
            'uf' => $uf,
          ]);
        }
        $primeira_linha = false;
      }
    }
  }

  // Criar a lista de cursos
  public function createListCourse()
  {
    if (!empty($_FILES['arquivo']['tmp_name'])) {
      $arquivo = new DOMDocument();
      $arquivo->load($_FILES['arquivo']['tmp_name']);

      $linhas = $arquivo->getElementsByTagName("Row");

      foreach ($linhas as $linha) {
        if (!empty($linha->getElementsByTagName("Data")->item(0)->nodeValue)) {
          $course = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
        }

        $cad = $this->objListCourse->create([
          'course' => $course,
        ]);
      }
    }
  }
}
		