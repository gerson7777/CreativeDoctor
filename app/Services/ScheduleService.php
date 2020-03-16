<?php namespace App\Services;

use App\Interfaces\ScheduleServiceInterface;
use Carbon\Carbon;
use App\WorkDay;
use App\Appointment;


class ScheduleService implements ScheduleServiceInterface
{
    private function getDayFromDate($date)
    {
        
        $dateCarbon = new Carbon($date);
        $i = $dateCarbon->dayOfWeek;
        $day = ($i==0 ? 6 : $i-1);

        return $day;
    }
    public function getAvalibleIntervals($date, $doctorId)
    {
        $workDay = WorkDay::where('active', true)
        ->where('day', $this->getDayFromDate($date))
        ->where('user_id', $doctorId)
        ->first(
            [
                'morning_start', 
                'morning_end',
                'afternoon_start',
                'afternoon_end'
            ]);
    
        if(!$workDay)
        {
            return [];
        }
    
        $morningIntervals = $this->getIntervals(
            $workDay->morning_start,$workDay->morning_end,
            $date, $doctorId
        );

        $afternoonIntervals = $this->getIntervals(
            $workDay->afternoon_start,$workDay->afternoon_end,
            $date, $doctorId
        );

        //dd($morningIntervals);
            $data =[];
            $data['morning'] = $morningIntervals;
            $data['afternoon'] = $afternoonIntervals;

        return $data;
    }
    private function getIntervals($start, $end, $date, $doctorId)
    {
        $start = new Carbon($start);
        $end = new Carbon($end);
        
        $intervals = [];
        while($start < $end)
        {
            $interval = [];
            $interval['start'] = $start->format('g:i A');
             // si no existe una cita para este medico agragarlo al arreglo
             $exists = Appointment::where('doctor_id',$doctorId)
             ->where('scheduled_date', $date )
             ->where('scheduled_time', $start->format('H:i:s'))
             ->exists();

            $start->addMinutes(30);
            $interval['end'] = $start->format('g:i A');
           
            //dd($exists);
            if(!$exists)
            {
                $intervals [] = $interval;
            }

            
        } 
        return $intervals;

    }
}