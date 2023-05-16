<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Clients;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller

{
  private $objClients;

  public function __construct()
  {
    // Inicia os objetos
    $this->objClients = new Clients();
  }

  // Função para criar os usuários
  public function create(Request $request, $id)
  {
    // Utilizado o try catch para caso haja algum erro inesperado
    try {
      // Verifica se o arquivo foi enviado pela requisição
      if ($request->hasFile('curriculum')) {

        // Pega o nome do arquivo original
        $name_file = $request->curriculum->getClientOriginalName();

        // Pega a extensão do arquivo
        $extension = $request->curriculum->getClientOriginalExtension();

        $filename = pathinfo($name_file, PATHINFO_FILENAME);

        // Nome do arquivo e sua extensão que vai ser guardado no banco
        $name_upload = time() . '-' . $filename . '.' . $extension;

        // Faz o upload do arquivo
        $upload = $request->file('curriculum')->storeAS('', $name_upload);

        // Cria o usuário
        $cad = $this->objClients->create([
          'id_job' => $id,
          'name' => $request->name,
          'email' => $request->email,
          'phone' => $request->phone,
          'city' => $request->city,
          'uf' => $request->uf,
          'areas_interest' => $request->areas_interest,
          'education' => $request->education,
          'course' => $request->course,
          'salary' => $request->salary,
          'pcd' => $request->pcd,
          'description_client' => $request->description_client,
          'curriculum' => $upload,
          'created_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo')),
          'update_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo'))
        ]);
        if ($cad) {
          // Envia o e-mail para o cliente depois de clicar em cadastrar
          $client = $cad;
          Mail::send(new SendMail($client));
          return redirect()->back()->with('message', 'Currículo cadastrado com sucesso!');

        } else {
          $request->session()->flash('alert-danger', 'Falha ao cadastrar curríulo!.');
          return redirect('/');
        }
      }
    } catch (\Throwable $th) {
      throw $th;
      $msg = 'Não foi possível cadastrar o seu currículo, tente novamente mais tarde';
      return redirect('/trabalheconosco', ['erro' => $msg]);
    }
  }

  // Função para mostrar os clients na tabela
  public function index()
  {
    if (Auth::check() === true) {
      $clients = $this->objClients->all();


      return $clients;
    }

    return redirect()->route('login');
  }

  // Função para retornar apenas um client
  // Primeiro é feito a verificação para saber se o usuário está logado
  public function show($id)
  {
    if (Auth::check() == true) {
      $client = $this->objClients->where('id', $id)->get();

      return $client;
    }

    return redirect()->route('login');
  }
}
