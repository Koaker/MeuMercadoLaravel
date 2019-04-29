<div class="form-group">


    <label for="pf_fornecedor"> Fornecedor:  </label>

    <select class="form-control  {{$errors->has('pf_fornecedor') ? 'is-invalid' : '' }}" id='pf_fornecedor' name='pf_fornecedor' value="{{ old('pf_fornecedor') }}">
        <option hidden selected disabled>Selecine o fornecedor</option>
        @foreach ($fornecedores_select as $fornecedor)
        <option value='{{$fornecedor->id}}'>{{$fornecedor->nome.' CNPJ:'. $fornecedor->cnpj }}</option>
        @endforeach
    </select>

       @if($errors->has('pf_fornecedor'))
        <div class='invalid-feedback'>
            {{$errors->first('pf_fornecedor')}}
        </div>
    @endif

</div>


<div class="form-group">
    <label for="pf_produto"> Produto:  </label>

    <select class="form-control {{$errors->has('pf_produto') ? 'is-invalid' : '' }}" id='pf_produto' name='pf_produto' value="{{ old('pf_produto') }}">
        <option hidden selected disabled>Selecine o produto</option>
        @foreach ($produtos_select as $produto)
        <option value='{{$produto->id}}'>{{$produto->nome }}</option>
        @endforeach
    </select>


     @if($errors->has('pf_produto'))
        <div class='invalid-feedback'>
            {{$errors->first('pf_produto')}}
        </div>
    @endif

</div>

<div class="form-group">
    <label for="pf_estoque_minimo"> Estoque mínimo:  </label>
    <input type="text" id="pf_estoque_minimo" class="form-control {{$errors->has('pf_estoque_minimo') ? 'is-invalid' : ''}}" name="pf_estoque_minimo" placeholder="estoque mínimo a se adquirir" value="{{ old('pf_estoque_minimo') }}">

     @if($errors->has('pf_estoque_minimo'))
        <div class='invalid-feedback'>
            {{$errors->first('pf_estoque_minimo')}}
        </div>
    @endif
</div>



<div class="form-group">
    <label for="pf_estoque_entrada"> Estoque entrada:  </label>
    <input type="text" id="pf_estoque_entrada" class="form-control {{$errors->has('pf_estoque_entrada') ? 'is-invalid' : '' }}" name="pf_estoque_entrada" placeholder="Quantidade de produto a ser adquirida" value="{{ old('pf_estoque_entrada') }}">

     @if($errors->has('pf_estoque_entrada'))
        <div class='invalid-feedback'>
            {{$errors->first('pf_estoque_entrada')}}
        </div>
    @endif
</div>


