<?php

namespace Conceptlz\ThunderboltLivewireTables\Views\Columns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Conceptlz\ThunderboltLivewireTables\Exceptions\DataTableConfigurationException;
use Conceptlz\ThunderboltLivewireTables\Views\Column;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Configuration\DateColumnConfiguration;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\Helpers\DateColumnHelpers;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\IsColumn;

class DateColumn extends Column
{
    use IsColumn;
    use DateColumnConfiguration,
        DateColumnHelpers;

    public string $inputFormat = 'Y-m-d';

    public string $outputFormat = 'Y-m-d';

    public string $emptyValue = '';

    protected string $view = 'thunderbolt-livewire-tables::includes.columns.date';

    public function getContents(Model $row): null|string|\BackedEnum|HtmlString|DataTableConfigurationException|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {

        $dateTime = $this->getValue($row);
        if (! ($dateTime instanceof \DateTime)) {
            try {
                // Check if format matches what is expected
                if (! \Carbon\Carbon::hasFormatWithModifiers($dateTime, $this->getInputFormat())) {
                    throw new \Exception('DateColumn Received Invalid Format');
                }

                // Create DateTime Object
                $dateTime = \DateTime::createFromFormat($this->getInputFormat(), $dateTime);
            } catch (\Exception $exception) {
                report($exception);

                // Return Null
                return $this->getEmptyValue();
            }
        }

        // Return
        return $dateTime->format($this->getOutputFormat());

    }
}
