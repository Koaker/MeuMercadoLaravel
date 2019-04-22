<?php

namespace App\Providers;
use App\Produto;
use Illuminate\Support\ServiceProvider;

class ProdutoProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
        view()->composer('*',function($view){
            $view->with('produtos_select', Produto::all());
        });
    
    }
}
