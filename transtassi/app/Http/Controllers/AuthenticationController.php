<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticationController extends Controller
{
  //Instância os objetos que farão a conexão com o banco
  private $objUsers;

  public function __construct()
  {
    //Inicializa os objetos
    $this->objUsers = new User();
  }

  public function dashboard()
  {
    if (Auth::check() === true) {
      $users = $this->objUsers::all();

      return view('dashboard.index', compact('users', 'items'));
    }

    return redirect()->route('login');
  }

  public function loginForm()
  {
    Auth::logout();
    return view('admin.login');
  }

  public function login(Request $request)
  {

    $credentials = [
      'email' => $request->email,
      'password' => $request->password
    ];

    if (Auth::attempt($credentials)) {
      return redirect()->route('dashboard');
    }

    return redirect()->back()->withInput()->withErrors(['Os dados informados estão incorretos.']);
  }

  public function logout()
  {
    if (Auth::check() === true) {
      Auth::logout();
    }

    return redirect()->route('login');
  }
}
