<?php

namespace App\Services;

class CsvReader
{
    private $file;
    private array $content;

    public function setFile(string $path): void
    {
        $this->file = fopen(base_path() . $path, 'r');
    }

    public function getContent(): ?array
    {
        if (!$this->file) {
            return null;
        }

        $row = 0;
        $columns = [];
        $content = [];

        while (($line = fgetcsv($this->file)) !== false) {
            if (!$row) {
                foreach ($line as $column) {
                    $columns[] = $column;
                }
            } else {
                foreach ($line as $key => $value) {
                    $content[$row - 1][$columns[$key]] = $value;
                }
            }

            ++$row;
        }

        fclose($this->file);
        $this->content = $content;

        return $content;
    }

    public function getLastContent(): array
    {
        return $this->content;
    }
}
