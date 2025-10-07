<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Minha conta</title>
<link rel="shortcut icon" href="{{ asset('img/bahqespeto.png') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<!-- TOPO -->
<div class="topo">
  {{-- Usuário --}}
<a href="{{ Auth::check() ? url('/usuario') : url('/login') }}" style="display:flex; align-items:center;">
    @if(Auth::check())
        @php
            $user = Auth::user();
            $temFoto = $user->foto && file_exists(public_path($user->foto));
        @endphp

        @if($temFoto)
            <!-- Mostra a foto enviada pelo usuário -->
            <img src="{{ asset($user->foto) }}" 
                 alt="Usuário" 
                 style="width:40px; height:40px; border-radius:50%; object-fit:cover; margin-right:8px;">
        @else
            <!-- Mostra ícone fa-user se não houver foto -->
            <i class="fa fa-user" style="color:white; font-size:40px; margin-right:8px;"></i>
        @endif

        <p>{{ $user->usuario }}</p>
    @else
        <!-- Ícone padrão quando não logado -->
        <i class="fa fa-user" style="color:white; font-size:40px; margin-right:8px;"></i>
        <p>usuário</p>
    @endif
</a>


  <div class="search-container">
    <input type="text" id="pesquisa" class="pesquisa" placeholder="Buscar item..." autocomplete="off" />
    <ul id="sugestoes" class="sugestoes"></ul>
  </div>

  <i class="fa fa-bars" id="menu-toggle" style="color:white;font-size:40px;position:absolute;right:45px;top:35px;"></i>
  <div id="sidebar" style="position:fixed;top:0;right:0;width:300px;height:100%;background:rgb(45,45,45);display:none;padding:20px;z-index:1000;">
    <span id="close-btn" style="font-size:28px;cursor:pointer;position:absolute;left:15px;top:15px;">&times;</span>
    <ul style="list-style:none;padding-top:60px;">
      <li><a href="{{ route('cardapio') }}" style="color:white;text-decoration:none;font-size:18px">Nosso cardápio</a></li>
      <li><a href="#" onclick="acessarAdmin()">Sou Admin</a></li>

<script>
function acessarAdmin() {
    const codigo = prompt("Digite o código de acesso:");
    if(codigo === "02933") {
        // Redireciona direto para a página admin
        window.location.href = "/admin";
    } else if(codigo !== null) {
        alert("Código incorreto!");
    }
}
</script>
      <li><a href="{{ route('carrinho') }}" style="color:white;text-decoration:none;font-size:18px">Seu Carrinho</a></li>
      <li><a href="{{ url('/') }}" style="color:white;text-decoration:none;font-size:18px">Voltar ao início</a></li>
    </ul>
  </div>
</div>

<script>
// pesquisa / sugestões
const itens = ["Tricolor","Laçador","Beira-rio","Gurizinho","Chinelão","Cidade Baixa","Moinhos","Farrapos","Guaíba","Água","Cerveja","Refrigerante","Batata frita","Pão de alho","Pão de queijo"];
const input = document.getElementById("pesquisa");
const sugestoes = document.getElementById("sugestoes");

function mostrarSugestoes(lista){
  sugestoes.innerHTML="";
  lista.forEach(item=>{
    const li=document.createElement("li");
    li.textContent=item;
    li.onclick=()=>{ input.value=item; sugestoes.innerHTML=""; };
    sugestoes.appendChild(li);
  });
}

input.addEventListener("focus",()=>mostrarSugestoes(itens));
input.addEventListener("input",()=>{
  const valor=input.value.toLowerCase();
  if(valor.length===0){ mostrarSugestoes(itens); return; }
  const filtrados=itens.filter(i=>i.toLowerCase().startsWith(valor));
  mostrarSugestoes(filtrados);
});
input.addEventListener("keydown",(e)=>{
  if(e.key==="Enter"){ e.preventDefault(); window.location.href="{{ route('cardapio') }}"; }
});
document.addEventListener("click",(e)=>{ if(!e.target.closest(".search-container")) sugestoes.innerHTML=""; });

// menu lateral
const menuToggle=document.getElementById('menu-toggle');
const sidebar=document.getElementById('sidebar');
const closeBtn=document.getElementById('close-btn');
menuToggle.addEventListener('click',()=>{ sidebar.style.display='block'; setTimeout(()=>sidebar.classList.add('active'),10);});
closeBtn.addEventListener('click',()=>{ sidebar.classList.remove('active'); setTimeout(()=>sidebar.style.display='none',400);});
</script>

