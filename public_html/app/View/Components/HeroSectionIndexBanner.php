<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeroSectionIndexBanner extends Component
{
     public $bannerdata;
    /**
     * Create a new component instance.
     */
    public function __construct($bannerdata = null)
{
    $this->bannerdata = $bannerdata ?? $this->bannerdata;
}


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.hero-section-index-banner');
    }
}
