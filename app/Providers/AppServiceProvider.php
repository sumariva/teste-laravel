<?php

namespace App\Providers;


use App\View\Components\BarraNavegacao;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //TODO compreender a diferenca entre View Composers e Componentes
        // ainda está confuso, acabei optando por uma diretiva do Blade
        //para realizar view parcial, preciso descobrir como gerar um
        // componente para manutenção da navegacao
        Blade::component( BarraNavegacao::class, 'barra-navegacao' );
        Blade::directive( 'navbar', function ($component) {
            return "<?php echo (app($component))->render(); ?>";
        });
        /*View::composer(
            'barraNavegacao', 'App\View\Components\BarraNavegacao'
            ); */
    }
}
