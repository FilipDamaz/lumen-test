<?php

namespace App\Logs;

class Logs extends AbstractLogs {

    private $logsClass;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        // based on Request or some difrent options (can be done in some env configuration, db layer etc) create logClass

        $this->logsClass = new FileLogs();
    }


    public function writeLogs(LogsModel $logMessage)
    {
        $this->logsClass->writeLogs($logMessage);
    }

    public function searchLogs(LogsSearchOptionModel $options)
    {
        $this->logsClass->searchLogs($options);
    }

    public function readLogs($idLog) : LogsModel
    {
        $this->logsClass->readLogs($idLog);
    }


}
