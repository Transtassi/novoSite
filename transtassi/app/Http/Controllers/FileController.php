<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
  // Função para realizar o download de imagens
  // Todas as imagens ficaram salvas na pasta storage
  public function downloadFile($name)
  {
    return response()->download(storage_path($name));
  }
}
