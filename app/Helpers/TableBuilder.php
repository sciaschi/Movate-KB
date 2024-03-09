<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Collection;

class TableBuilder
{
    public string|array|Collection $data;
    public array $columns;
    public string $html;
    public array $options;

    /**
     *
     */
    public function __construct($columns, $data, array $options = [])
    {
        $this->columns  = $columns;
        $this->data     = $data;
        $this->options  = $options;
    }

    /**
     * @return string
     */
    public function make() {
        $table = '<table class="table table-striped">';

            $table .= '<thead>';
                $columns    = $this->columns;
                $columnKeys = [];

                $table .=   '<tr>';
                    foreach($columns as $column)
                    {
                        $classList = $column['classList'] ?? '';
                        $columnKeys[] = $column['id'];

                        $table .= '<th class="' . $classList . '" scope="col">'. $column['name'] . '</th>';
                    }
                $table .=   '</tr>';
            $table .= '</thead>';

            $table .= '<tbody>';
                if($this->data)
                {
                    foreach($this->data as $row)
                    {
                        $rowData = $row->only($columnKeys);

                        $table .= '<tr>';
                        foreach($columnKeys as $index => $key)
                        {
                            if($key == 'html')
                            {
                                $column = $columns[$index][$key];

                                $table .= $column instanceof \Closure ? '<td>'. $column($row) . '</th>' : '<td>'. $column . '</th>';
                            }
                            else
                            {
                                $table .= '<td>'. $rowData[$key] . '</th>';
                            }
                        }
                        $table .= '</tr>';

                    }
                }
            $table .= '</tbody>';

        $table .= '</table>';

        $this->html = $table;

        return $this->html;
    }

    /**
     * @return array|Collection|string
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @return Collection
     */
    public function getDataKeys($data) {
        if($data instanceof Collection)
        {
            $attributes = collect($data->first());

            return $attributes->keys();
        }

        return collect($data)->keys();
    }
}
