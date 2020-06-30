<?php


namespace App\Bean;

use EasySwoole\Spl\SplBean;

class TrackerPointBean extends SplBean
{
    protected $pointName;
    protected $pointId;
    protected $parentId;
    protected $startTime;
    protected $endTime;
    protected $status;
    protected $depth;
    protected $isNext;
}