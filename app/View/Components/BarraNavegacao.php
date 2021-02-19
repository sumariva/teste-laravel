<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
/**
 * Prove a Barra de links de navegacao
 * @author cristiano
 *
 */
class BarraNavegacao extends Component
{
    protected Collection $links;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->links = new Collection();
    }
    
    public function addLink( $link ){
        
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.barra-navegacao', ['links' => $this->links]);
    }
    public function toHtml(){
        return $this->render();
    }
    public function compose(View $view)
    {
        dd('teste');
        $view->with('barraNavegacao', $this->links);
    }
}
