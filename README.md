![Package Logo](https://banners.beyondco.de/Laravel%20Livewire%20Tables.png?theme=light&packageName=rappasoft%2Flaravel-livewire-tables&pattern=hideout&style=style_1&description=A+dynamic+table+component+for+Laravel+Livewire&md=1&fontSize=100px&images=table)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/conceptlz/livewire-datatable.svg?style=flat-square)](https://packagist.org/packages/conceptlz/livewire-datatable)
[![Styling](https://github.com/conceptlz/livewire-datatable/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/conceptlz/livewire-datatable/actions/workflows/php-cs-fixer.yml)
[![Tests](https://github.com/conceptlz/livewire-datatable/actions/workflows/run-tests.yml/badge.svg)](https://github.com/conceptlz/livewire-datatable/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/conceptlz/livewire-datatable.svg?style=flat-square)](https://packagist.org/packages/conceptlz/livewire-datatable)
[![codecov](https://codecov.io/gh/conceptlz/livewire-datatable/graph/badge.svg?token=1B9VKO9KWG)](https://codecov.io/gh/conceptlz/livewire-datatable)
![PHP Stan Level 5](https://img.shields.io/badge/PHPStan-level%205-brightgreen.svg?style=flat)

### Enjoying this package? [Buy me a beer 🍺](https://www.buymeacoffee.com/rappasoft)

A dynamic Laravel Livewire component for data tables.

![Dark Mode](https://imgur.com/QoEdC7n.png)

![Full Table](https://i.imgur.com/2kfibjR.png)

### [Bootstrap 4 Demo](https://tables.laravel-boilerplate.com/bootstrap-4) | [Bootstrap 5 Demo](https://tables.laravel-boilerplate.com/bootstrap-5) | [Tailwind Demo](https://tables.laravel-boilerplate.com/tailwind) | [Demo Repository](https://github.com/conceptlz/livewire-datatable-demo)

## Installation

You can install the package via composer:

``` bash
composer require conceptlz/livewire-datatable
```

You must also have [Alpine.js](https://alpinejs.dev) version 3 or greater installed and available to the component.

## Documentation and Usage Instructions

See the [documentation](https://rappasoft.com/docs/laravel-livewire-tables) for detailed installation and usage instructions.

## Basic Example

```php
<?php

namespace App\Http\Livewire\Admin\User;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UsersTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),
            Column::make('Name')
                ->sortable(),
        ];
    }
}

```

### [See advanced example](https://rappasoft.com/docs/laravel-livewire-tables/v2/examples/advanced-example)

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please e-mail anthony@rappasoft.com to report any security vulnerabilities instead of the issue tracker.

## Credits

- [Anthony Rappa](https://github.com/rappasoft)
- [Joe McElwee](https://github.com/lrljoe)
- [All Contributors](./CONTRIBUTORS.md)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
