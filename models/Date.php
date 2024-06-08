<?php

namespace models;

use Exception;

class Date
{
    private int $day;
    private int $month;
    private int $year;

    /**
     * @throws Exception
     */
    public function __construct(int|string $dayOrString, ?int $month = null, ?int $year = null)
    {
        if (is_string($dayOrString)) {
            $this->createFromDateString($dayOrString);
            return;
        }
            $this->validateAndInitialize($dayOrString, $year, $month);
    }

    /**
     * @throws Exception
     */
    private function validateDate(int $day, int $month, int $year): void
    {
        if (!checkdate($month, $day, $year)) {
            throw new Exception("Неправильна дата: $year-$month-$day");
        }
    }

    public function __toString(): string
    {
        return sprintf('%04d-%02d-%02d', $this->year, $this->month, $this->day);
    }

    /**
     * @throws Exception
     */
    private function createFromDateString(string $dateString)
    {
        $dateParts = explode('-', $dateString);

        if (count($dateParts) !== 3) {
            throw new Exception("Неправильний формат: $dateString");
        }

        [$year, $month, $day] = $dateParts;
        $this->validateAndInitialize($day, $year, $month);
    }

    /**
     * @throws Exception
     */
    private function validateAndInitialize(int $day, int $year, int $month): void
    {
        $this->validateDate($day, $month, $year);
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }
    public function getDay(): int
    {
        return $this->day;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getYear(): int
    {
        return $this->year;
    }
}