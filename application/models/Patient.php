<?php

class Application_Model_Patient
{
    protected $id;
    protected $name;
    protected $gender;
    protected $dayOfBirth;
    protected $healthInsurance;

    public function __construct(array $options = null)
    {
        if (!empty($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . ucfirst($name);

        if (!method_exists($this, $method)) {
            throw new Exception('Invalid property');
        }

        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . ucfirst($name);

        if (!method_exists($this, $method)) {
            throw new Exception('Invalid property');
        }

        return $this->$method();
    }

    public function setOptions(array $options): Application_Model_Patient
    {
        $methods = get_class_methods($this);

        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    public function getTranslatedGender(): ?string
    {
        $gender = $this->getGender();

        if (!$gender) {
            return null;
        }

        switch ($gender) {
            case 'male':
                return 'masculino';
            case 'female':
                return 'feminino';
            default:
                return null;
        }
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDayOfBirth()
    {
        return $this->dayOfBirth;
    }

    /**
     * @param mixed $dayOfBirth
     */
    public function setDayOfBirth($dayOfBirth)
    {
        $parsedDayOfBirth = DateTime::createFromFormat('d/m/Y', $dayOfBirth);

        if (!$parsedDayOfBirth) {
            $parsedDayOfBirth = DateTime::createFromFormat('Y-m-d', $dayOfBirth);
        }

        $this->dayOfBirth = $parsedDayOfBirth;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHealthInsurance()
    {
        return $this->healthInsurance;
    }

    /**
     * @param mixed $healthInsurance
     */
    public function setHealthInsurance($healthInsurance)
    {
        $this->healthInsurance = $healthInsurance;

        return $this;
    }

    public function toArray(): array
    {
        $dayOfBirth = is_null($this->getDayOfBirth()) ? null : $this->getDayOfBirth()->format('d/m/Y');

        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'gender' => $this->getGender(),
            'dayOfBirth' => $dayOfBirth,
            'healthInsurance' => $this->getHealthInsurance(),
        ];
    }

}

