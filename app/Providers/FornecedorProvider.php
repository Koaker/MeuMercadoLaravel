<?php
namespace App\Providers;
use App\Fornecedores;
use Illuminate\Support\ServiceProvider;

class FornecedorProvider extends ServiceProvider {

	public function boot(){
		view()->composer('*',function($view){
			$view->with('fornecedores_select', Fornecedores::all());
		});
	}
}