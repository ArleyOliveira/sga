<?php
/**
 * Created by PhpStorm.
 * User: arley
 * Date: 25/03/17
 * Time: 11:53
 */

namespace SistemaAcesso\SchoolBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ItemsSchedule
 * @package SistemaAcesso\SchoolBundle\Entity
 */
class ItemSchedule
{
    /**
     * @var Environment
     * @Assert\NotBlank(message="schedule.blank_environment")
     */
    protected $environment;

    /**
     * @var integer
     * @Assert\NotBlank(message="schedule.blank_week_day")
     */
    protected $weekDay;

    /**
     * @var Assert\Time
     * @Assert\NotBlank(message="schedule.blank_start_time")
     */
    protected $startTime;

    /**
     * @var Assert\Time
     * @Assert\NotBlank(message="schedule.blank_end_time")
     */
    protected $endTime;

    /**
     * @var string
     */
    protected $activity;

    /**
     * @return Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param Environment $environment
     * @return ItemSchedule
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * @return int
     */
    public function getWeekDay()
    {
        return $this->weekDay;
    }

    /**
     * @param int $weekDay
     * @return ItemSchedule
     */
    public function setWeekDay($weekDay)
    {
        $this->weekDay = $weekDay;
        return $this;
    }

    /**
     * @return Assert\Time
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param Assert\Time $startTime
     * @return ItemSchedule
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
        return $this;
    }

    /**
     * @return Assert\Time
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param Assert\Time $endTime
     * @return ItemSchedule
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param string $activity
     * @return ItemSchedule
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
        return $this;
    }


}