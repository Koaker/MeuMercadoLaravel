<div class="form-group">                            
    <label for="produto_nome"> Nome do produto: </label>
    <input type="text" id="produto_nome" class="form-control {{$errors->has('produto_nome') ? 'is-invalid' : '' }}" name="produto_nome" placeholder="Nome do produto" value="{{ old('produto_nome') }}">

    @if($errors->has('produto_nome'))
    	<div class='invalid-feedback'>
    		{{$errors->first('produto_nome')}}
    	</div>
    @endif
</div> 

<div class="form-group">
    <label for="produto_tipo"> Tipo: </label>
    <input type="text" id="produto_tipo" class="form-control {{$errors->has('produto_tipo') ? 'is-invalid' : ''}}" name="produto_tipo" placeholder="Tipo do produto" value="{{ old('produto_tipo') }}">

       @if($errors->has('produto_tipo'))
    	<div class='invalid-feedback'>
    		{{$errors->first('produto_tipo')}}
    	</div>
    @endif
</div>

<div class="form-group">
    <label for="produto_valor"> Valor: </label>
    <input type="text" id="produto_valor" class="form-control {{$errors->has('produto_valor') ? 'is-invalid' : ''}}" name="produto_valor" placeholder="Valor do produto" value="{{ old('produto_valor') }}">

       @if($errors->has('produto_valor'))
    	<div class='invalid-feedback'>
    		{{$errors->first('produto_valor')}}
    	</div>
    @endif
</div>

<div class="form-group">
  <label for="produto_estoque_minimo"> Estoque mínimo do produto:  </label>
    <input type="text" id="produto_estoque_minimo" class="form-control {{$errors->has('produto_estoque_minimo') ? 'is-invalid' : '' }}" name="produto_estoque_minimo" placeholder="Mínimo de produtos a serem inseridos" value="{{ old('produto_estoque_minimo') }}">    

       @if($errors->has('produto_estoque_minimo'))
    	<div class='invalid-feedback'>
    		{{$errors->first('produto_estoque_minimo')}}
    	</div>
    @endif
</div>