<?php

namespace Lib\Prisma\Classes;

use Lib\Prisma\Model\IModel;
use Lib\Prisma\Classes\Validator;

class User implements IModel
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $emailVerified;
    public $image;
    public $age;
    public $roleId;
    public $userRole;
    public readonly object $column;

    protected $fields;

    private $pdo;
    private $dbType;
    private $modelName;

    public function __construct($pdo, $data = null)
    {
        $this->pdo = $pdo;
        $this->dbType = $this->pdo->getAttribute(\PDO::ATTR_DRIVER_NAME);

        $this->modelName = 'User';

        $this->fields = array(
            'id' =>
            array(
                'name' => 'id',
                'type' => 'String',
                'isNullable' => '',
                'isPrimaryKey' => '1',
                'decorators' =>
                array (
                    'unique' => true,
                    'id' => true,
                    'default' => 'cuid',
                  )
                ),
            'name' =>
            array(
                'name' => 'name',
                'type' => 'String',
                'isNullable' => '1',
                'isPrimaryKey' => '',
                'decorators' =>
                array (
                  )
                ),
            'email' =>
            array(
                'name' => 'email',
                'type' => 'String',
                'isNullable' => '1',
                'isPrimaryKey' => '',
                'decorators' =>
                array (
                    'unique' => true,
                  )
                ),
            'password' =>
            array(
                'name' => 'password',
                'type' => 'String',
                'isNullable' => '1',
                'isPrimaryKey' => '',
                'decorators' =>
                array (
                  )
                ),
            'emailVerified' =>
            array(
                'name' => 'emailVerified',
                'type' => 'DateTime',
                'isNullable' => '1',
                'isPrimaryKey' => '',
                'decorators' =>
                array (
                  )
                ),
            'image' =>
            array(
                'name' => 'image',
                'type' => 'String',
                'isNullable' => '1',
                'isPrimaryKey' => '',
                'decorators' =>
                array (
                  )
                ),
            'age' =>
            array(
                'name' => 'age',
                'type' => 'Int',
                'isNullable' => '1',
                'isPrimaryKey' => '',
                'decorators' =>
                array (
                  )
                ),
            'roleId' =>
            array(
                'name' => 'roleId',
                'type' => 'Int',
                'isNullable' => '1',
                'isPrimaryKey' => '',
                'decorators' =>
                array (
                  )
                ),
            'userRole' =>
            array(
                'name' => 'userRole',
                'type' => 'UserRole',
                'isNullable' => '1',
                'isPrimaryKey' => '',
                'decorators' =>
                array (
                    'relation' => 
                    array (
                      'name' => 'userRole',
                      'model' => 'UserRole',
                      'relationModelName' => 'UserRole',
                      'fields' => 
                      array (
                        0 => 'roleId',
                      ),
                      'references' => 
                      array (
                        0 => 'id',
                      ),
                      'onDelete' => 'SetNull',
                      'onUpdate' => 'Cascade',
                      'type' => 'OneToOne',
                      'tableName' => 'Users',
                      'tableModelName' => 'User',
                      'tablePrimaryKey' => 'id',
                    ),
                  )
                ),
            );

        $this->column = new class()
        {
            public function __construct(
                public readonly string $id = 'id',
                public readonly string $name = 'name',
                public readonly string $email = 'email',
                public readonly string $password = 'password',
                public readonly string $emailVerified = 'emailVerified',
                public readonly string $image = 'image',
                public readonly string $age = 'age',
                public readonly string $roleId = 'roleId',
                public readonly string $userRole = 'userRole',
            ) {
            }
        };

        if ($data) {
            $this->id = $data['id'] ?? null;
            $this->name = $data['name'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->password = $data['password'] ?? null;
            $this->emailVerified = $data['emailVerified'] ?? null;
            $this->image = $data['image'] ?? null;
            $this->age = $data['age'] ?? null;
            $this->roleId = $data['roleId'] ?? null;
            $this->userRole = new UserRole($this->pdo, $data['userRole'] ?? null);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $validatedValue = Validator::validateString($value);
        $this->id = $validatedValue;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($value)
    {
        $validatedValue = Validator::validateString($value);
        $this->name = $validatedValue;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($value)
    {
        $validatedValue = Validator::validateString($value);
        $this->email = $validatedValue;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($value)
    {
        $validatedValue = Validator::validateString($value);
        $this->password = $validatedValue;
    }

    public function getEmailVerified()
    {
        return $this->emailVerified;
    }

    public function setEmailVerified($value)
    {
        $validatedValue = Validator::validateDateTime($value);
        $this->emailVerified = $validatedValue;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($value)
    {
        $validatedValue = Validator::validateString($value);
        $this->image = $validatedValue;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($value)
    {
        $validatedValue = Validator::validateInt($value);
        $this->age = $validatedValue;
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

    public function setRoleId($value)
    {
        $validatedValue = Validator::validateInt($value);
        $this->roleId = $validatedValue;
    }

    protected function includeUserRole(array $items, array $selectedFields = [], array $includeSelectedFields = []) 
    {
        if (empty($items)) {
            return $items;
        }

        $singleItem = false;
        $itemsArrayType = Utility::checkArrayContents($items);
        if ($itemsArrayType === ArrayType::Value) {
            $items = [$items];
            $singleItem = true;
        }

        $dbType = $this->dbType;
        $quotedTableName = $dbType == 'pgsql' ? "\"UserRole\"" : "`UserRole`";
        $tableName = $dbType == 'pgsql' ? "\"Users\"" : "`Users`";
        $tableModelName = 'User';
        $tablePrimaryKey = 'id';
        $tablePrimaryKeyQuoted = $dbType == 'pgsql' ? "\"id\"" : "`id`";
        $modelName = 'UserRole';
        $relationName = 'userRole';
        $foreignKeyIds = array_column($items, 'roleId');
        $primaryKey = 'id';
        $foreignKey = 'roleId';
        $primaryKeyQuoted = $dbType == 'pgsql' ? "\"id\"" : "`id`";
        $foreignKeyQuoted = $dbType == 'pgsql' ? "\"roleId\"" : "`roleId`";
        $foreignKeyIds = array_filter($foreignKeyIds); // Filter out any empty values
        $foreignKeyIds = array_unique($foreignKeyIds);
        $wasEmpty = false;

        if (empty($foreignKeyIds)) {
            $itemsIds = array_column($items, $tablePrimaryKey);
            $placeholders = implode(', ', array_fill(0, count($itemsIds), '?'));
            $relatedModelSql = "SELECT $foreignKeyQuoted FROM $tableName WHERE $tablePrimaryKeyQuoted IN ($placeholders)";
            $stmt = $this->pdo->prepare($relatedModelSql);
            $stmt->execute(array_values($itemsIds));
            $relatedModelResult = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $foreignKeyIds = array_column($relatedModelResult, $foreignKey);
            $foreignKeyIds = array_filter($foreignKeyIds);
            $foreignKeyIds = array_unique($foreignKeyIds);

            $rowCount = 0;
            foreach ($relatedModelResult as $result) {
                $items[$rowCount++][$foreignKey] = $result[$foreignKey];
            }

            $wasEmpty = true;
        }

        if (!empty($foreignKeyIds)) {
            $tableModelName = new UserRole($this->pdo);
            foreach ($items as &$item) {
                if (!isset($item[$foreignKey])) {
                    $item[$relationName] = [];
                    continue;
                }
                $relatedRecords = $tableModelName->findUnique(['where' => [$primaryKey => $item[$foreignKey]], 'select' => $includeSelectedFields]);
                $item[$relationName] = $relatedRecords;

                if ($wasEmpty && isset($item[$foreignKey])) {
                    unset($item[$foreignKey]);
                }
            }
        } else {
            foreach ($items as &$item) {
                $item[$relationName] = null;
            }
        }

        return $singleItem ? reset($items) : $items;
    }

    protected function connectUserRole(string $relationName, array|bool $connectData, string $lastInsertId, string $connectType = 'connect')
    {
        $dbType = $this->dbType;
        $quotedTableName = $dbType == 'pgsql' ? "\"UserRole\"" : "`UserRole`";
        $tableName = $dbType == 'pgsql' ? "\"Users\"" : "`Users`";
        $modelName = 'UserRole';
        $tablePrimaryKey = 'id';
        $tableForeignKey = 'roleId';
        $relationType = 'OneToOne';
        $typeOfTableRelation = 'relation';
        $tablePrimaryKeyQuoted = $dbType == 'pgsql' ? "\"id\"" : "`id`";
        $relatedPrimaryKey = 'id';
        $primaryKeyQuoted = $dbType == 'pgsql' ? "\"id\"" : "`id`";
        $foreignKeyQuoted = $dbType == 'pgsql' ? "\"roleId\"" : "`roleId`";

        if (!is_array($connectData) && $connectType !== 'disconnect') {
            throw new \Exception("Error connecting $modelName: connectData must be an array");
        }

        if ($connectType === 'connectOrCreate' && (!array_key_exists('where', $connectData) || !array_key_exists('create', $connectData))) {
            throw new \Exception("Error connecting $modelName: connectOrCreate requires both where and create keys");
        }

        if ($typeOfTableRelation === 'relation' && $relationType === 'OneToMany' && $connectType === 'createMany') {
            throw new \Exception("Error connecting $modelName: relation does not support 'createMany' use 'create' instead");
        }

        if (is_bool($connectData) && $connectType === 'disconnect') {
            try {
                $this->update(['where' => [$tablePrimaryKey => $lastInsertId], 'data' => [$tableForeignKey => null]]);
                return;
            } catch (\Exception $e) {
                throw new \Exception("Error disconnecting $modelName: " . $e->getMessage());
            }
        }

        $relationModel = new UserRole($this->pdo);
        $where = $connectData['where'] ?? $connectData;

        if ($connectType === 'create') {
            $createdData = $relationModel->create(['data' => $connectData]);
            $where = [$relatedPrimaryKey => $createdData[$relatedPrimaryKey]];
            $connectType = 'connect';
        }

        if ($connectType === 'update') {
            if ($typeOfTableRelation === 'relation' && $relationType === 'OneToOne' && count($connectData) > 1) {
                throw new \Exception("Error connecting $modelName: OneToOne relation can only update one field");
            }

            try {
                $findUniqueRelatedModel = $this->findUnique(['where' => [$tablePrimaryKey => $lastInsertId]]);
                $relationModel->update(['where' => [$relatedPrimaryKey => $findUniqueRelatedModel[$tableForeignKey]], 'data' => $connectData]);
                return;
            } catch (\Exception $e) {
                throw new \Exception("Error connecting $modelName: " . $e->getMessage());
            }
        }

        $foundUnique = $relationModel->findUnique(['where' => $where]);

        if (empty($foundUnique) && $connectType === 'connect') {
            throw new \Exception("Error connecting $modelName: No record found for connectData");
        }

        if ($connectType === 'connectOrCreate') {
            if (empty($foundUnique)) {
                $foundUnique = $relationModel->create(['data' => $connectData['create']]);
            }
            $connectType = 'connect';
        }

        if (!empty($foundUnique) && $connectType === 'connect') {
            try {

                $this->update(['where' => [$tablePrimaryKey => $lastInsertId], 'data' => [$tableForeignKey => $foundUnique[$relatedPrimaryKey]]]);
            } catch (\Exception $e) {
                throw new \Exception("Error connecting userRole: " . $e->getMessage());
            }
        }

        if (!empty($foundUnique) && $connectType === 'disconnect') {
            try {

                $this->update(['where' => [$tablePrimaryKey => $lastInsertId], 'data' => [$tableForeignKey => null]]);
            } catch (\Exception $e) {
                throw new \Exception("Error disconnecting userRole: " . $e->getMessage());
            }
        }
    }

    
    /**
     * Creates a new User in the database.
     *
     * This method is designed to insert a new User record into the database using provided data.
     * It is capable of handling related records through the relations defined in the User model,
     * such as 'userRole', 'product', 'post', and 'Profile'. The method allows for selective
     * field return and including related models in the response, enhancing flexibility and control
     * over the output.
     *
     * Parameters:
     * - `array $data`: An associative array that contains the data for the new User record.
     *   The array may also include 'select' and 'include' keys for selective field retrieval
     *   and including related models in the result, respectively. The 'data' key within this array
     *   is required and contains the actual data for the User record.
     * - `string $format = 'array'`: Optional. Specifies the format of the returned User record.
     *   Can be 'array' or 'object'. Default is 'array'.
     *
     * Returns:
     * - `mixed`: The created User record, formatted as an associative array or object based on
     *   the 'format' parameter. If relations are specified, they are also processed and
     *   connected or created as per the provided instructions.
     *
     * Throws:
     * - `Exception` if the 'data' key is not provided or is not an associative array.
     * - `Exception` if both 'include' and 'select' keys are used simultaneously.
     * - `Exception` for any error encountered during the creation process.
     *
     * Example:
     * ```
     * // Example of creating a new User with related profile and roles
     * $newUser = $prisma->user->create([
     *   'data' => [
     *     'name' => 'John Doe',
     *     'email' => 'john.doe@example.com',
     *     'profile' => [
     *       'create' => [
     *         'bio' => 'Software Developer',
     *       ]
     *     ],
     *     'roles' => [
     *       'connectOrCreate' => [
     *         'where' => ['name' => 'Admin'],
     *         'create' => ['name' => 'Admin'],
     *       ],
     *     ],
     *   ],
     *   'include' => ['profile' => true, 'roles' => true],
     * ]);
     * ```
     *
     * Notes:
     * - The method checks for required fields in the 'data' array and validates their types,
     *   ensuring data integrity before attempting to create the record.
     * - It supports complex operations such as connecting or creating related records based on
     *   predefined relations, offering a powerful way to manage related data efficiently.
     * - Transaction management is utilized to ensure that all database operations are executed
     *   atomically, rolling back changes in case of any error, thus maintaining data consistency.
     */
    public function create(array $data, string $format = 'array'): array | object 
    {
        if (!isset($data['data'])) {
            throw new \Exception("The 'data' key is required when creating a new User.");
        }

        if (!is_array($data['data'])) {
            throw new \Exception("'data'must be an associative array.");
        }

        if (isset($data['include']) && isset($data['select'])) {
            throw new \Exception("You can't use both 'include' and 'select' at the same time.");
        }

        $acceptedCriteria = ['data', 'select', 'include'];
        Utility::checkForInvalidKeys($data, $acceptedCriteria, $this->modelName);        
        $select = $data['select'] ?? [];
        $include = $data['include'] ?? [];
        $data = $data['data'];
        $relationNames = ['userRole'];

        $primaryKeyField = '';
        $insertFields = [];
        $placeholders = [];
        $bindings = [];
        $dbType = $this->dbType;
        $quotedTableName = $dbType == 'pgsql' ? "\"Users\"" : "`Users`";

        Utility::checkFieldsExist(array_merge($select, $include), $this->fields, $this->modelName);

        try {
            $this->pdo->beginTransaction();
            foreach ($this->fields as $field) {
                $fieldName = $field['name'];
                $fieldType = $field['type'];
                $isNullable = $field['isNullable'];
                $relation = $field['decorators']['relation'] ?? null;
                $inverseRelation = $field['decorators']['inverseRelation'] ?? null;

                if (!empty($field['decorators']['id'])) {
                    $primaryKeyField = $fieldName;
                }

                if (isset($field['decorators']['default']) && isset($field['decorators']['id'])) {
                    if (empty($data[$fieldName])) {
                        if ($field['decorators']['default'] === 'uuid') {
                            $bindings[$fieldName] = \Ramsey\Uuid\Uuid::uuid4()->toString();
                        } elseif ($field['decorators']['default'] === 'cuid') {
                            $bindings[$fieldName] = (new \Hidehalo\Nanoid\Client())->generateId(21);
                        }
                    } else {
                        $validateMethodName = "validate" . ucfirst($fieldType);
                        $bindings[$fieldName] = Validator::$validateMethodName($data[$fieldName]);
                    }
                } elseif (isset($data[$fieldName]) || !$isNullable) {
                    if (!array_key_exists($fieldName, $data)) continue;
                    if (isset($relation) || isset($inverseRelation)) continue;
                    $validateMethodName = "validate" . ucfirst($fieldType);
                    $bindings[$fieldName] = Validator::$validateMethodName($data[$fieldName]);
                } elseif (isset($data[$fieldName]) && $isNullable) {
                    if (!array_key_exists($fieldName, $data)) continue;
                    if (isset($relation) || isset($inverseRelation)) continue;
                    $insertFields[] = $fieldName;
                    $placeholders[] = "NULL";
                }

                if (array_key_exists($fieldName, $bindings)) {
                    if (isset($relation) || isset($inverseRelation)) continue;
                    $insertFields[] = $fieldName;
                    $placeholders[] = ":$fieldName";
                }
            }

            $fieldStr = implode(', ', $insertFields);
            $placeholderStr = implode(', ', $placeholders);

            $sql = $dbType == 'pgsql' ? "INSERT INTO $quotedTableName ($fieldStr) VALUES ($placeholderStr) RETURNING id" : "INSERT INTO $quotedTableName ($fieldStr) VALUES ($placeholderStr)";
            $stmt = $this->pdo->prepare($sql);

            foreach ($bindings as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            $lastInsertId = $dbType == 'pgsql' ? $stmt->fetch(\PDO::FETCH_ASSOC)[$primaryKeyField] : $this->pdo->lastInsertId();

            if (!$lastInsertId && array_key_exists($primaryKeyField, $bindings)) {
                $lastInsertId = $bindings[$primaryKeyField];
            }

            if (!empty($relationNames)) {
                foreach ($data as $relationName => $relationDataName) {

                    if (in_array($relationName, $relationNames)) {

                        $connectionTypes = ['create', 'createMany', 'connect', 'connectOrCreate'];
                        $connectType = '';

                        foreach ($connectionTypes as $type) {
                            if (isset($relationDataName[$type])) {
                                $connectType = $type;
                                break;
                            }
                        }

                        if (isset($relationDataName['create']) && isset($relationDataName['connectOrCreate'])) {
                            throw new \Exception("You can't use both 'create' and 'connectOrCreate' at the same time.");
                        }

                        if (isset($relationDataName['create']) && is_array($relationDataName['create'])) {
                            $relationData = $relationDataName['create'];
                            $checkArrayContentType = Utility::checkArrayContents($relationData);

                            if ($checkArrayContentType !== ArrayType::Value) {
                                throw new \Exception("To create a new record, the value of 'create' must be a single array with names as keys and the data to create as values in {$relationName} model. example: ['create' => ['name' => 'someName']]");
                            }

                            $connectMethodName = "connect" . ucfirst($relationName);
                            if (method_exists($this, $connectMethodName)) {
                                $this->$connectMethodName($relationName, $relationDataName[$connectType] ?? [], $lastInsertId, $connectType);
                            }
                        } elseif (isset($relationDataName['createMany']) && is_array($relationDataName['createMany'])) {

                            $relationData = $relationDataName['createMany'];
                            $checkArrayContentType = Utility::checkArrayContents($relationData);

                            if ($checkArrayContentType !== ArrayType::Associative) {
                                throw new \Exception("To create many records, use an associative array with the field names as keys and the data to create as values in {$relationName} model. ['createMany' => [['name' => 'someName'], ['name' => 'someOtherName']]");
                            }

                            $connectMethodName = "connect" . ucfirst($relationName);
                            if (method_exists($this, $connectMethodName)) {
                                $this->$connectMethodName($relationName, $relationDataName[$connectType] ?? [], $lastInsertId, $connectType);
                            }
                        }

                        if (isset($relationDataName['connect']) && isset($relationDataName['connectOrCreate'])) {
                            throw new \Exception("You can't use both 'connect' and 'connectOrCreate' at the same time.");
                        }
    
                        if (isset($relationDataName['connect']) && isset($relationDataName['disconnect'])) {
                            throw new \Exception("You can't use both 'connect' and 'disconnect' at the same time.");
                        }

                        if (isset($relationDataName['connect']) || isset($relationDataName['connectOrCreate'])) {
    
                            if (isset($relationDataName['connect'])) {
                                $connectData = $relationDataName['connect'];
                                $checkArrayContentType = Utility::checkArrayContents($connectData);
    
                                if (isset($relationDataName['connect']) && $checkArrayContentType !== ArrayType::Value) {
                                    throw new \Exception("The 'connect' key must be an associative array with the field names as keys and the data to create as values related '$relationName' model. example: ['connect' => ['id' => 'someId']]");
                                }
                            }
    
                            if (isset($relationDataName['connectOrCreate'])) {
                                $connectOrCreateData = $relationDataName['connectOrCreate'];
                                $checkArrayContentType = Utility::checkArrayContents($connectOrCreateData);
    
                                if (isset($relationDataName['connectOrCreate']) && $checkArrayContentType !== ArrayType::Associative) {
                                    throw new \Exception("The 'connectOrCreate' key must be an associative array with the field names as keys and the data to create as values related '$relationName' model. example: ['connectOrCreate' => ['where' => ['id' => 'someId'], 'create' => ['name' => 'someName']]");
                                }
                            }
    
                            if (isset($relationDataName['disconnect'])) {
                                throw new \Exception("The 'disconnect' key is not allowed in the create method.");
                            }

                            $connectMethodName = "connect" . ucfirst($relationName);
                            if (method_exists($this, $connectMethodName)) {
                                $this->$connectMethodName($relationName, $relationDataName[$connectType] ?? [], $lastInsertId, $connectType);
                            } else {
                                echo "Method $connectMethodName does not exist.";
                            }
                        }
                    } else {
                        if (isset($relationDataName['create']) || isset($relationDataName['createMany']) || isset($relationDataName['connect']) || isset($relationDataName['connectOrCreate'])) {
                            throw new \Exception("The relation name '$relationName' is not defined in the User model.");
                        }
                    }
                }
            }

            $selectOrInclude = '';
            if (!empty($select)) {
                $selectOrInclude = 'select';
            } elseif (!empty($include)) {
                $selectOrInclude = 'include';
            }
            $selectedFields = array_merge($select, $include);

            $result = $this->findUnique(['where' => [$primaryKeyField => $lastInsertId], $selectOrInclude => $selectedFields], $format);
            $this->pdo->commit();
            return $result;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Bulk Creates User Records with Transactional Integrity
     * 
     * This method enables the bulk creation of user records in the 'Users' table by accepting an
     * associative array with a 'data' key, where each element represents the data for a user to be created.
     * It ensures data integrity by encapsulating the creation process within a database transaction, thus
     * guaranteeing that either all user records are successfully created, or none are created in the event of an error.
     * 
     * Features:
     * - Bulk creation of multiple user records in a single operation.
     * - Transactional integrity to ensure all or none of the records are created.
     * - Validation of required data fields before proceeding with the creation.
     * - Optional skipping of duplicate records based on database capabilities.
     * 
     * Input Requirements:
     * - The input must be an associative array with a 'data' key pointing to an array of associative arrays,
     *   each representing a user's data.
     * - The method validates the presence and format of the input data, throwing an exception if invalid.
     * 
     * Parameters:
     * - array $data: Associative array containing a 'data' key, which maps to an array of user data.
     * - string $format (optional): The format of the returned data. Currently, only 'array' is supported.
     * 
     * Return Value:
     * - On successful creation, returns an array of the created records, each represented as an associative array.
     * 
     * Exceptions:
     * - Throws an \Exception if the 'data' key is missing, the input data is empty, or any database operation fails.
     * 
     * Example Usage:
     * 
     * $prisma = new Prisma();
     * $userData = [
     *     ['name' => 'Alice', 'email' => 'alice@example.com', 'password' => 'securepassword123'],
     *     ['name' => 'Bob', 'email' => 'bob@example.com', 'password' => 'securepassword456']
     * ];
     * $createdUsers = $prisma->UserModel->createMany(['data' => $userData]);
     * 
     * This method is essential for applications requiring efficient and reliable creation of multiple user records,
     * ensuring data integrity and providing flexibility in handling duplicates.
     */
    public function createMany(array $data, string $format = 'array'): array
    {
        if (!isset($data['data'])) {
            throw new \Exception("The 'data' key is required when creating a new User.");
        }

        if (!is_array($data['data'])) {
            throw new \Exception("'data'must be an associative array.");
        }

        $acceptedCriteria = ['data', 'skipDuplicates'];
        Utility::checkForInvalidKeys($data, $acceptedCriteria, $this->modelName);

        $dbType = $this->dbType;
        $quotedTableName = $dbType == 'pgsql' ? "\"Users\"" : "`Users`";
        $skipDuplicates = $data['skipDuplicates'] ?? false;
        $data = $data['data'];
        $allPlaceholders = [];
        $allBindings = [];
        $insertFields = [];
        $index = 0;

        foreach ($data as &$item) {
            $placeholders = [];
            foreach ($this->fields as $field) {
                $fieldName = $field['name'];
                $fieldType = $field['type'];
                $isNullable = $field['isNullable'];
                $relation = $field['decorators']['relation'] ?? null;
                $inverseRelation = $field['decorators']['inverseRelation'] ?? null;
    
                if (!empty($field['decorators']['id'])) {
                    if (empty($item[$fieldName])) {
                        if ($field['decorators']['default'] === 'uuid') {
                            $item[$fieldName] = \Ramsey\Uuid\Uuid::uuid4()->toString();
                        } elseif ($field['decorators']['default'] === 'cuid') {
                            $item[$fieldName] = (new \Hidehalo\Nanoid\Client())->generateId(21);
                        }
                    } else {
                        $validateMethodName = "validate" . ucfirst($fieldType);
                        $item[$fieldName] = Validator::$validateMethodName($data[$fieldName]);
                    }
                } else if (isset($item[$fieldName]) || !$isNullable) {
                    if (!array_key_exists($fieldName, $item)) continue;
                    if (isset($relation) || isset($inverseRelation)) continue;
                    $validateMethodName = "validate" . ucfirst($fieldType);
                    $item[$fieldName] = Validator::$validateMethodName($item[$fieldName]);
                } else if (isset($item[$fieldName]) && $isNullable) {
                    if (!array_key_exists($fieldName, $item)) continue;
                    if (isset($relation) || isset($inverseRelation)) continue;
                    $placeholders[] = "NULL";
                }
    
                if (array_key_exists($fieldName, $item)) {
                    if (isset($relation) || isset($inverseRelation)) continue;
                    $placeholders[] = ":{$fieldName}_{$index}";
                    $allBindings["{$fieldName}_{$index}"] = $item[$fieldName];

                    if (!in_array($fieldName, $insertFields)) {
                        $insertFields[] = $fieldName;
                    }
                }
            }
    
            $allPlaceholders[] = '(' . implode(', ', $placeholders) . ')';
            $index++;
        }

        $fieldStr = implode(', ', $insertFields);
        $placeholderStr = implode(', ', $allPlaceholders);
        $sqlPrefix = "INSERT INTO $quotedTableName ($fieldStr) VALUES ";
        $sqlSuffix = "";

        if ($skipDuplicates) {
            if ($this->dbType === 'mysql') {
                $sqlPrefix = "INSERT IGNORE INTO $quotedTableName ($fieldStr) VALUES ";
            } elseif ($this->dbType === 'pgsql' || $this->dbType === 'sqlite') {
                $sqlSuffix = " ON CONFLICT DO NOTHING";
            }
        }

        $sql = $sqlPrefix . $placeholderStr . $sqlSuffix;

        try {
            $this->pdo->beginTransaction();
            $stmt = $this->pdo->prepare($sql);

            foreach ($allBindings as $placeholder => $value) {
                $stmt->bindValue(":$placeholder", $value);
            }

            $stmt->execute();
            $affectedRows = $stmt->rowCount();
            $this->pdo->commit();
            return [
                'count' => $affectedRows,
            ];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Retrieves a single User record matching specified criteria.
     * 
     * Searches for a unique User based on the provided filter criteria within `$criteria`.
     * It returns the User data as either an associative array or an object, based on the `$format` parameter.
     * This method supports filtering (`where`), field selection (`select`), and inclusion of related models (`include`).
     * If no matching User is found, an empty array is returned. The method includes comprehensive error handling for invalid inputs and parameter conflicts.
     *
     * @param array $criteria Filter criteria with keys:
     *  - 'where': Conditions to filter User records.
     *  - 'select': Fields of the User to return.
     *  - 'include': Related models to include in the result.
     * @param string $format The format of the returned data ('array' or 'object').
     * @return array|object The User data if found, otherwise an empty array. The return type depends on the `$format`.
     * 
     * @throws Exception If 'where' condition is missing or not an associative array.
     * @throws Exception If both 'include' and 'select' are provided, as they are mutually exclusive.
     * @throws Exception If invalid or conflicting parameters are supplied.
     * 
     * @example
     * // To find a User by ID, select specific fields, and include related models:
     * $user = $prisma->user->findUnique([
     *   'where' => ['id' => 'someUserId'],
     *   'select' => ['name' => true, 'email' => true, 'profile' => true],
     * ], 'array');
     * 
     * @example
     * // To find a User by email and include related models:
     * $user = $prisma->user->findUnique([
     *  'where' => ['email' => 'john@example.com'],
     *  'include' => ['profile' => true, 'posts' => true],
     * ], 'object');
     */
    public function findUnique(array $criteria, string $format = 'array'): array | object
    {
        if (!isset($criteria['where'])) {
            throw new \Exception("No valid 'where' provided for finding a unique record.");
        }

        if (!is_array($criteria['where'])) {
            throw new \Exception("The 'where' key must be an associative array.");
        }

        if (isset($criteria['include']) && isset($criteria['select'])) {
            throw new \Exception("You can't use both 'include' and 'select' at the same time.");
        }

        $acceptedCriteria = ['where', 'select', 'include'];
        Utility::checkForInvalidKeys($criteria, $acceptedCriteria, $this->modelName);

        $where = $criteria['where'];
        $select = $criteria['select'] ?? [];
        $include = $criteria['include'] ?? [];
        $tablePrimaryKey = 'id';
        $primaryEntityFields = [];
        $relatedEntityFields = [];
        $includes = [];

        $dbType = $this->dbType;
        $quotedTableName = $dbType == 'pgsql' ? "\"Users\"" : "`Users`";

        $relationNames = ['userRole'];

        $timestamp = "";
        if (!isset($select[$tablePrimaryKey])) {
            foreach ($relationNames as $relationName) {
                if (isset($select[$relationName])) {
                    $primaryEntityFields[] = $tablePrimaryKey;
                    $timestamp = uniqid();
                    $select[$timestamp] = true;
                    break;
                }
            }
        }

        Utility::checkIncludes($include, $relatedEntityFields, $includes, $this->fields, $this->modelName);
        Utility::checkFieldsExistWithReferences($select, $relatedEntityFields, $primaryEntityFields, $relationNames, $this->fields, $this->modelName, $timestamp);

        $selectFields = '*'; // Default to all fields if none are specified
        if (!empty($primaryEntityFields)) {
            $formattedFields = array_map(function ($field) use ($dbType) {
                return $dbType == 'pgsql' ? "\"$field\"" : "`$field`";
            }, $primaryEntityFields);
            $selectFields = implode(', ', $formattedFields);
        }

        $sql = "SELECT $selectFields FROM $quotedTableName WHERE ";
        $conditions = [];
        $bindings = [];
        
        if (isset($where['id'])) {
            $conditions[] = "id = :id";
            $validatedValue = Validator::validateString($where['id']);
            $bindings[':id'] = $validatedValue;
        }
        if (isset($where['email'])) {
            $conditions[] = "email = :email";
            $validatedValue = Validator::validateString($where['email']);
            $bindings[':email'] = $validatedValue;
        }
        if (empty($conditions)) {
            throw new \Exception("No valid 'where' conditions provided for finding a unique record in User.");
        }

        $sql .= implode(' AND ', $conditions);
        $stmt = $this->pdo->prepare($sql);
        foreach ($bindings as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        $record = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$record) {
            return [];
        }

        // Implicitly include related entities based on `select` where
        foreach ($relatedEntityFields as $relation => $fields) {
            if (!isset($includes[$relation])) {
                $includes[$relation] = true; // Implicitly include this relation
            }
        }

        // Include related models as requested in the 'include' parameter
        foreach ($includes as $relation => $include) {
            if ($include) {
                $relatedField = $relatedEntityFields[$relation] ?? [];
                if ($relatedField && (is_string($relatedField) || is_int($relatedField))) {
                    $selectedFields = [$relatedField => true];
                } else {
                    $selectedFields = $relatedField;
                }

                $includeMethodName = "include" . ucfirst($relation);
                if (method_exists($this, $includeMethodName)) {
                    $record = $this->$includeMethodName($record, $select, $selectedFields);
                } else {
                    throw new \Exception("The '$relation' does not exist, in the User model.");
                }
            }
        }

        if (!isset($select[$tablePrimaryKey]) && isset($select[$timestamp])) {
            unset($record[$tablePrimaryKey]);
        }

        if ($format === 'object') {
            return new User($this->pdo, $record);
        }

        return $record;
    }

    /**
     * Retrieves multiple User records based on specified filter criteria.
     *
     * This method allows for a comprehensive query with support for filtering, ordering, pagination,
     * selective field retrieval, cursor-based pagination, and including related models. It returns an empty array
     * if no Users match the criteria. This approach ensures flexibility and efficiency in fetching data
     * according to diverse requirements.
     *
     * @param array $criteria Query parameters including:
     *  - 'where': Filter criteria for records.
     *  - 'orderBy': Record ordering logic.
     *  - 'take': Number of records to return, useful for pagination.
     *  - 'skip': Number of records to skip, useful for pagination.
     *  - 'cursor': Cursor for pagination, identifying a specific record to start from.
     *  - 'select': Fields to include in the return value.
     *  - 'include': Related models to include in the result.
     *  - 'distinct': Returns only distinct records if set.
     * @param string $format The format of the returned data ('array' or 'object').
     * @return array|object An array of User data in the specified format, or an empty array if no records are found.
     * 
     * @example
     * // Retrieve Users with cursor-based pagination:
     * $users = $prisma->user->findMany([
     *   'cursor' => ['id' => 'someUserId'],
     *   'take' => 5
     * ]);
     * 
     * // Select specific fields of Users:
     * $users = $prisma->user->findMany([
     *   'select' => ['name' => true, 'email' => true],
     *   'take' => 10
     * ]);
     * 
     * // Include related models in the results:
     * $users = $prisma->user->findMany([
     *   'include' => ['posts' => true],
     *   'take' => 5
     * ]);
     * 
     * @throws Exception If 'include' and 'select' are used together, as they are mutually exclusive.
     */
    public function findMany(array $criteria = [], string $format = 'array'): array | object
    {
        if (isset($criteria['where'])) {
            if (!is_array($criteria['where']) || empty($criteria['where']))
                throw new \Exception("No valid 'where' provided for finding multiple records.");
        }

        if (isset($criteria['include']) && isset($criteria['select'])) {
            throw new \Exception("You can't use both 'include' and 'select' at the same time.");
        }

        $acceptedCriteria = ['where', 'orderBy', 'take', 'skip', 'cursor', 'select', 'include', 'distinct'];
        Utility::checkForInvalidKeys($criteria, $acceptedCriteria, $this->modelName);

        $where = $criteria['where'] ?? [];
        $select = $criteria['select'] ?? [];
        $include = $criteria['include'] ?? [];
        $distinct = isset($criteria['distinct']) && $criteria['distinct'] ? 'DISTINCT' : '';
        $tablePrimaryKey = 'id';
        $primaryEntityFields = [];
        $relatedEntityFields = [];
        $includes = [];

        $dbType = $this->dbType;
        $quotedTableName = $dbType == 'pgsql' ? "\"Users\"" : "`Users`";

        $relationNames = ['userRole'];

        $timestamp = "";
        if (!isset($select[$tablePrimaryKey])) {
            foreach ($relationNames as $relationName) {
                if (isset($select[$relationName])) {
                    $primaryEntityFields[] = $tablePrimaryKey;
                    $timestamp = uniqid();
                    $select[$timestamp] = true;
                    break;
                }
            }
        }

        Utility::checkIncludes($include, $relatedEntityFields, $includes, $this->fields, $this->modelName);
        Utility::checkFieldsExistWithReferences($select, $relatedEntityFields, $primaryEntityFields, $relationNames, $this->fields, $this->modelName, $timestamp);

        $selectFields = '*'; // Default to all fields if none are specified
        if (!empty($primaryEntityFields)) {
            $formattedFields = array_map(function ($field) use ($dbType) {
                return $dbType == 'pgsql' ? "\"$field\"" : "`$field`";
            }, $primaryEntityFields);
            $selectFields = implode(', ', $formattedFields);
        }
        $sql = "SELECT $distinct $selectFields FROM $quotedTableName";
        $conditions = [];
        $bindings = [];

        if (isset($criteria['cursor']) && is_array($criteria['cursor'])) {
            foreach ($criteria['cursor'] as $field => $value) {
                $select[$field] = ['>=' => $value];
                $fieldQuoted = $dbType == 'pgsql' ? "\"$field\"" : "`$field`";
                $conditions[] = "$fieldQuoted >= :cursor_$field";
                $bindings[":cursor_$field"] = $value;
            }
            if (!isset($select['skip'])) {
                $select['skip'] = 1;
            }
        }

        Utility::processConditions($where, $conditions, $bindings, $this->dbType);

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        if (isset($criteria['orderBy'])) {
            $sql .= " ORDER BY " . $criteria['orderBy'];
        }
        if (isset($criteria['take'])) {
            $sql .= " LIMIT " . intval($criteria['take']);
        }
        if (isset($criteria['skip'])) {
            $sql .= " OFFSET " . intval($criteria['skip']);
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($bindings as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (!$items) {
            return [];
        }

        foreach ($relatedEntityFields as $relation => $fields) {
            if (!isset($includes[$relation])) {
                $includes[$relation] = true; // Implicitly include this relation
            }
        }

        foreach ($includes as $relation => $include) {
            if ($include) {
                $relatedField = $relatedEntityFields[$relation] ?? [];
                if ($relatedField && (is_string($relatedField) || is_int($relatedField))) {
                    $selectedFields = [$relatedField => true];
                } else {
                    $selectedFields = $relatedField;
                }
                
                $includeMethodName = "include" . ucfirst($relation);
                if (method_exists($this, $includeMethodName)) {
                    $items = $this->$includeMethodName($items, $select, $selectedFields);
                } else {
                    throw new \Exception("The '$relation' does not exist, in the User model.");
                }
            }
        }

        if (!isset($select[$tablePrimaryKey]) && isset($select[$timestamp])) {
            unset($items[$tablePrimaryKey]);
        }

        if ($format === 'object') {
            $result = [];
            foreach ($items as $item) {
                $result[] = new User($this->pdo, $item); // Convert each item into a User object.
            }
            return $result;
        }

        return $items;
    }

    /**
     * Retrieves the first User record that matches specified filter criteria.
     *
     * Designed to efficiently find and return the first User record matching the provided criteria.
     * This method is optimized for scenarios where only the first matching record is needed, reducing
     * overhead compared to fetching multiple records. It supports filtering, ordering, selective field
     * retrieval, and including related models. Returns an empty array if no match is found.
     *
     * Parameters:
     * - @param array $criteria Associative array of query parameters, which may include:
     *   - 'where': Filter criteria for searching User records.
     *   - 'orderBy': Specifies the order of records.
     *   - 'select': Fields to include in the result.
     *   - 'include': Related models to include in the results.
     *   - 'take': Limits the number of records returned, useful for limiting results to a single record or a specific number of records.
     *   - 'skip': Skips a number of records, useful in conjunction with 'take' for pagination.
     *   - 'cursor': Cursor-based pagination, specifying the record to start retrieving records from.
     *   - 'distinct': Ensures the query returns only distinct records based on the specified field(s).
     *
     * The inclusion of 'take', 'skip', 'cursor', and 'distinct' parameters extends the method's flexibility, allowing for more
     * controlled data retrieval strategies, such as pagination or retrieving unique records. It's important to note that while
     * some of these parameters ('take', 'skip', 'cursor') may not be commonly used with a method intended to fetch the first
     * matching record, they offer additional control for advanced query constructions.
     *
     * Returns:
     * - @return mixed Depending on 'format', returns the first matching User record as either an
     *                 associative array or object, or an empty array if no matches are found.
     *
     * Examples:
     * // Find a User by email, returning specific fields:
     * $user = $prisma->user->findFirst([
     *   'where' => ['email' => 'user@example.com'],
     *   'select' => ['id', 'email', 'name']
     * ]);
     * // Find an active User, include their posts, ordered by name:
     * $user = $prisma->user->findFirst([
     *   'where' => ['active' => true],
     *   'orderBy' => 'name',
     *   'include' => ['posts' => true]
     * ]);
     *
     * Exception Handling:
     * - Throws Exception if 'include' and 'select' are used together, as they are mutually exclusive.
     * - Throws Exception if no valid 'where' filter is provided, ensuring purposeful searches.
     *
     * This method simplifies querying for a single record, offering control over the search through
     * filtering, sorting, and defining the scope of the returned data. It's invaluable for efficiently
     * retrieving specific records or subsets of fields.
     */
    public function findFirst(array $criteria = [], string $format = 'array'): array | object
    {
        if (isset($criteria['where'])) {
            if (!is_array($criteria['where']) || empty($criteria['where']))
                throw new \Exception("No valid 'where' provided for finding multiple records.");
        }

        if (isset($criteria['include']) && isset($criteria['select'])) {
            throw new \Exception("You can't use both 'include' and 'select' at the same time.");
        }

        $acceptedCriteria = ['where', 'orderBy', 'take', 'skip', 'cursor', 'select', 'include', 'distinct'];
        Utility::checkForInvalidKeys($criteria, $acceptedCriteria, $this->modelName);

        $where = $criteria['where'] ?? [];
        $select = $criteria['select'] ?? [];
        $include = $criteria['include'] ?? [];
        $distinct = isset($criteria['distinct']) && $criteria['distinct'] ? 'DISTINCT' : '';
        $tablePrimaryKey = 'id';
        $primaryEntityFields = [];
        $relatedEntityFields = [];
        $includes = [];

        $dbType = $this->dbType;
        $quotedTableName = $dbType == 'pgsql' ? "\"Users\"" : "`Users`";

        $relationNames = ['userRole'];

        $timestamp = "";
        if (!isset($select[$tablePrimaryKey])) {
            foreach ($relationNames as $relationName) {
                if (isset($select[$relationName])) {
                    $primaryEntityFields[] = $tablePrimaryKey;
                    $timestamp = uniqid();
                    $select[$timestamp] = true;
                    break;
                }
            }
        }

        Utility::checkIncludes($include, $relatedEntityFields, $includes, $this->fields, $this->modelName);
        Utility::checkFieldsExistWithReferences($select, $relatedEntityFields, $primaryEntityFields, $relationNames, $this->fields, $this->modelName, $timestamp);

        $selectFields = '*';
        if (!empty($primaryEntityFields)) {
            $formattedFields = array_map(function ($field) use ($dbType) {
                return $dbType == 'pgsql' ? "\"$field\"" : "`$field`";
            }, $primaryEntityFields);
            $selectFields = implode(', ', $formattedFields);
        }
        
        $sql = "SELECT $distinct $selectFields FROM $quotedTableName";
        $conditions = [];
        $bindings = [];

        if (isset($criteria['cursor']) && is_array($criteria['cursor'])) {
            foreach ($criteria['cursor'] as $field => $value) {
                $select[$field] = ['>=' => $value];
                $fieldQuoted = $dbType == 'pgsql' ? "\"$field\"" : "`$field`";
                $conditions[] = "$fieldQuoted >= :cursor_$field";
                $bindings[":cursor_$field"] = $value;
            }
            if (!isset($select['skip'])) {
                $select['skip'] = 1;
            }
        }

        Utility::processConditions($where, $conditions, $bindings, $this->dbType);

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        if (isset($criteria['orderBy'])) {
            $sql .= " ORDER BY " . $criteria['orderBy'];
        }
        if (isset($criteria['take'])) {
            $sql .= " LIMIT " . intval($criteria['take']);
        }
        if (isset($criteria['skip'])) {
            $sql .= " OFFSET " . intval($criteria['skip']);
        }
        $sql .= " LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        foreach ($bindings as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $record = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$record) {
            return [];
        }
        
        foreach ($relatedEntityFields as $relation => $fields) {
            if (!isset($includes[$relation])) {
                $includes[$relation] = true; // Implicitly include this relation
            }
        }

        foreach ($includes as $relation => $include) {
            if ($include) {
                $relatedField = $relatedEntityFields[$relation] ?? [];
                if ($relatedField && (is_string($relatedField) || is_int($relatedField))) {
                    $selectedFields = [$relatedField => true];
                } else {
                    $selectedFields = $relatedField;
                }
                
                $includeMethodName = "include" . ucfirst($relation);
                if (method_exists($this, $includeMethodName)) {
                    $record = $this->$includeMethodName($record, $select, $selectedFields);
                } else {
                    throw new \Exception("The '$relation' does not exist, in the User model.");
                }
            }
        }

        if (!isset($select[$tablePrimaryKey]) && isset($select[$timestamp])) {
            unset($record[$tablePrimaryKey]);
        }

        if ($format === 'object') {
            return new User($this->pdo, $record);
        }

        return $record;
    }

    /**
     * Updates a User in the database.
     *
     * This method updates an existing User record based on the provided filter criteria and
     * update data. It supports updating related records through relations defined in the User model,
     * such as 'userRole', 'product', 'post', and 'Profile'. Additionally, it allows for selective field
     * return and including related models in the response after the update.
     *
     * Workflow:
     * 1. Validates the presence of 'where' and 'data' keys in the input array.
     * 2. Checks for exclusivity between 'select' and 'include' keys, throwing an exception if both are present.
     * 3. Prepares the SQL UPDATE statement based on the provided criteria and data.
     * 4. Executes the update operation within a database transaction to ensure data integrity.
     * 5. Processes any specified relations (e.g., creating related records) as part of the update.
     * 6. Customizes the returned user record based on 'select' or 'include' parameters if specified.
     * 7. Commits the transaction and returns the updated user record, optionally with related data.
     *
     * The method ensures data integrity and consistency throughout the update process by employing
     * transactions. This approach allows for rolling back changes in case of an error, thereby preventing
     * partial updates or data corruption.
     *
     * Parameters:
     * - @param array $data An associative array containing the update criteria and data, which includes:
     *   - 'where': Filter criteria to identify the User to update.
     *   - 'data': The data to update in the User record.
     *   - 'select': Optionally, specifies a subset of fields to return.
     *   - 'include': Optionally, specifies related models to include in the result.
     * - @param string $format (optional) Specifies the format of the returned data ('array' or 'object').
     * 
     * Returns:
     * - @return mixed The updated User record as an associative array or object, depending on the
     *               'format' parameter. If relations are specified, they are processed according
     *               to the provided instructions (connect, disconnect, etc.).
     * 
     * Example Usage:
     * // Example 1: Update a User's email and only return their 'id' and 'email' in the response
     * $updatedUserWithSelect = $prisma->user->update([
     *   'where' => ['id' => 'someUserId'],
     *   'data' => ['email' => 'new.email@example.com'],
     *   'select' => ['id' => true, 'email' => true]
     * ]);
     * 
     * // Example 2: Update a User's username and include their profile information in the response
     * $updatedUserWithInclude = $prisma->user->update([
     *   'where' => ['id' => 'someUserId'],
     *   'data' => ['username' => 'newUsername'],
     *   'include' => ['profile' => true]
     * ]);
     * 
     * Throws:
     * - @throws Exception if both 'include' and 'select' are used simultaneously, or in case of any error during the update process.
     */
    public function update(array $data, string $format = 'array'): array | object
    {
        if (!isset($data['where'])) {
            throw new \Exception("The 'where' key is required in the update User.");
        }

        if (!is_array($data['where'])) {
            throw new \Exception("'where' must be an associative array.");
        }

        if (!isset($data['data'])) {
            throw new \Exception("The 'data' key is required in the update User.");
        }

        if (!is_array($data['data'])) {
            throw new \Exception("'data' must be an associative array.");
        }

        if (isset($data['include']) && isset($data['select'])) {
            throw new \Exception("You can't use both 'include' and 'select' at the same time.");
        }

        $acceptedCriteria = ['where', 'data', 'select', 'include'];
        Utility::checkForInvalidKeys($data, $acceptedCriteria, $this->modelName);

        $where = $data['where'];
        $select = $data['select'] ?? [];
        $include = $data['include'] ?? [];
        $data = $data['data'];
        $relationNames = ['userRole'];

        $dbType = $this->dbType;
        $quotedTableName = $dbType == 'pgsql' ? "\"Users\"" : "`Users`";
        $sql = "UPDATE $quotedTableName SET ";
        $updateFields = [];
        $bindings = [];        $primaryKeyField = '';    

        Utility::checkFieldsExist(array_merge($select, $include), $this->fields, $this->modelName);

        try {
            $this->pdo->beginTransaction();
            foreach ($this->fields as $field) {
                $fieldName = $field['name'];
                $fieldType = $field['type'];
                $isNullable = $field['isNullable'];
                $relation = $field['decorators']['relation'] ?? null;
                $inverseRelation = $field['decorators']['inverseRelation'] ?? null;
                if (!empty($field['decorators']['id'])) {
                    $primaryKeyField = $fieldName;
                }
                if (isset($data[$fieldName]) || !$isNullable) {
                    if (!array_key_exists($fieldName, $data)) continue;
                    if (isset($relation) || isset($inverseRelation)) continue;
                    $validateMethodName = 'validate' . ucfirst($fieldType);
                    $validatedValue = Validator::$validateMethodName($data[$fieldName]);
                    $updateFields[] = "$fieldName = :$fieldName";
                    $bindings[":$fieldName"] = $validatedValue;
                } else {
                    if (array_key_exists($fieldName, $data) && $isNullable) {
                        if (isset($relation) || isset($inverseRelation)) continue;
                        $updateFields[] = "$fieldName = NULL";
                    }
                }
            }
            
            if (!empty($updateFields)) {
                $sql .= implode(', ', $updateFields);

                if (!empty($where)) {
                    $whereClauses = [];
                    foreach ($where as $fieldName => $fieldValue) {
                        if (array_key_exists($fieldName, $this->fields)) {
                            $whereClauses[] = "$fieldName = :where_$fieldName";
                            $bindings[":where_$fieldName"] = $fieldValue;
                        } else {
                            throw new \Exception("The '$fieldName' field does not exist in the User model.");
                        }
                    }

                    if (!empty($whereClauses)) {
                        $sql .= " WHERE " . implode(' AND ', $whereClauses);
                    }
                }

                $stmt = $this->pdo->prepare($sql);
                foreach ($bindings as $key => $value) {
                    $stmt->bindValue($key, $value);
                }

                $stmt->execute();
            }

            $primaryKeyValue = $this->findUnique(['where' => $where])[$primaryKeyField] ?? null;

            if (!empty($relationNames)) {
                foreach ($data as $relationName => $relationDataName) {

                    if (in_array($relationName, $relationNames)) {

                        $connectionTypes = ['create', 'createMany', 'connect', 'connectOrCreate', 'disconnect', 'update', 'updateMany'];
                        $connectType = '';

                        foreach ($connectionTypes as $type) {
                            if (isset($relationDataName[$type])) {
                                $connectType = $type;
                                break;
                            }
                        }

                        if (isset($relationDataName['create']) && isset($relationDataName['connectOrCreate'])) {
                            throw new \Exception("You can't use both 'create' and 'connectOrCreate' at the same time.");
                        }

                        if (isset($relationDataName['create']) && is_array($relationDataName['create'])) {
                            $relationData = $relationDataName['create'];
                            $checkArrayContentType = Utility::checkArrayContents($relationData);

                            if ($checkArrayContentType !== ArrayType::Value) {
                                throw new \Exception("To create a new record, the value of 'create' must be a single array with names as keys and the data to create as values in userRole model. example: ['create' => ['name' => 'someName']]");
                            }

                            $connectMethodName = "connect" . ucfirst($relationName);
                            if (method_exists($this, $connectMethodName)) {
                                $this->$connectMethodName($relationName, $relationDataName[$connectType] ?? [], $primaryKeyValue, $connectType);
                            }
                        } elseif (isset($relationDataName['createMany']) && is_array($relationDataName['createMany'])) {

                            $relationData = $relationDataName['createMany'];
                            $checkArrayContentType = Utility::checkArrayContents($relationData);

                            if ($checkArrayContentType !== ArrayType::Associative) {
                                throw new \Exception("To create many records, use an associative array with the field names as keys and the data to create as values in userRole model. ['createMany' => [['name' => 'someName'], ['name' => 'someOtherName']]");
                            }

                            $connectMethodName = "connect" . ucfirst($relationName);
                            if (method_exists($this, $connectMethodName)) {
                                $this->$connectMethodName($relationName, $relationDataName[$connectType] ?? [], $primaryKeyValue, $connectType);
                            }
                        }
                    }

                    if (isset($relationDataName['connect']) && isset($relationDataName['connectOrCreate'])) {
                        throw new \Exception("You can't use both 'connect' and 'connectOrCreate' at the same time.");
                    }

                    if (isset($relationDataName['connect']) && isset($relationDataName['disconnect'])) {
                        throw new \Exception("You can't use both 'connect' and 'disconnect' at the same time.");
                    }

                    if (isset($relationDataName['connect']) || isset($relationDataName['connectOrCreate']) || isset($relationDataName['disconnect']) || isset($relationDataName['update']) || isset($relationDataName['updateMany'])) {

                        if (isset($relationDataName['connect'])) {
                            $connectData = $relationDataName['connect'];
                            $checkArrayContentType = Utility::checkArrayContents($connectData);

                            if (isset($relationDataName['connect']) && $checkArrayContentType !== ArrayType::Value) {
                                throw new \Exception("The 'connect' key must be an associative array with the field names as keys and the data to create as values related userRole model. example: ['connect' => ['id' => 'someId']]");
                            }
                        }

                        if (isset($relationDataName['connectOrCreate'])) {
                            $connectOrCreateData = $relationDataName['connectOrCreate'];
                            $checkArrayContentType = Utility::checkArrayContents($connectOrCreateData);

                            if (isset($relationDataName['connectOrCreate']) && $checkArrayContentType !== ArrayType::Associative) {
                                throw new \Exception("The 'connectOrCreate' key must be an associative array with the field names as keys and the data to create as values related userRole model. example: ['connectOrCreate' => ['where' => ['id' => 'someId'], 'create' => ['name' => 'someName']]");
                            }
                        }

                        if (isset($relationDataName['disconnect'])) {
                            $disconnectData = $relationDataName['disconnect'];

                            if (!is_bool($disconnectData)) {
                                $checkArrayContentType = Utility::checkArrayContents($disconnectData);

                                if (isset($relationDataName['disconnect']) && $checkArrayContentType !== ArrayType::Value) {
                                    throw new \Exception("The 'disconnect' key must be an associative array with the field names as keys and the data to create as values related userRole model. example: ['disconnect' => ['id' => 'someId']]");
                                }
                            }
                        }

                        $connectMethodName = "connect" . ucfirst($relationName);
                        if (method_exists($this, $connectMethodName)) {
                            $this->$connectMethodName($relationName, $relationDataName[$connectType] ?? [], $primaryKeyValue, $connectType);
                        } else {
                            echo "Method $connectMethodName does not exist.";
                        }
                    }
                }
            }

            $selectOrInclude = '';
            if (!empty($select)) {
                $selectOrInclude = 'select';
            } elseif (!empty($include)) {
                $selectOrInclude = 'include';
            }
            $selectedFields = array_merge($select, $include);

            $result = $this->findUnique(['where' => $where, $selectOrInclude => $selectedFields], $format);
            $this->pdo->commit();
            return $result;
        } catch (\Exception $e) {
            $this->pdo->rollBack(); // Rollback transaction on error
            throw $e;
        }
    }

    /**
     * Deletes a User from the database based on specified criteria.
     *
     * This method enables the deletion of an existing User record through filter criteria
     * defined in an associative array. Before deletion, it verifies the User's existence and
     * optionally returns the User's data pre-deletion. It ensures precise deletion by requiring
     * conditions that uniquely identify the User.
     * 
     * @param array $criteria An associative array containing the filter criteria to locate and delete the User.
     *                        The 'where' key within this array is mandatory and should uniquely identify a single User record.
     *                        Optionally, 'select' or 'include' keys may be provided (but not both) to specify which data to return
     *                        upon successful deletion.
     * @param string $format (optional) Specifies the format of the returned data upon successful deletion. 
     *                       Accepts 'array' (default) for associative array output, or 'object' for a standard PHP object
     *                       representing the User's data.
     * 
     * @return mixed On successful deletion, returns the deleted User's data in the specified `$format`. The return
     *               type is mixed, either an array or an object based on `$format`.
     *               If the deletion is unsuccessful due to a non-existent User or non-unique criteria, returns an
     *               array with 'modelName' and 'cause' keys, indicating the reason for failure.
     * 
     * @example
     * // Delete a User by ID and return the deleted User's data as an array
     * $deletedUser = $prisma->user->delete([
     *   'where' => ['id' => 'someUserId']
     * ]);
     * 
     * @example
     * // Delete a User by ID, selecting specific fields to return
     * $deletedUser = $prisma->user->delete([
     *   'where' => ['id' => 'someUserId'],
     *   'select' => ['name' => true, 'email' => true]
     * ]);
     * 
     * @example
     * // Delete a User by ID, including related records in the return value
     * $deletedUser = $prisma->user->delete([
     *   'where' => ['id' => 'someUserId'],
     *   'include' => ['posts' => true]
     * ]);
     * 
     * @throws Exception if the 'where' key is missing or not an associative array in `$criteria`.
     * @throws Exception if both 'include' and 'select' keys are present in `$criteria`, as they cannot be used simultaneously.
     * @throws Exception if there's an error during the deletion process or if the transaction fails,
     *                   indicating the nature of the error for debugging purposes.
     */
    public function delete(array $criteria, string $format = 'array'): array | object
    {
        if (!isset($criteria['where'])) {
            throw new \Exception("The 'where' key is required in the delete User.");
        }

        if (!is_array($criteria['where'])) {
            throw new \Exception("'where' must be an associative array.");
        }

        if (isset($criteria['include']) && isset($criteria['select'])) {
            throw new \Exception("You can't use both 'include' and 'select' at the same time.");
        }

        $acceptedCriteria = ['where', 'select', 'include'];
        Utility::checkForInvalidKeys($criteria, $acceptedCriteria, $this->modelName);

        try {
            $this->pdo->beginTransaction();

            $where = $criteria['where'];
            $select = $criteria['select'] ?? [];
            $include = $criteria['include'] ?? [];
            $whereClauses = [];
            $bindings = [];

            Utility::processConditions($where, $whereClauses, $bindings, $this->dbType);

            $dbType = $this->dbType;
            $quotedTableName = $dbType == 'pgsql' ? "\"Users\"" : "`Users`";
            $sql = "DELETE FROM $quotedTableName WHERE ";
            $sql .= implode(' AND ', $whereClauses);

            $stmt = $this->pdo->prepare($sql);
            foreach ($bindings as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $selectOrInclude = '';
            if (!empty($select)) {
                $selectOrInclude = 'select';
            } elseif (!empty($include)) {
                $selectOrInclude = 'include';
            }
            $selectedFields = array_merge($select, $include);

            $deletedRow = $this->findUnique(['where' => $where, $selectOrInclude => $selectedFields], $format);

            $stmt->execute();
            $affectedRows = $stmt->rowCount();
            $this->pdo->commit();

            return $affectedRows ? $deletedRow : ['modelName' => 'User', 'cause' => 'Record to delete does not exist.'];
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Performs an Upsert Operation on a User Record
     * 
     * Implements an "upsert" operation for User records. This method checks for the existence of a User based on
     * specified 'where' conditions. If the User exists, it updates the User with the provided 'update' data;
     * if the User does not exist, it creates a new User with the 'create' data. This operation is atomic, ensuring
     * data integrity through transaction management. Additionally, it allows for selective field return through
     * 'select' or related records inclusion with 'include'.
     * 
     * Parameters:
     * - array $data: Contains keys for operation configuration:
     *   - 'where': Conditions to find an existing User.
     *   - 'create': Data for creating a new User if no existing match is found.
     *   - 'update': Data for updating an existing User.
     *   - 'select': Optional. Specifies fields to return in the result, reducing payload size.
     *   - 'include': Optional. Specifies related records to include in the result, expanding payload details.
     * - string $format: Determines the return format ('array' or 'object'), allowing flexibility in handling the response.
     * 
     * Return Value:
     * - Depending on the $format parameter, returns either an array or object that includes either the primary key of the
     *   updated record, a boolean true if an update was successful, or the primary key of the newly created record.
     * 
     * Exceptions:
     * - Throws an \Exception if essential keys ('where', 'create', or 'update') are missing from the input $data array, or
     *   if an invalid criteria key is provided.
     * 
     * Example Usage:
     * 
     * $user = $prisma->user->upsert([
     *   'where' => ['email' => 'user@example.com'],
     *   'create' => ['name' => 'New User', 'email' => 'user@example.com', 'password' => 'newuserpassword'],
     *   'update' => ['name' => 'Updated User Name'],
     *   'select' => ['name', 'email'], // Optional: Specify fields to return
     * ], 'array');
     * 
     * 
     * This method streamlines data management by allowing for conditional creation or update of User records within a single,
     * atomic operation. It offers enhanced flexibility and efficiency, particularly useful in scenarios where the presence
     * of a record dictates the nature of the transaction, and detailed or minimalistic data retrieval is desired post-operation.
     */
    public function upsert(array $data, string $format = 'array'): array | object
    {
        if (!isset($data['where']) || !isset($data['create']) || !isset($data['update'])) {
            throw new \Exception("Missing criteria keys. 'where', 'create', and 'update' must be provided.");
        }

        $acceptedCriteria = ['where', 'create', 'update', 'select', 'include'];
        Utility::checkForInvalidKeys($data, $acceptedCriteria, 'User');

        try {
            $this->pdo->beginTransaction();
            $where = $data['where'];
            $create = $data['create'];
            $update = $data['update'];
            $select = $data['select'] ?? [];
            $include = $data['include'] ?? [];
            $existingRecord = $this->findUnique(['where' => $where]);

            $selectOrInclude = '';
            if (!empty($select)) {
                $selectOrInclude = 'select';
            } elseif (!empty($include)) {
                $selectOrInclude = 'include';
            }
            $selectedFields = array_merge($select, $include);

            if ($existingRecord) {
                $dataToUpdate = [
                    'where' => $where,
                    'data' => $update,
                    $selectOrInclude => $selectedFields
                ];
                $updateResult = $this->update($dataToUpdate, $format);
                $this->pdo->commit();
                return $updateResult;
            } else {
                $dataToCreate = [
                    'data' => $create,
                    $selectOrInclude => $selectedFields
                ];
                $insertResult = $this->create($dataToCreate, $format);
                $this->pdo->commit();
                return $insertResult;
            }
        } catch (\Exception $e) {
            $this->pdo->rollBack(); // Rollback transaction on error
            throw $e;
        }
    }

    /**
     * Performs an aggregate operation on the 'Users' table.
     * 
     * @param array $criteria Associative array specifying the aggregate operation and conditions.
     *                         Example: ['function' => 'COUNT', 'field' => '*', 'where' => ['status' => 'active']]
     * @return mixed The result of the aggregate operation.
     * @throws \Exception Throws an exception if the database operation fails.
     */
    public function aggregate(array $operation, string $format = 'array'): array | object
    {
        if (Utility::checkArrayContents($operation) !== ArrayType::Associative) {
            throw new \Exception("The 'operation' parameter must be an associative array.");
        }

        $acceptedCriteria = ['_avg', '_count', '_max', '_min', '_sum', 'cursor', 'orderBy', 'skip', 'take', 'where'];
        Utility::checkForInvalidKeys($operation, $acceptedCriteria, 'User');        

        $quotedTableName = $this->dbType == 'pgsql' ? "\"Users\"" : "`Users`";
        $sqlSelectParts = [];
        $bindings = [];
        $conditions = [];

        $aggregateFunctions = ['_avg' => 'AVG', '_count' => 'COUNT', '_max' => 'MAX', '_min' => 'MIN', '_sum' => 'SUM'];
        foreach ($aggregateFunctions as $key => $function) {
            if (isset($operation[$key]) && is_array($operation[$key])) {
                foreach ($operation[$key] as $field => $enabled) {
                    if ($enabled) {
                        $alias = $this->dbType == 'pgsql' ? "\"{$field}\"" : "`{$field}`";
                        $sqlSelectParts[] = "{$function}({$alias}) AS {$alias}";
                    }
                }
            }
        }

        if (empty($sqlSelectParts)) {
            throw new \Exception('No valid aggregate function specified.');
        }

        if (isset($operation['cursor']) && is_array($operation['cursor'])) {
            foreach ($operation['cursor'] as $field => $value) {
                $fieldQuoted = $this->dbType == 'pgsql' ? "\"$field\"" : "`$field`";
                $conditions[] = "$fieldQuoted >= :cursor_$field";
                $bindings[":cursor_$field"] = $value;
            }
        }

        $sql = "SELECT " . implode(', ', $sqlSelectParts) . " FROM {$quotedTableName}";

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        if (isset($operation['orderBy'])) {
            $orderByParts = [];
            foreach ($operation['orderBy'] as $field => $direction) {
                $orderByParts[] = "$field $direction";
            }
            $sql .= " ORDER BY " . implode(', ', $orderByParts);
        }

        if (isset($operation['take'])) {
            $sql .= " LIMIT :take";
            $bindings[':take'] = (int)$operation['take'];
        }

        if (isset($operation['skip'])) {
            $sql .= " OFFSET :skip";
            $bindings[':skip'] = (int)$operation['skip'];
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($bindings as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $format === 'array' ? $stmt->fetch(\PDO::FETCH_ASSOC) : new User ($this->pdo, $stmt->fetch(\PDO::FETCH_ASSOC));    }

    /**
     * Groups records in the 'Users' table and performs aggregate operations.
     * 
     * @param array $criteria Array specifying the fields to group by.
     * @param array $aggregates Array specifying the aggregate operations (e.g., COUNT, SUM).
     * @return array An array of results with grouped data.
     * @throws \Exception Throws an exception if the database operation fails.
     */
    public function groupBy($criteria) 
    {
        $aggregates = $criteria['aggregates'] ?? [];
        $dbType = $this->pdo->getAttribute(\PDO::ATTR_DRIVER_NAME);
        $quotedTableName = $dbType == 'pgsql' ? "\"Users\"" : "`Users`";
        $groupByFields = implode(', ', $criteria);
        $aggregateFields = array_map(fn($a) => "{$a['function']}({$a['field']}) AS {$a['alias']}", $aggregates);
        $sql = "SELECT $groupByFields, " . implode(', ', $aggregateFields) . " FROM $quotedTableName GROUP BY $groupByFields";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Updates multiple records in the 'Users' table based on the specified conditions.
     *
     * This method dynamically constructs a SQL UPDATE query to modify records in the 'Users' table. It requires an associative array input with two primary keys: 'where' and 'data'. The 'where' key defines the conditions to identify which records should be updated, while the 'data' key contains the new values for specified fields.
     *
     * Validation is performed at the beginning to ensure both 'where' and 'data' keys are present and correctly structured. The method encapsulates the update operation within a database transaction, ensuring atomicity. If any part of the process fails, the transaction is rolled back to maintain data integrity.
     *
     * Only specified fields in the 'data' array are updated, and each field's value is validated according to its defined type in the 'Users' table schema. Relations and inverse relations are also considered to maintain referential integrity. The method concludes by committing the transaction if all updates are successful or rolling it back in case of an exception.
     *
     * @param array $data An associative array containing 'where' and 'data' keys.
     *                    The 'where' key is an associative array specifying the update conditions.
     *                    The 'data' key is an associative array of field names and their new values for the update.
     * @return array|false Returns an associative array with the status, message, and number of affected rows upon success.
     *                     Returns false if the record to be updated is not found.
     * @throws \Exception Throws an exception if required keys are missing or if the database operation fails.
     *
     * Example Usage:
     * $prisma = new Prisma();
     * $updateData = ['name' => 'New Name', 'email' => 'newemail@example.com'];
     * $identifier = ['id' => 1];
     * $updatedRecord = $prisma->UserModel->updateMany(['where' => $identifier, 'data' => $updateData]);
     */
    public function updateMany(array $data)
    {
        if (!isset($data['where'])) {
            throw new \Exception("The 'where' key is required in the updateMany User.");
        }

        if (!is_array($data['where'])) {
            throw new \Exception("'where' must be an associative array.");
        }

        if (!isset($data['data'])) {
            throw new \Exception("The 'data' key is required in the updateMany User.");
        }

        if (!is_array($data['data'])) {
            throw new \Exception("'data' must be an associative array.");
        }

        $acceptedCriteria = ['where', 'data'];
        Utility::checkForInvalidKeys($data, $acceptedCriteria, $this->modelName);

        try {
            $this->pdo->beginTransaction();

            $dataToUpdate = $data['data'] ?? [];
            $where = $data['where'] ?? [];

            $fieldsToReview = array_flip(array_keys(array_merge($dataToUpdate, $where)));
            $fieldsToReview = array_fill_keys(array_keys($fieldsToReview), true);

            Utility::checkFieldsExist($fieldsToReview, $this->fields, $this->modelName);

            $dbType = $this->dbType;
            $quotedTableName = $dbType == 'pgsql' ? "\"Users\"" : "`Users`";
            $sql = "UPDATE $quotedTableName SET ";
            $updateFields = [];
            $bindings = [];

            foreach ($this->fields as $field) {
                $fieldName = $field['name'];
                $fieldType = $field['type'];
                $isNullable = $field['isNullable'];
                $relation = $field['decorators']['relation'] ?? null;
                $inverseRelation = $field['decorators']['inverseRelation'] ?? null;

                if (isset($dataToUpdate[$fieldName]) || !$isNullable) {
                    if (!array_key_exists($fieldName, $dataToUpdate)) continue;
                    if (isset($relation) || isset($inverseRelation)) continue;
                    $validateMethodName = 'validate' . ucfirst($fieldType);
                    $validatedValue = Validator::$validateMethodName($dataToUpdate[$fieldName]);
                    $updateFields[] = "$fieldName = :$fieldName";
                    $bindings[":$fieldName"] = $validatedValue;
                } else {
                    if (array_key_exists($fieldName, $dataToUpdate) && $isNullable) {
                        if (isset($relation) || isset($inverseRelation)) continue;
                        $updateFields[] = "$fieldName = NULL";
                    }
                }
            }

            $sql .= implode(', ', $updateFields);

            if (!empty($where)) {
                $whereClauses = [];
                foreach ($where as $fieldName => $fieldValue) {
                    if (array_key_exists($fieldName, $this->fields)) {
                        $whereClauses[] = "$fieldName = :where_$fieldName";
                        $bindings[":where_$fieldName"] = $fieldValue;
                    } else {
                        throw new \Exception("The '$fieldName' field does not exist in the User model.");
                    }
                }

                if (!empty($whereClauses)) {
                    $sql .= " WHERE " . implode(' AND ', $whereClauses);
                }
            }

            $stmt = $this->pdo->prepare($sql);
            foreach ($bindings as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->execute();

            $this->pdo->commit(); // Commit transaction

            return [
                'status' => 'success',
                'message' => 'Records updated successfully.',
                'affectedRows' => $stmt->rowCount()
            ];
        } catch (\Exception $e) {
            $this->pdo->rollBack(); // Rollback transaction on error
            throw $e;
        }
    }

    /**
     * Deletes multiple records from the 'Users' table based on the specified criteria.
     * 
     * This method allows for the deletion of multiple records by specifying conditions in the `criteria` parameter.
     * The `criteria` must contain a 'where' key with an associative array of conditions. These conditions are used
     * to construct a SQL DELETE query dynamically. The method initiates a transaction before performing the delete operation
     * and commits the transaction upon successful deletion. If an exception occurs during the process, the transaction
     * is rolled back. The method returns an array with the status of the operation ('success' or 'failure'), a message,
     * and the number of affected rows.
     * 
     * The method utilizes field validators to ensure the integrity of the data before performing the delete operation.
     * Each field's value is validated against a specific rule based on the field's type. If a validator for a field's
     * type is not defined, the method throws an exception.
     * 
     * @param array $criteria An associative array with a 'where' key that defines the conditions for the deletion.
     *                        The 'where' value must be an associative array with field names as keys and their corresponding values.
     * @return array Returns an array with keys 'status', 'message', and 'affectedRows'. 'status' can be either 'success' or 'failure'.
     *               'message' provides information about the operation's outcome. 'affectedRows' indicates the number of rows affected by the delete operation.
     * @throws \Exception Throws an exception if the 'where' key is missing, if 'where' is not an associative array, if there's no validator defined for a field type,
     *                    or if the database operation fails for any other reason.
     *
     * Example Usage:
     * $prisma = new Prisma();
     * $criteria = ['where' => ['id' => 1]];
     * $result = $prisma->UserModel->deleteMany($criteria);
     * echo "Status: " . $result['status'] . "
";
     * echo "Message: " . $result['message'] . "
";
     * echo "Number of affected rows: " . $result['affectedRows'];
     */
    public function deleteMany($criteria) 
    {
        if (!isset($criteria['where'])) {
            throw new \Exception("The 'where' key is required in the deleteMany User.");
        }

        if (!is_array($criteria['where'])) {
            throw new \Exception("'where' must be an associative array.");
        }

        $acceptedCriteria = ['where'];
        Utility::checkForInvalidKeys($criteria, $acceptedCriteria, $this->modelName);

        try {
            $this->pdo->beginTransaction();
            $where = $criteria['where'];
            $dbType = $this->dbType;
            $quotedTableName = $dbType == 'pgsql' ? "\"Users\"" : "`Users`";
            $sql = "DELETE FROM $quotedTableName WHERE ";
            $whereClauses = [];
            $bindings = [];

            Utility::processConditions($where, $whereClauses, $bindings, $this->dbType);

            $sql .= implode(' AND ', $whereClauses);
            $stmt = $this->pdo->prepare($sql);
            foreach ($bindings as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->execute();
            $affectedRows = $stmt->rowCount();
            $this->pdo->commit();

            return [
                'status' => $affectedRows ? 'success' : 'failure',
                'message' => $affectedRows ? 'Records deleted successfully.' : 'No records found to delete.',
                'affectedRows' => $affectedRows
            ];
        } catch (\Exception $e) {
            $this->pdo->rollBack(); // Rollback transaction on error
            throw $e;
        }
    }

    /**
     * Counts the number of records in the 'Users' table based on provided criteria.
     * 
     * This method counts records that match the specified criteria. The criteria should
     * contain key-value pairs where keys are the names of the fields and values are the
     * conditions to match.
     * 
     * @param array $criteria Associative array of criteria for selecting the records to be counted.
     * @return int The number of records that match the criteria.
     * @throws \Exception Throws an exception if the database operation fails.
     *
     * Example Usage:
     * $prisma = new Prisma();
     * $countCriteria = ['status' => 'active'];
     * $activeUserCount = $prisma->User->count($countCriteria);
     */
    public function count($criteria) 
    {
        $dbType = $this->pdo->getAttribute(\PDO::ATTR_DRIVER_NAME);
        $quotedTableName = $dbType === 'pgsql' ? "\"Users\"" : "`Users`";
        $sql = "SELECT COUNT(*) FROM $quotedTableName WHERE ";
        $conditions = [];
        $bindings = [];

        foreach ($criteria as $key => $value) {
            $conditions[] = "$key = :$key";
            $bindings[":$key"] = $value;
        }

        if (!empty($conditions)) {
            $sql .= implode(' AND ', $conditions);
        } else {
            $sql = "SELECT COUNT(*) FROM $quotedTableName"; // If no criteria, count all records
        }

        $stmt = $this->pdo->prepare($sql);

        foreach ($bindings as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt->fetchColumn(); // Fetch the count result
    }
}
