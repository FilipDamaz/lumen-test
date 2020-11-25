<?php

namespace App\Logs;

abstract class AbstractLogs {
    abstract protected function writeLogs(LogsModel $logMessage);
    abstract protected function searchLogs(LogsSearchOptionModel $options);
    abstract protected function readLogs($idLog) : LogsModel;
}
