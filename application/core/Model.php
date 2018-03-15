<?php
/**
 * Created by PhpStorm.
 * User: littleprince
 * Date: 03.03.18
 * Time: 15:30
 */

namespace Core;

/**
 * Class Model
 * @package Core
 */
abstract class Model
{
    /**
     * @var mysqli
     */
    protected $db;

    /**
     * @var UserValidator
     */
    protected $validator;

    /**
     * Model constructor.
     * @param ValidatorInterface|null $validator
     */
    function __construct(ValidatorInterface $validator = null)
    {
        $this->db = SqliteDatabaseConnection::getInstance()->db;
        $this->validator = $validator;
        
        if (!$this->validator) {
            $this->validator = new UserValidator();    
        }
    }

    /**
     * @return bool
     */
    abstract public function create();

    /**
     * @param array $data
     * @return bool
     */
    abstract public function edit() : bool;

    /**
     * @param array $result
     * @return mixed
     */
    abstract protected function mapResult(array $result);

    /**
     * @return bool
     */
    abstract public function isValid() : bool;

    /**
     * @param string $propertyName
     * @param string $propertyValue
     * @return bool
     */
    public function loadProperty(string $propertyName, string $propertyValue) : bool
    {
        if (
            $propertyValue != ""
        ) {
            $this->$propertyName = $propertyValue;

            return true;
        }

        return false;
    }
}