<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    // Mostra a página do usuário
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Se não tiver foto, usa o ícone padrão (fa-user será usado no Blade)
        $fotoUrl = $user->foto ? asset($user->foto) : null;

        return view('usuario', [
            'usuarioModel' => $user,
            'fotoUrl' => $fotoUrl,
        ]);
    }

    // Atualiza a foto do usuário
    public function updatePhoto(Request $request)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['sucesso' => false, 'erro' => 'Não autenticado'], 401);

        if (!$request->hasFile('foto')) return response()->json(['sucesso' => false, 'erro' => 'Arquivo não enviado']);

        $file = $request->file('foto');
        if (!$file->isValid()) return response()->json(['sucesso' => false, 'erro' => 'Arquivo inválido']);

        $dir = public_path('img/usuarios');
        if (!file_exists($dir)) mkdir($dir, 0755, true);

        $extension = $file->getClientOriginalExtension() ?: 'png';
        $filename = 'user_' . $user->id . '_' . time() . '.' . $extension;

        // Remove foto antiga
        if (!empty($user->foto) && file_exists(public_path($user->foto))) {
            @unlink(public_path($user->foto));
        }

        // Salva nova foto
        $file->move($dir, $filename);
        $user->foto = 'img/usuarios/' . $filename;
        $user->save();

        return response()->json([
            'sucesso' => true,
            'url' => asset($user->foto)
        ]);
    }

    // Remove a foto do usuário (volta ao ícone fa-user)
    public function removePhoto(Request $request)
    {
        $user = auth()->user();
        if ($user->foto && file_exists(public_path($user->foto))) {
            unlink(public_path($user->foto));
        }
        $user->foto = null;
        $user->save();

        return response()->json(['sucesso' => true]);
    }

    // Atualiza nome e foto do usuário junto
    public function updateUser(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'usuario' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048' // Corrigido: foto pode ser enviada junto
        ]);

        $user->usuario = $request->input('usuario');

        // Atualiza foto se enviada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            if ($file->isValid()) {
                $dir = public_path('img/usuarios');
                if (!file_exists($dir)) mkdir($dir, 0755, true);

                $extension = $file->getClientOriginalExtension() ?: 'png';
                $filename = 'user_' . $user->id . '_' . time() . '.' . $extension;

                // Remove antiga
                if (!empty($user->foto) && file_exists(public_path($user->foto))) {
                    @unlink(public_path($user->foto));
                }

                $file->move($dir, $filename);
                $user->foto = 'img/usuarios/' . $filename;
            }
        }

        $user->save();

        return response()->json([
            'status' => 'ok',
            'usuario' => $user->usuario,
            'fotoUrl' => $user->foto ? asset($user->foto) : null
        ]);
    }

    // Atualiza senha
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'senha' => 'required|string|min:6|confirmed'
        ]);
        $user->password = Hash::make($request->senha);
        $user->save();
        return response()->json(['status' => 'ok']);
    }

    // Atualiza telefone
    public function updatePhone(Request $request)
    {
        $user = Auth::user();
        $request->validate(['telefone' => 'nullable|string|max:30']);
        $user->telefone = $request->telefone;
        $user->save();
        return response()->json(['status' => 'ok']);
    }

    // Atualiza endereço
    public function updateAddress(Request $request)
    {
        $user = Auth::user();
        $request->validate(['endereco' => 'nullable|string|max:255']);
        $user->endereco = $request->endereco;
        $user->save();
        return response()->json(['status' => 'ok']);
    }

    // Deleta conta
    public function destroy(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        if (!empty($user->foto) && file_exists(public_path($user->foto))) {
            @unlink(public_path($user->foto));
        }

        Auth::logout();
        $user->delete();

        return redirect('/')->with('mensagem', 'Conta deletada com sucesso!');
    }
}
