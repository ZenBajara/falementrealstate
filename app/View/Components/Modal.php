<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $title;
    public $show;

    public function __construct($title = '', $show = false)
    {
        $this->title = $title;
        $this->show = $show;
    }

    public function render()
    {
        return view('components.modal');
    }
}
