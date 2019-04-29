<div class="form-group">                            
    <label for="fornecedor_nome"> Nome do fornecedor: </label>
    <input type="text" id="fornecedor_nome" class="form-control  {{$errors->has('fornecedor_nome') ? 'is-invalid' : '' }}" name="fornecedor_nome" placeholder="Nome do fornecedor" value="{{ old('fornecedor_nome') }}">


     @if($errors->has('fornecedor_nome'))
        <div class='invalid-feedback'>
            {{$errors->first('fornecedor_nome')}}
        </div>
    @endif

</div> 
 
<div class="form-group">
    <label for="fornecedor_cnpj"> CNPJ: </label>
    <input type="text" id="fornecedor_cnpj" class="form-control {{$errors->has('fornecedor_cnpj') ? 'is-invalid' : ''}}" name="fornecedor_cnpj" placeholder="CNPJ da empresa" value="{{ old('fornecedor_cnpj') }}">



     @if($errors->has('fornecedor_cnpj'))
        <div class='invalid-feedback'>
            {{$errors->first('fornecedor_cnpj')}}
        </div>
    @endif

</div>

<div class="form-group">
    <label for="fornecedor_endereco"> Endereço: </label>
    <input type="text" id="fornecedor_endereco" class="form-control {{$errors->has('fornecedor_endereco') ? 'is-invalid' : ''}} " name="fornecedor_endereco" placeholder="Endereço da empresa" value="{{ old('fornecedor_endereco') }}">



     @if($errors->has('fornecedor_endereco'))
        <div class='invalid-feedback'>
            {{$errors->first('fornecedor_endereco')}}
        </div>
    @endif
</div>


<div class="form-group">
    <label for="fornecedor_email"> Email:  </label>
    <input type="text" id="fornecedor_email" class="form-control {{$errors->has('fornecedor_email') ? 'is-invalid' : ''}} " name="fornecedor_email" placeholder="Email para contato" value="{{ old('fornecedor_email') }}">



     @if($errors->has('fornecedor_email'))
        <div class='invalid-feedback'>
            {{$errors->first('fornecedor_email')}}
        </div>
    @endif
</div>

<div class="form-group">
    <label for="fornecedor_estado"> Estado:  </label>
    
    <select  id="fornecedor_estado" class="form-control {{$errors->has('fornecedor_estado') ? 'is-invalid' : ''}} " name="fornecedor_estado" data-valor="{{ old('fornecedor_estado') }}">
       
    </select>
    

     @if($errors->has('fornecedor_estado'))
        <div class='invalid-feedback'>
            {{$errors->first('fornecedor_estado')}}
        </div>
    @endif
    
</div>

