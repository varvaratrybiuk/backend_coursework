<?php

namespace models\users;

use DateTime;
use models\Date;

class Birthday extends Date
{
    /**
     * @throws \Exception
     */
    public function __construct(int|string $dayOrString, ?int $month = null, ?int $year = null)
    {
        parent::__construct($dayOrString, $month, $year);
        $this->notFutureDate();
    }

    /**
     * @throws \Exception
     */
    private function notFutureDate(): void
    {
        $inputDate = new DateTime($this->getYear() . '-' . $this->getMonth() . '-' . $this->getDay());
        $currentDate = new DateTime();

        if ($inputDate > $currentDate) {
            throw new \Exception("Неправильний формат дня народження");
        }
    }
}