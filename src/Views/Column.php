<?php

namespace Conceptlz\ThunderboltLivewireTables\Views;

use Illuminate\Support\Str;
use Conceptlz\ThunderboltLivewireTables\Views\Traits\IsColumn;

class Column
{
    use IsColumn;

    protected bool $displayColumnLabel = true;

    protected string $view = '';
    public $column_name ='';
    public function __construct(string $title, ?string $from = null)
    {
        $this->title = trim($title);

        if ($from) {
            
            $this->from = trim($from);
            $this->column_name = $this->from;
            $this->hash = md5($this->from);

            if (Str::contains($this->from, '.')) {
                $this->field = Str::afterLast($this->from, '.');
                $this->relations = explode('.', Str::beforeLast($this->from, '.'));
            } else {
                $this->field = $this->from;
            }
        } else {
            $this->field = Str::snake($title);
            $this->hash = md5($this->field);
        }
    
    }
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
    /**
     * @return static
     */
    public static function make(string $title, ?string $from = null): Column
    {
        return new static($title, $from);
    }
}
