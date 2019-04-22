<div class="form-group">
    <label for="pf_fornecedor"> Fornecedor:  </label>

    <select class="form-control" id='pf_fornecedor' name='pf_fornecedor'>
        <option hidden selected disabled>Selecine o fornecedor</option>
        @foreach ($fornecedores_select as $fornecedor)
        <option value='{{$fornecedor->id}}'>{{$fornecedor->nome.' CNPJ:'. $fornecedor->cnpj }}</option>
        @endforeach
    </select>

</div>


<div class="form-group">
    <label for="pf_produto"> Fornecedor:  </label>

    <select class="form-control" id='pf_produto' name='pf_produto'>
        <option hidden selected disabled>Selecine o produto</option>
        @foreach ($produtos_select as $produto)
        <option value='{{$produto->id}}'>{{$produto->nome }}</option>
        @endforeach
    </select>

</div>

<div class="form-group">
    <label for="pf_estoque_minimo"> Estoque mínimo:  </label>
    <input type="text" id="pf_estoque_minimo" class="form-control" name="pf_estoque_minimo" placeholder="estoque mínimo a se adquirir">
</div>


<div class="form-group">
    <label for="pf_estoque_entrada"> Estoque entrada:  </label>
    <input type="text" id="pf_estoque_entrada" class="form-control" name="pf_estoque_entrada" placeholder="Quantidade de produto a ser adquirida">
</div>






