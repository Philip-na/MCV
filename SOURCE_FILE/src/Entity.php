<?php

use PhpParser\Node\Expr\Cast\Object_;

// abstract class Entity {
//     protected $tableName;
//     protected $fields;
//     protected $dbc;
//     protected $primaryKeys = ['id'];

//     protected function __construct($dbc, $tableName){
//         $this->dbc = $dbc;
//         $this->tableName = $tableName;
//         $this->tableFields();
//     }
//     abstract protected function tableFields();

//     // get a single record
//     public function findBy($fieldName, $fieldValue){

//         $results = $this->find($fieldName, $fieldValue);
//         if($results && $results[0]){
//             $this->setValues($results[0]);
//         }
//     }
    
//     // geting all from the dats from the data bace
//     public function findAll(){
//         $results = [];
//         $databaseData = $this->find();
//         if($databaseData){
//             $className = static::class;
//             foreach($databaseData as $objectData){
//                 $object = new $className($this->dbc);      
//                 $object = $this->setValues($objectData, $object);
               
//                 $results[] = $object;
                
//             }

//         }
//         return $results;
//     }
    
//     // set objext values
//     public function setValues( $value, $object = null){

//         if($object === null){
//             $object = $this;
//         }
        
//         foreach($object->primaryKeys as $keyName){
//             if(isset($value[$keyName])){
//                 $object->$keyName = $value[$keyName];
//             }
//         }
//         foreach ($this->fields as $fieldName){
//             if(isset($value[$fieldName])){
//                 $object->$fieldName = $value[$fieldName] ?? '';
//             }
            
//         }
//         return $object;
//     }
      
    
//     private function find($fieldName = '', $fieldValue = ''){
        
//         $preparedFeilds = [];
//         $sql = "SELECT * FROM " . $this->tableName;

//         if($fieldName){
//             $sql .= " WHERE " . $fieldName . " = :value";
//             $preparedFeilds = ['value' => $fieldValue];
//         }
//         $stmt = $this->dbc->prepare($sql);
//         $stmt->execute($preparedFeilds); 
//         $databaseData = $stmt->fetchAll();     
//         return $databaseData;
//     }

//     public function save(){
//         // $sql = "UPDATE pages SET title = :Title, content, =:content WHERE id = :id";
//        $fieldBinding = [];
//        $keyBinding = [];
//        $preparedFeilds = [];
       
//        foreach($this->fields as $fieldName){
//         $fieldBinding[$fieldName] = $fieldName . '= :' . $fieldName;
//         $preparedFeilds[$fieldName] = $this->$fieldName;
//        }
       
//        $fieldBindingString = join(', ', $fieldBinding);

//        foreach($this->primaryKeys as $keyname){
//         $keyBinding[$keyname] = $keyname . '= :' . $keyname;
//         $preparedFeilds[$keyname] = $this->$keyname;
//        }
//        $keyBindingString = join(',' , $keyBinding);

      
       
//         $sql = "UPDATE " . $this->tableName. " SET " . $fieldBindingString . " WHERE " . $keyBindingString;
//         // var_dump ($sql);
//         // var_dump($preparedFeilds);
//         $stmt = $this->dbc->prepare($sql);
//         $stmt->execute($preparedFeilds);
//     }
// }
 

abstract class Entity {
    protected $tableName;
    protected $fields;
    protected $dbc;
    protected $primaryKeys = ['id'];

    protected function __construct($dbc, $tableName) {
        $this->dbc = $dbc;
        $this->tableName = $tableName;
        $this->tableFields();
    }

    abstract protected function tableFields();

    public function findBy($fieldName, $fieldValue) {
        $results = $this->find($fieldName, $fieldValue);
        if ($results && $results[0]) {
            $this->setValues($results[0]);
        }
    }

    public function findAll() {
        $results = [];
        $databaseData = $this->find();
        if ($databaseData) {
            $className = static::class;
            foreach ($databaseData as $objectData) {
                $object = new $className($this->dbc);
                $object = $this->setValues($objectData, $object);
                $results[] = $object;
            }
        }
        return $results;
    }

    public function setValues($value, $object = null) {
        if ($object === null) {
            $object = $this;
        }
        foreach ($object->primaryKeys as $keyName) {
            if (isset($value[$keyName])) {
                $object->$keyName = $value[$keyName];
            }
        }
        foreach ($this->fields as $fieldName) {
            if (isset($value[$fieldName])) {
                $object->$fieldName = $value[$fieldName] ?? '';
            }
        }
        return $object;
    }

    private function find($fieldName = '', $fieldValue = '') {
        $preparedFields = [];
        $sql = "SELECT * FROM " . $this->tableName;

        if ($fieldName) {
            $sql .= " WHERE " . $fieldName . " = :value";
            $preparedFields = ['value' => $fieldValue];
        }
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute($preparedFields);
        $databaseData = $stmt->fetchAll();
        return $databaseData;
    }

    public function save() {
        if ($this->isExistingRecord()) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    private function isExistingRecord() {
        foreach ($this->primaryKeys as $keyname) {
            if (empty($this->$keyname)) {
                return false;
            }
        }
        return true;
    }

    private function update() {
        $fieldBindings = [];
        $preparedFields = [];
        foreach ($this->fields as $fieldName) {
            $fieldBindings[] = "{$fieldName} = :{$fieldName}";
            $preparedFields[$fieldName] = $this->$fieldName;
        }
        $fieldBindingString = implode(', ', $fieldBindings);

        $keyBindings = [];
        foreach ($this->primaryKeys as $keyname) {
            $keyBindings[] = "{$keyname} = :{$keyname}";
            $preparedFields[$keyname] = $this->$keyname;
        }
        $keyBindingString = implode(' AND ', $keyBindings);

        $sql = "UPDATE " . $this->tableName . " SET " . $fieldBindingString . " WHERE " . $keyBindingString;
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute($preparedFields);
    }

    private function insert() {
        $fieldNames = [];
        $fieldValues = [];
        $preparedFields = [];
        foreach ($this->fields as $fieldName) {
            $fieldNames[] = $fieldName;
            $fieldValues[] = ":{$fieldName}";
            $preparedFields[$fieldName] = $this->$fieldName;
        }
        $fieldNamesString = implode(', ', $fieldNames);
        $fieldValuesString = implode(', ', $fieldValues);

        $sql = "INSERT INTO " . $this->tableName . " (" . $fieldNamesString . ") VALUES (" . $fieldValuesString . ")";
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute($preparedFields);
    }

    public function delete() {
        $keyBindings = [];
        $preparedFields = [];
        foreach ($this->primaryKeys as $keyname) {
            $keyBindings[] = "{$keyname} = :{$keyname}";
            $preparedFields[$keyname] = $this->$keyname;
        }
        $keyBindingString = implode(' AND ', $keyBindings);

        $sql = "DELETE FROM " . $this->tableName . " WHERE " . $keyBindingString;
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute($preparedFields);
    }
}
