<?php
namespace App\Utilities;

use Carbon\Carbon;

/**
 * Class DateUtilities
 *
 * @package App\Utilities
 *
 * @author Mohammad Almawali <moealmaw@gmail.com>
 *
 * Creates an offset around a given date and flexibility days
 * i.e. offset for the date of 13/03/2018 with flexibility of 3 days returns:
 * ['min' =>  '10/03/2018', 'max' => 16/03/2018].
 *
 */
class DateUtilities
{
    /**
     *
     * @param Carbon $date
     *
     * @internal param $dateString
     * @internal param int $flexibility
     *
     */
    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    /**
     *
     * @param int $days
     *
     * @return array
     */
    public function makeOffset(int $days): array
    {
        return [
            'min' => $this->date->copy()->subDays($days)->toDateString(),
            'max' => $this->date->copy()->addDays($days)->toDateString(),
        ];
    }
}