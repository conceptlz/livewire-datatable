@aware(['component'])

<div @class([
    'my-6 ' => $component->isTailwind(),
])>
    {{ $slot }}
</div>
