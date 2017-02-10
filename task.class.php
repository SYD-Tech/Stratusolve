<?php
/**
 * This class handles the modification of a task object
 */
class Task 
{
    public $TaskId;
    public $TaskName;
    public $TaskDescription;
    protected $TaskDataSource;

    public function __construct($Id = null, $taskName=null, $taskDescription=null) 
    {
       if(!is_null($Id)) {
            $this->TaskId = $Id;
       }

        if(!is_null($taskName)) {
            $this->TaskName = $taskName;
        }
        if(!is_null($taskDescription)) {
            $this->TaskDescription  = $taskDescription;
        }

        $this->TaskDataSource = file_get_contents('Task_Data.txt');

        if (strlen($this->TaskDataSource) > 0) {
            $this->TaskDataSource = json_decode($this->TaskDataSource); // Should decode to an array of Task objects
        } else {
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array
        }

        if (!$this->TaskDataSource) {
            $this->TaskDataSource = array(); // If it does not, then the data source is assumed to be empty and we create an empty array
        }

        if (!$this->LoadFromId($Id)) {
            $this->Create( $taskName, $taskDescription);
        }
    }

    protected function Create($taskName, $taskDescription) 
    {
        // This function needs to generate a new unique ID for the task
        // Assignment: Generate unique id for the new task
        $this->TaskId = $this->getUniqueId();
        $this->TaskName =  $taskName;
        $this->TaskDescription = $taskDescription;

        $new = new stdClass();
        $new->TaskId = $this->TaskId; 
        $new->TaskName = $this->TaskName; 
        $new->TaskDescription = $this->TaskDescription; 

        array_push($this->TaskDataSource, $new);
      
    }

    protected function getUniqueId() 
    {
        // Assignment: Code to get new unique ID
        $taskIds = array_column($this->TaskDataSource, 'TaskId');
        $newId = max($taskIds) + 1;

        return $newId; // Placeholder return for now
    }

    protected function LoadFromId($Id = null) 
    {
        if ($Id) {
            foreach($this->TaskDataSource as $key => $obj) {
                if($Id == $obj->TaskId) {
                    if($this->TaskName) {
                        $obj->TaskName = $this->TaskName;
                    }
                    if($this->TaskDescription) {
                        $obj->TaskDescription = $this->TaskDescription;
                    }
                    return  true;
                }            
            }
        } else {
            return null;
        }
    }

    public function Save() 
    {
        $newJsonString = json_encode($this->TaskDataSource);
        file_put_contents('Task_Data.txt', $newJsonString);
    }

    public function Delete() 
    {
        // var_dump($this->TaskDataSource);
        foreach($this->TaskDataSource as $key => $obj) {
            if($this->TaskId == $obj->TaskId) {
                // var_dump($obj);
                unset($this->TaskDataSource[$key]);
            }            
        }
    } 
}
?>