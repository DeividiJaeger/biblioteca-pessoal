<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'titulo' => 'required',
        'autor' => 'required',
        'resenha' => 'required|unique:livros'
    ]);

    $livro = new Livro();
    $livro->titulo = $request->input('titulo');
    $livro->autor = $request->input('autor');
    $livro->resenha = $request->input('resenha');

    if ($livro->save()) {
        return response()->json(['message' => 'Livro adicionado com sucesso'], 201);
    } else {
        return response()->json(['message' => 'Falha ao adicionar o livro'], 500);
    }
}

public function index()
{
    $livros = Livro::all();
    return response()->json($livros, 200);
}

public function show($id)
{
    $livro = Livro::find($id);

    if ($livro) {
        return response()->json($livro, 200);
    } else {
        return response()->json(['message' => 'Livro não encontrado'], 404);
    }
}
public function update(Request $request, $id)
{
    $request->validate([
        'titulo' => 'required',
        'autor' => 'required',
        'resenha' => 'required'
        // Adicione outras regras de validação conforme necessário
    ]);

    $livro = Livro::find($id);

    if (!$livro) {
        return response()->json(['message' => 'Livro não encontrado'], 404);
    }

    // Use o método fill para atualizar apenas os campos fornecidos no corpo da solicitação
    $livro->fill($request->all());

    if ($livro->save()) {
        return response()->json(['message' => 'Livro atualizado com sucesso'], 200);
    } else {
        return response()->json(['message' => 'Falha ao atualizar o livro'], 500);
    }
}

public function destroy($id)
{
    $livro = Livro::find($id);

    if ($livro) {
        if ($livro->delete()) {
            return response()->json(['message' => 'Livro excluído com sucesso'], 200);
        } else {
            return response()->json(['message' => 'Falha ao excluir o livro'], 500);
        }
    } else {
        return response()->json(['message' => 'Livro não encontrado'], 404);
    }
}


}
