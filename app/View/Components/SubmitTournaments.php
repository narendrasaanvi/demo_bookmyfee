<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubmitTournaments extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.submit-tournaments');
    }
}
