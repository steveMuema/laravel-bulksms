<?php

namespace Afriq\CharCount;

use Laravel\Nova\Fields\Field;

class CharCount extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'char-count';

    
    public function withData($data)
    {
        return $this->withMeta([
            'myData' => $data,
        ]);
    }
}
