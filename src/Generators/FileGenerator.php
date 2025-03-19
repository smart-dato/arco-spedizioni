<?php

declare(strict_types=1);

namespace SmartDato\ArcoSpedizioni\Generators;

abstract class FileGenerator
{
    /**
     * @var array<int, array<string, string|int>>
     */
    protected array $structure = [];

    /**
     * @var array<int, array<mixed>>
     */
    private array $data = [];

    /**
     * @var array<string, string|float|int|bool>
     */
    private array $currentRecord = [];

    final public function setField(string $field, string $value): self
    {
        $this->currentRecord[$field] = $value;

        return $this;
    }

    final public function addRecord(): self
    {
        $this->data[] = $this->currentRecord;
        $this->currentRecord = [];

        return $this;
    }

    final public function store(string $filename): self
    {
        $fileContent = $this->formatData();
        file_put_contents($filename, $fileContent);

        return $this;
    }

    final public function content(): string
    {
        return $this->formatData();
    }

    private function formatData(): string
    {
        $formattedLines = [];
        foreach ($this->data as $record) {
            // Create a blank line of the appropriate length
            $line = $this->blankLine();

            // Fill each field at the correct position
            foreach ($this->structure as $fieldInfo) {
                $value = $record[$fieldInfo['field']] ?? '';
                // Pad or truncate to the exact field length
                $string = ' ';
                $type = STR_PAD_RIGHT;
                if ($fieldInfo['type'] === 'N') {
                    $string = '0';
                    $type = STR_PAD_LEFT;
                }
                $value = mb_str_pad($value, $fieldInfo['length'], $string, $type);

                // Replace the substring in the line
                $line = substr_replace($line, $value, $fieldInfo['start'] - 1, $fieldInfo['length']);
            }

            $formattedLines[] = $line;
        }

        // Join lines with a newline character
        return implode("\n", $formattedLines)."\n";
    }

    private function blankLine(): string
    {
        $line = '';
        foreach ($this->structure as $fieldInfo) {
            $string = $fieldInfo['type'] === 'A' ? ' ' : '0';
            $line .= str_repeat($string, (int) $fieldInfo['length']);
        }

        return $line;
    }
}
