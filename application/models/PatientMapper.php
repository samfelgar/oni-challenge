<?php

class Application_Model_PatientMapper
{
    protected $dbTable;

    protected function setDbTable($dbTable): Application_Model_PatientMapper
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }

        if (!($dbTable instanceof Zend_Db_Table_Abstract)) {
            throw new Exception('Invalid table data gateway provided');
        }

        $this->dbTable = $dbTable;

        return $this;
    }

    public function getDbTable(): Application_Model_DbTable_Patient
    {
        if (null === $this->dbTable) {
            $this->setDbTable(Application_Model_DbTable_Patient::class);
        }

        return $this->dbTable;
    }

    public function save(Application_Model_Patient $patient)
    {
        $data = [
            'name' => $patient->getName(),
            'gender' => $patient->getGender(),
            'day_of_birth' => $patient->getDayOfBirth()->format('Y-m-d'),
            'health_insurance' => $patient->getHealthInsurance(),
        ];

        if (!$patient->getId()) {
            $this->getDbTable()->insert($data);
            return;
        }

        $this->getDbTable()->update($data, [
            'id = ?' => $patient->getId()
        ]);
    }

    public function find($id)
    {
        $result = $this->getDbTable()->find($id);

        if (0 == count($result)) {
            return null;
        }

        $row = $result->current();

        $patient = new Application_Model_Patient();

        $patient->setId($row->id)
            ->setName($row->name)
            ->setGender($row->gender)
            ->setDayOfBirth($row->day_of_birth)
            ->setHealthInsurance($row->health_insurance);

        return $patient;
    }

    public function fetchAll(): array
    {
        $resultSet = $this->getDbTable()->fetchAll();

        $entries = [];

        foreach ($resultSet as $row) {
            $entry = new Application_Model_Patient();

            $entry->setId($row->id)
                ->setName($row->name)
                ->setGender($row->gender)
                ->setDayOfBirth($row->day_of_birth)
                ->setHealthInsurance($row->health_insurance);

            $entries[] = $entry;
        }

        return $entries;
    }

    public function delete(Application_Model_Patient $patient): bool
    {
        $affectedRows = $this->getDbTable()->delete(['id = ?' => $patient->getId()]);

        return $affectedRows > 0;
    }
}

