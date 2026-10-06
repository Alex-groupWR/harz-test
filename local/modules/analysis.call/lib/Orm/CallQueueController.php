<?php

namespace Analysis\Call\Orm;

use Analysis\Call\Orm\Entity\CallQueuesTable;
use Analysis\Call\Orm\Entity\CallReportTable;
use PhpOffice\PhpWord\Exception\Exception;

class CallQueueController
{
    public static function addInQueue($call_data)
    {
        try {
            $result = CallQueuesTable::add([
                'IN_WORK' => 'N',
                'CALL_ID' => $call_data['call_id'],
                'RECORD_LINK' => $call_data['call_record_link'],
                'CALL_DATE' => \Bitrix\Main\Type\DateTime::createFromTimestamp($call_data['call_start_timestamp']),
                'USER_ID' => $call_data['user_id'],
            ]);

            if (!$result->isSuccess()) {
                throw new Exception($result->getErrorMessages());
            }
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public static function deleteQueue($id)
    {
        try {
            $result = CallQueuesTable::delete($id);
            if (!$result->isSuccess()) {
                throw new Exception($result->getErrorMessages());
            }
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public static function addStatistic($analysisData, $nameUser, $callData)
    {
        try {
            $result = CallReportTable::add([
                'MANAGER' => $nameUser,
                'CALL_DATETIME' => $callData,
                'GREETING' => $analysisData['greeting'] == 'да' ? 'Y' : 'N',
                'EMPLOYEE_INTRODUCED' => $analysisData['introduction'] == 'да' ? 'Y' : 'N',
                'NO_MONOSYLLABIC_ANSWERS' => $analysisData['detailed_answers'] == 'да' ? 'Y' : 'N',
                'POLITENESS' => $analysisData['politeness'] == 'да' ? 'Y' : 'N',
                'INTERRUPTION' => $analysisData['no_interruptions'] == 'да' ? 'Y' : 'N',
                'FAREWELL' => $analysisData['farewell'] == 'да' ? 'Y' : 'N',
            ]);
            if (!$result->isSuccess()) {
                throw new Exception($result->getErrorMessages());
            }
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public static function getFirstInQueue()
    {
        try {
            $object = CallQueuesTable::getList([
                'select' => ['*'],
                'order' => ['ID' => 'ASC'],
                'limit' => 1
            ])->fetch();

            if ($object['IN_WORK'] == 'Y') {
                throw new \Exception('Очередь занята');
            } else {
                $result = CallQueuesTable::update($object['ID'], [
                    'IN_WORK' => 'Y',
                ]);
                if (!$result->isSuccess()) {
                    throw new Exception($result->getErrorMessages());
                }
                return $object;
            }
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

	public static function getRecord($recordLink, $callId)
    {
        $maxAttempts = 2;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                $audioContent = file_get_contents($recordLink);

                if ($audioContent !== false) {
                    $filename = 'call_record_' . time() . '.mp3';
                    $filePath = $_SERVER['DOCUMENT_ROOT'] . '/local/modules/analysis.call/record/' . $filename;
                    file_put_contents($filePath, $audioContent);
                    return $filePath;
                }

                if ($attempt == $maxAttempts) {
					//self::deleteQueue($callId);
                    return ['error' => 'Не удалось скачать запись после ' . $maxAttempts . ' попыток: ' . $recordLink];
                }

            } catch (\Exception $e) {
                if ($attempt == $maxAttempts) {
                    return ['error' => $e->getMessage()];
                }
            }

            if ($attempt < $maxAttempts) {
                sleep(600);
            }
        }

        return ['error' => 'Не удалось скачать запись'];
    }
}