<!-- CONTEÚDO DO USUÁRIO -->
<div class="usuario">
  @php $user = auth()->user(); @endphp
  <h2>Bem-vindo, <span id="nomeUsuarioExibido">{{ $user->usuario }}</span>!</h2>

  @php
    $fotoUrl = $user && $user->foto ? asset($user->foto) : asset('img/usuarios/usuario.png');
  @endphp

  <div class="form-usuario" style="text-align:center;">
    <img id="fotoUsuario" src="{{ $fotoUrl }}?t={{ time() }}" alt="Foto do usuário" class="profile-img"
         style="display:block; margin:0 auto 10px; width:200px; height:200px; border-radius:50%; object-fit:cover; border:2px solid #fff; box-shadow:0 2px 6px rgba(0,0,0,0.2);">
    <input type="file" id="uploadFoto" accept="image/*" style="display:block; margin:10px auto;">
    <button type="button" id="confirmarFoto">Confirmar</button>
    <button type="button" id="removerFoto">Remover</button>
  </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
let cropper;
const uploadFoto=document.getElementById('uploadFoto');
const fotoUsuario=document.getElementById('fotoUsuario');
const confirmarFoto=document.getElementById('confirmarFoto');
const removerFoto=document.getElementById('removerFoto');

uploadFoto.addEventListener('change',(e)=>{
  const file=e.target.files[0];
  if(!file) return;
  const url=URL.createObjectURL(file);
  fotoUsuario.src=url;
  if(cropper) cropper.destroy();
  cropper=new Cropper(fotoUsuario,{ aspectRatio:1, viewMode:1 });
});

