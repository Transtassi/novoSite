<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Clients;
use App\Models\Jobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
  private $objUsers;

  public function __construct()
  {
    // Inicializa os objetos
    $this->objUsers = new User();
    $this->objJobs = new Jobs();
    $this->objClients = new Clients();
    $this->objBlog = new Blog();
  }

  // Função para mostrar o dashboard
  public function dashboard(Request $request)
  {
    // Verifica se o usuário tentou conectar com um usuário válido
    if (Auth::check() === true) {
      // Verifica se o level é o de administrador
      // Se for retorna a tela de gerenciamento de usuário
      // Se não for retorna a tela do dashboard
      if (Auth::user()->level == 3) {
        $users = $this->objUsers->all();
        return view('admin.gerenciar.show', ['user' => $users]);
        // Caso o usuário for de level 1 ele pode acessar apenas a pagina de
        // admin do trabalhe conosco
      } else if (Auth::user()->level == 1) {
        return view('admin.index');
        // Caso o usuário seja de level 2 ele pode acessarapenas a pagina de
        // admin do blog
      } else if (Auth::user()->level == 2) {
        $searchBlog = request('searchBlog');

        if ($searchBlog) {
          $blog = $this->objBlog->where([
            ['id', 'like', '%' . $searchBlog . '%']
          ]);
          $blog = $this->objBlog->where([
            ['title', 'like', '%' . $searchBlog . '%']
          ]);
        } else {
          $blog = $this->objBlog->orderBy('id','desc')->get();
        }
        return view('admin.blog.index', compact('blog'));
      }
    }
    return redirect()->route('login');
  }

  // Função para atualizar a senha do e-mail que logou
  public function updateCadastro(Request $request)
  {
    if (Auth::check() === true) {
      if (Auth::user()->id == $request->id) {
        // Obtém os dados via request e salva no banco de dados
        if ($request->password != '') {
          $passwordHash = Hash::make($request->password);

          $up = $this->objUsers
            ->where(['id' => $request->id])
            ->update([
              'email' => $request->email,
              'password' => $passwordHash
            ]);
        } elseif ($request->name != '' && $request->password != '') {
          $passwordHash = Hash::make($request->password);

          $up = $this->objUsers
            ->where(['id' => $request->id])
            ->update([
              'name' => $request->name,
              'email' => $request->email,
              'password' => $passwordHash
            ]); } else {
          $up = $this->objUsers
            ->where(['id' => $request->id])
            ->update([
              'email' => $request->email
            ]);
        }
      }
      return redirect('/admin');
    }
    return redirect()->route('login');
  }

  // Função que mostra o formulário para criar um novo usuário
  // Apenas os Administradores tem acesso a essa tela
  public function readUsers()
  {
    if (Auth::check() == true) {
      return view('admin.gerenciar.create');
    }
    return redirect()->route('login');
  }

  // Função para criar um novo usuário para ter acesso ao dashboard
  // Apenas os Administradores tem acesso a essa tela
  public function store(Request $request)
  {
    if (Auth::check() === true) {
      try {
        $passwordHash = Hash::make($request->password);

        $cad = $this->objUsers->create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => $passwordHash,
          'level' => $request->level
        ]);

        if ($cad) {
          return redirect('/admin');
        }
      } catch (\Throwable $th) {
        throw $th;
        $msg = $th->getMessage();
        return view('admin.blog.create', ['erro' => $msg]);
      }
    }
    return redirect()->route('login');
  }

  // Função que leva ao formulário para atualizar os dados do usuário
  // Apenas os Administradores tem acesso a essa tela
  public function updateUser($id)
  {
    if (Auth::check() === true) {
      $user = $this->objUsers->find($id);
      return view('admin.gerenciar.update', compact('user'));
    }
    return redirect()->route('login');
  }

  // Função para atualizar os dados do usuário
  // Apenas os Administradores tem acesso a essa tela
  public function edit(Request $request, $id)
  {
    if (Auth::check() === true) {
      if ($request->password != '') {
        $passwordHash = Hash::make($request->password);

        $up = $this->objUsers
          ->where(['id' => $id])
          ->update([
            'email' => $request->email,
            'password' => $passwordHash
          ]);
      } else {

        $up = $this->objUsers
          ->where(['id' => $id])
          ->update([
            'email' => $request->email
          ]);
      }
      return redirect('/admin');
    }
    return redirect()->route('login');
  }

  // Função que deleta o usuário
  // Apenas os Administradores tem acesso a essa tela
  public function destroy($id)
  {
    if (Auth::check() === true) {
      try {
        $del = $this->objUsers->destroy($id);
        $del ? "sim" : "não";
        return redirect(('/admin'));
      } catch (\Throwable $th) {

        throw $th;
        $msg = $th->getMessage();
        return view('admin.blog.create', ['erro' => $msg]);
      }
    }
    return redirect()->route('login');
  }
}
	