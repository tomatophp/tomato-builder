<?php

namespace TomatoPHP\TomatoBuilder\Views;

use Illuminate\View\Component;
use ProtoneMedia\Splade\Components\Form;
use ProtoneMedia\Splade\Components\Form\InteractsWithFormElement;

class Digram extends Component
{
    use InteractsWithFormElement;

    public function __construct(
        public string $name = '',
        public string $vModel = '',
        public string $type = 'text',
        public string $label = '',
        private bool|array|string|null $date = null,
        private bool|array|string|null $time = null,
        public string $validationKey = '',
        public bool $showErrors = true,
        private bool $range = false,
        public string $prepend = '',
        public string $append = '',
        public string $help = '',
        public bool $alwaysEnablePrepend = false,
        public bool $alwaysEnableAppend = false,
    )
    {
        Form::allowAttribute($name);
    }

    /**
     * Returns a boolean whether the input type is 'hidden'.
     */
    public function isHidden(): bool
    {
        return $this->type === 'hidden';
    }

    public function render()
    {
        return view('tomato-builder::components.digram');
    }

}
