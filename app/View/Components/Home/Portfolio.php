<?php

namespace App\View\Components\Home;

use Illuminate\Support\Arr;
use Illuminate\View\Component;
use function url;
use function view;

class Portfolio extends Component
{
    public array $items = [];

    public array $tabs = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->items = [
            [
                'category' => ['WordPress', 'Client'],
                'title' => 'Full Website for bakery client in Braintree, Essex. Time taken: 4 days. ',
                'image' => url('/img/baby_bakes.png'),
                'github' => 'https://babybakes.co.uk'
            ],
            [
                'category' => ['WordPress', 'Client'],
                'title' => 'Full Website for market stall trader. Time taken: 4 days. ',
                'image' => url('/img/hat_city.png'),
                'github' => 'https://hat-city.co.uk'
            ],
            [
                'category' => ['WordPress', 'Football'],
                'title' => 'Coggeshall Unites Football Club ',
                'image' => url('/img/coggeshall.png'),
                'github' => 'https://coggeshallunitedfc.com/'
            ],
        ];

        $this->tabs = array_unique(Arr::flatten(Arr::pluck($this->items, 'category')));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.home.portfolio');
    }
}
