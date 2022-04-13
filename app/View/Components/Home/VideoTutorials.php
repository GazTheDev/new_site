<?php

namespace App\View\Components\Home;

use Illuminate\View\Component;

class VideoTutorials extends Component
{
    public array $videoTutorials = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->videoTutorials = [
            [
                'videoId' => 'Ex9FZlIU4ss',
                'title' => 'Flying with Gaz - EP1 - Hindhead',
                'description' => 'My first ever video published onto Flying with Gaz.'
            ],
        
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.home.video-tutorials');
    }
}
