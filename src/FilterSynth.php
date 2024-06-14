<?php

namespace Conceptlz\ThunderboltLivewireTables;

use Illuminate\Database\ClassMorphViolationException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;
use Illuminate\Queue\SerializesAndRestoresModelIdentifiers;
use Illuminate\Database\Eloquent\Model;
use Conceptlz\ThunderboltLivewireTables\Views\Filter;
use Livewire\Drawer\Utils;

class FilterSynth extends Synth {
    use SerializesAndRestoresModelIdentifiers;

    public static $key = 'filter';

    static function match($target) {
        return $target instanceof Filter;
    }

    function dehydrate($target) {
        $class = $target::class;
        
        $data = json_decode(json_encode($target),true);
        $meta = ['class' => $class];
        $options = (isset($target->options)) ? $target->options : [];
        $data['options'] = $options;
        return [
            $data,
            $meta,
        ];
    }

    function hydrate($data, $meta) {
        $class = $meta['class'];
        if (! array_key_exists('name', $data)) {
            return new $class;
        }

        $model = new $meta['class']($data['name'],$data['key']);
        $model->options = $data['options'];
        return $model;
    }

    function get(&$target, $key) {
        throw new \Exception('Can\'t access model properties directly');
    }

    function set(&$target, $key, $value, $pathThusFar, $fullPath) {
        throw new \Exception('Can\'t set model properties directly');
    }

    function call($target, $method, $params, $addEffect) {
        throw new \Exception('Can\'t call model methods directly');
    }
}