confirmarFoto.addEventListener('click',()=>{
  if(!cropper){ alert('Selecione e ajuste a foto antes de confirmar.'); return; }

  cropper.getCroppedCanvas({ width:400, height:400 }).toBlob(blob=>{
    if(!blob){ alert('Erro ao gerar imagem.'); return; }

    const formData=new FormData();
    formData.append('foto',blob,'perfil.png');

    fetch("{{ route('usuario.updatePhoto') }}",{
      method:'POST',
      headers:{ 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
      body:formData
    })
    .then(res=>res.json())
    .then(data=>{
      if(data.sucesso){
        fotoUsuario.onload=()=>{ URL.revokeObjectURL(fotoUsuario.src); };
        fotoUsuario.src=data.url+'?t='+new Date().getTime();
        if(cropper){ cropper.destroy(); cropper=null; }
        uploadFoto.value=null;
        alert('Foto atualizada com sucesso!');
      } else {
        alert('Erro ao atualizar: '+(data.erro||''));
      }
    }).catch(err=>{ console.error(err); alert('Erro ao enviar a foto.'); });
  },'image/png',0.9);
});

removerFoto.addEventListener('click',()=>{
  if(!confirm('Deseja remover a foto de perfil?')) return;

  fetch("{{ route('usuario.removePhoto') }}",{
    method:'POST',
    headers:{ 'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content }
  })
  .then(res=>res.json())
  .then(data=>{
    if(data.sucesso){
      fotoUsuario.src="{{ asset('img/usuarios/usuario.png') }}?t="+new Date().getTime();
      alert('Foto removida!');
    } else alert('Erro ao remover a foto.');
  }).catch(err=>console.error(err));
});
</script>

{{-- Form: atualizar nome de usuário --}}
<form id="formUsuario" class="form-usuario">
  @csrf
  <label>Nome de usuário:</label><br>
  <input type="text" name="usuario" value="{{ $user->usuario }}">
  <button type="submit">Atualizar</button>
  <div class="msg" id="msg-usuario"></div>
</form>

<script>
document.getElementById('formUsuario').addEventListener('submit',function(e){
  e.preventDefault();
  const form=e.currentTarget;
  const data=new FormData(form);
  fetch("{{ route('usuario.updateUser') }}",{ method:'POST', headers:{ 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }, body:data })
  .then(r=>r.json())
  .then(json=>{
    const msg=document.getElementById('msg-usuario');
    if(json.status==='ok'){
      document.getElementById('nomeUsuarioExibido').textContent=json.usuario;
      msg.textContent='Dados atualizados com sucesso!';
      msg.style.color='green';
    } else {
      msg.textContent=json.mensagem||'Erro ao atualizar.';
      msg.style.color='red';
    }
    msg.classList.add('show');
    setTimeout(()=>msg.classList.remove('show'),3000);
  }).catch(err=>console.error(err));
});
</script>

{{-- Form: atualizar senha --}}
<form id="form-senha" class="form-usuario">
  @csrf
  <label>Nova senha:</label><br>
  <input type="password" name="senha" placeholder="Nova senha" required>
  <input type="password" name="senha_confirmation" placeholder="Confirmar senha" required>
  <button type="submit">Atualizar</button>
  <div class="msg" id="msg-senha"></div>
</form>

<script>
document.getElementById('form-senha').addEventListener('submit',function(e){
  e.preventDefault();
  const form=e.currentTarget;
  const data=new FormData(form);
  fetch("{{ route('usuario.updatePassword') }}",{ method:'POST', headers:{ 'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content }, body:data })
  .then(r=>r.json())
  .then(json=>{
    const msg=document.getElementById('msg-senha');
    if(json.status==='ok'){
      msg.textContent='Senha atualizada!';
      msg.style.color='green';
    } else {
      msg.textContent=json.mensagem||'Erro ao atualizar.';
      msg.style.color='red';
    }
    msg.classList.add('show');
    setTimeout(()=>msg.classList.remove('show'),3000);
  }).catch(err=>console.error(err));
});
</script>

{{-- Form: telefone --}}
<form id="form-telefone" class="form-usuario">
  @csrf
  <label>Telefone:</label><br>
  <input type="text" name="telefone" value="{{ $user->telefone ?? '' }}" required>
  <button type="submit">Atualizar</button>
  <div class="msg" id="msg-telefone"></div>
</form>

<script>
document.getElementById('form-telefone').addEventListener('submit',function(e){
  e.preventDefault();
  const data=new FormData(e.currentTarget);
  fetch("{{ route('usuario.updatePhone') }}",{ method:'POST', headers:{ 'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content }, body:data })
  .then(r=>r.text())
  .then(()=>{
    const msg=document.getElementById('msg-telefone');
    msg.textContent='Telefone atualizado com sucesso!';
    msg.style.color='green';
    msg.classList.add('show');
    setTimeout(()=>msg.classList.remove('show'),3000);
  }).catch(()=>{
    const msg=document.getElementById('msg-telefone');
    msg.textContent='Erro ao atualizar!';
    msg.style.color='red';
    msg.classList.add('show');
    setTimeout(()=>msg.classList.remove('show'),3000);
  });
});
</script>

{{-- Form: endereço --}}
<form id="form-endereco" class="form-usuario">
  @csrf
  <label>Endereço:</label><br>
  <input type="text" name="endereco" value="{{ $user->endereco ?? '' }}" required>
  <button type="submit">Atualizar</button>
  <div class="msg" id="msg-endereco"></div>
</form>

<script>
document.getElementById('form-endereco').addEventListener('submit',function(e){
  e.preventDefault();
  const data=new FormData(e.currentTarget);
  fetch("{{ route('usuario.updateAddress') }}",{ method:'POST', headers:{ 'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content }, body:data })
  .then(r=>r.text())
  .then(()=>{
    const msg=document.getElementById('msg-endereco');
    msg.textContent='Endereço atualizado com sucesso!';
    msg.style.color='green';
    msg.classList.add('show');
    setTimeout(()=>msg.classList.remove('show'),3000);
  }).catch(()=>{
    const msg=document.getElementById('msg-endereco');
    msg.textContent='Erro ao atualizar!';
    msg.style.color='red';
    msg.classList.add('show');
    setTimeout(()=>msg.classList.remove('show'),3000);
  });
});
</script>

{{-- Deletar conta --}}
<form action="{{ route('usuario.destroy') }}" method="post" style="margin-top:10px;" class="form-usuario" onsubmit="return confirm('Tem certeza que deseja deletar sua conta? Esta ação é irreversível.');">
  @csrf
  <button type="submit" style="background-color:red; color:white;">Deletar Conta</button>
</form>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;" class="form-usuario">
    @csrf
    <button type="submit" style="background-color:darkred; color:white;">
        Sair
    </button>
</form>

</div>

<div class="fim">
  <p>©2025 BAHQESPETOS<br>Trazendo a cultura gaúcha com muito sabor<br>
  <a href="https://www.facebook.com" class="fa fa-facebook-official" style="color:white;font-size:32px"></a>
  <a href="https://www.instagram.com" class="fa fa-instagram" style="color:white;font-size:32px"></a><br><br>
  CNPJ: 10.978.458/0999-10<br>Av. Guilherme Schell, 478 - Canoas, RS</p>
</div>

</body>
</html>
