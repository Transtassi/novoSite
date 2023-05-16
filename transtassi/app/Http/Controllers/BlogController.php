<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
  private $objBlog;

  public function __construct()
  {
    $this->objBlog = new Blog();
  }

  public function showNews($title)
  {
    $blog = $this->objBlog->where('textNavigation', $title)->get();
    return view('pages.blogNews', compact('blog'));
  }

  // Função que vai retornar o formulário para criar a notícia
  public function showFormCreate()
  {
    if (Auth::check() == true) {
      return view('admin.blog.create');
    }
    return redirect()->route('login');
  }

  // Função para criar a notícia
  public function create(Request $request)
  {
    if (Auth::check() == true) {
      // Utilizando o try catch para que não haja nenhum erro e caso houver
      // mostrar para o usuário para que seja reportado depois o erro
      try {
        // Verifica se o arquivo foi enviado
        // Se não foi retorna mensagem de erro
        if ($request->hasFile('image')) {

          // Pega o nome original da imagem
          $name_image = $request->image->getClientOriginalName();

          // Pega a extensão do arquivo
          $extension = $request->image->getClientOriginalExtension();

          // Verifica se a extensão é diferente de JPG, só será aceito JPG
          // Se for diferente retorna mensagem de erro
          if ($extension != 'jpg') {
            return redirect()->back()->with('erro', 'ERRO! Só é permitido imagens JPG');
          } else {
            $filename = pathinfo($name_image, PATHINFO_FILENAME);

            $name_upload = time() . $filename . '.' . $extension;

            $upload = $request->file('image')->storeAs('', $name_upload);

            $blog = $this->objBlog->create([
              'title' => $request->title,
              'subtitle' => $request->subtitle,
              'text' => html_entity_decode($request->text),
              'description_text' => $request->description_text,
              'image' => $upload,
              'category' => $request->category,
              'level' => $request->level,
              'statusNews' => $request->statusNews,
              'textNavigation' => $request->textNavigation,
              'created_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo')),
              'update_at' => Carbon::now(new DateTimeZone('America/Sao_Paulo'))
            ]);
            if ($blog) {
              return redirect()->back()->with('success', 'Noticia criada com sucesso!');
            } else {
              session()->flash('msg', 'ERRO! Não foi possivel criar a notícia, tente mais tarde');
              return redirect()->back()->with('success', 'ERRO! Não foi possivel criar a notícia, tente mais tarde');
            }
          }
        }
      } catch (\Throwable $th) {
        throw $th;
        $msg = $th->getMessage();
        return view('admin.blog.create', ['erro' => $msg]);
      }
    }
    return redirect()->route('login');
  }

  // Função que leva ao formulário para atualizar a noticia
  public function updateBlog($id)
  {
    if (Auth::check() == true) {
      $blog = $this->objBlog->find($id);
      return view('admin.blog.update', compact('blog'));
    }
    return redirect()->route('login');
  }
  // Função para atualizar a notícia
  public function edit(Request $request, $id)
  {
    if (Auth::check() == true) {
      try {
        if ($request->statusNews != '') {
          $up = $this->objBlog
            ->where(['id' => $id])
            ->update([
              'statusNews' => $request->statusNews
            ]);
        }
        if ($request->level != '') {
          $up = $this->objBlog
            ->where(['id' => $id])
            ->update([
              'level' => $request->level
            ]);
        }
        if ($request->statusNews != '' and $request->level != '') {
          $up = $this->objBlog
            ->where(['id' => $id])
            ->update([
              'statusNews' => $request->statusNews,
              'level' => $request->level
            ]);
        }
        return redirect()->back()->with('success', 'Noticia atualizada com sucesso!');
      } catch (\Throwable $th) {
        throw $th;
        throw $th;
        $msg = $th->getMessage();
        return view('admin.blog.update', ['erro' => $msg]);
      }
    }
    return redirect()->route('login');
  }

  // Função para deletar a notícia
  public function delete($id)
  {
    if (Auth::check() == true) {
      try {
        $del = $this->objBlog->destroy($id);
        $del ? "sim" : "não";
        return redirect(('/admin'));
      } catch (\Throwable $th) {
        throw $th;
        $msg = $th->getMessage();
        return view('admin.blog.index', ['erro' => $msg]);
      }
    }
    return redirect()->route('login');
  }
}
