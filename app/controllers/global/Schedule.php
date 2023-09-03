<?php

namespace app\controllers\global;

use app\classes\Validate;
use app\controllers\Controller;
use DateTime;

class Schedule extends Controller {

    public function index() {

        $date = urldecode(filter_input(INPUT_GET, 'date'));

        $partsOfDate = explode("/", str_replace('\\', '', $date));

        $formattedDate = str_replace(" ", "", "{$partsOfDate[2]}-{$partsOfDate[1]}-{$partsOfDate[0]}");

        $formattedDate = (new DateTime($formattedDate))->format("Y-m-d");
        
        $schedulesOfDate = $this->select->findBy('available_schedules', "schedule", "day", $formattedDate);

        echo json_encode($schedulesOfDate);
        die;
    }

    public function store() {

        $fields = [
            "name" => "s",
            "service" => "s",
            "date" => "d",
            "available_schedules" => "t",
        ];

        $validated = Validate::validate($fields);

        if(!$validated['isValidated']) {
            echo json_encode($validated['values']);
            die;
        }

        $validatedValues = $validated['values'];

        if(!in_array($validatedValues['service'], ["hair", "beard"])) {
            echo json_encode(["service" => "Unavailable service"]);
            die;
        }
 
        $partsFromDate = explode("/", $validatedValues['date'], 3);

        $formattedDate = "{$partsFromDate[2]}-{$partsFromDate[1]}-{$partsFromDate[0]}";

        $isExistDate = $this->select->findBy("available_schedules", "day,schedule", "day", $formattedDate);

        if(!$isExistDate) {
            echo json_encode(["date" => "Unavailable date"]);
            die;
        }

        $isExistSchedule = $this->select->findBy("available_schedules", "day,schedule", "schedule", $validatedValues['available_schedules']);

        if(!$isExistSchedule) {
            echo json_encode(["available_schedules" => "Unavailable schedule"]);
            die;
        }

        $formattedValuesForSave = [
            "name" => $validatedValues['name'],
            "service" => $validatedValues['service'],
            "day" => $formattedDate,
            "schedule" => $validatedValues['available_schedules'],
        ];

        $save = $this->insert->insert("appointments_scheduled", $formattedValuesForSave);

        if($save) {  
            $this->delete->delete("available_schedules", "schedule", $formattedValuesForSave['schedule']);
            echo json_encode("success");
            die;
        }
    } 
}