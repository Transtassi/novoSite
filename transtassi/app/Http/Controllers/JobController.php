<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use App\Models\ListCity;
use App\Models\ListCourse;
use App\Models\ListUf;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
  private $objJobs;
  private $objListCity;
  private $objListUf;
  private $objListCourse;

  public function __construct()
  {
    // Inicia os objetos
    $this->objJobs = new Jobs();
    $this->objListCourse = new ListCourse();
    $this->objListCity = new ListCity();
    $this->objListUf = new ListUf();
  }

  // Função para mostrar as vagas disponiveis
  public function workWithUs()
  {
    $jobs = $this->objJobs->paginate(30);
    return view('pages.workWithUs', compact('jobs'));
  }

  // Função para mostrar todas as vagas criadas
  public function show()
  {
    $jobs = $this->objJobs->paginate(30);
    return view('admin.tableJobs', compact('jobs'));
  }

  // Função para mostrar o formulário da vaga que foi selecionada
  public function indexForm($id)
  {
    $city = $this->objListCity->all();
    $uf = $this->objListUf->all()->sort();
    $course = $this->objListCourse->all();
    $job = $this->objJobs->find($id);
    return view('pages.workWithUsForm', compact('job', 'city', 'uf', 'course'));
  }

  // Função para criar uma vaga
  public function createJob(Request $request)
  {
    if (Auth::check() == true) {

      try {
        $job = $this->objJobs->create([
          'name' => $request->name,
          'city' => $request->city,
          'uf' => $request->uf,
          'department' => $request->department,
          'description' => $request->description,
          'status' => $request->status,
          'created_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo')),
          'update_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo')),
        ]);

        if ($job) {
          return true;
        } else {
          return false;
        }
      } catch (\Throwable $th) {
        throw $th;
        $msg = $th->getMessage();
        return view('admin', ['erro' => $msg]);
      }
    }
    return redirect()->route('login');
  }

  // Função para mostrar o formulário para editar
  public function getEdit($id)
  {
    if (Auth::check() == true) {
      $job = $this->objJobs->find($id);
      return view('admin.formUpdate', compact('job'));
    }
    return redirect()->route('login');
  }

  // Função para atualizar os dados da vaga
  // É possivel atualizar apenas um campo ou alterar todos os campos
  public function updateJob(Request $request, $id)
  {
    if (Auth::check() == true) {
      try {
        if (
          $request->name != '' && $request->city != ''
          && $request->uf != '' && $request->department != ''
          && $request->status != '' && $request->description != ''
        ) {

          $up = $this->objJobs->where(['id' => $id])->update([
            'name' => $request->name,
            'city' => $request->city,
            'uf' => $request->uf,
            'department' => $request->department,
            'status' => $request->status,
            'description' => $request->description,
            'update_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo')),
          ]);
        } elseif (
          $request->city != '' && $request->uf != ''
          && $request->department != '' && $request->status != ''
          && $request->description != ''
        ) {
          $up = $this->objJobs->where(['id' => $id])->update([
            'city' => $request->city,
            'uf' => $request->uf,
            'department' => $request->department,
            'status' => $request->status,
            'description' => $request->description,
            'update_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo')),
          ]);
        } elseif (
          $request->department != '' && $request->status != ''
          && $request->description != ''
        ) {
          $up = $this->objJobs->where(['id' => $id])->update([
            'department' => $request->department,
            'status' => $request->status,
            'description' => $request->description,
            'update_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo')),
          ]);
        } elseif ($request->status != '' && $request->description != '') {
          $up = $this->objJobs->where(['id' => $id])->update([
            'status' => $request->status,
            'description' => $request->description,
            'update_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo')),
          ]);
        } elseif ($request->status != '') {
          $up = $this->objJobs->where(['id' => $id])->update([
            'status' => $request->status,
            'update_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo')),
          ]);
        } elseif ($request->name != '') {
          $up = $this->objJobs->where(['id' => $id])->update([
            'name' => $request->name,
            'update_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo')),
          ]);
        } elseif ($request->city != '') {
          $up = $this->objJobs->where(['id' => $id])->update([
            'city' => $request->city,
            'update_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo')),
          ]);
        } elseif ($request->department != '') {
          $up = $this->objJobs->where(['id' => $id])->update([
            'department' => $request->department,
            'update_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo')),
          ]);
        } elseif ($request->description != '') {
          $up = $this->objJobs->where(['id' => $id])->update([
            'description' => $request->description,
            'update_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo')),
          ]);
        }

        return redirect('/admin');
      } catch (\Throwable $th) {
        throw $th;
        $msg = $th->getMessage();
        return view('admin.blog.index', ['erro' => $msg]);
      }
    }
    return redirect()->route('login');
  }

  // Função para deletar uma vaga
  /*public function destroyJob($id)
  {
    if (Auth::check() == true) {
      try {
        $del = $this->objJobs->destroy($id);
        $del ? "sim" : "não";
        return redirect('/admin');
      } catch (\Throwable $th) {
        throw $th;
        $msg = $th->getMessage();
        return view('admin.blog.index', ['erro' => $msg]);
      }
    }
    return redirect()->route('login');
  }*/
  //TESTE IA
  public function destroyJob($id)
  {
    if (Auth::check() == true) {
      try {
        $del = $this->objJobs->destroy($id);
        if($del){
          return redirect('/admin')->with('success', 'Registro exclu�do com sucesso.');
        }
        return redirect('/admin')->with('error', 'Erro ao excluir o registro.');
      } catch (\Throwable $th) {
        $msg = $th->getMessage();
        return view('admin.blog.index', ['erro' => $msg]);
      }
    }
    return redirect()->route('login');
  }
}
	