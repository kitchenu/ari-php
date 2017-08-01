<?php

namespace Ari\Models;

class Model
{
    /**
     * The json_decoded message data from ARI
     *
     * @var object
     */
    protected $response;

    /**
     * @param string $response The raw json response response data from ARI
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    public function getResponseValue($propertyName, $className = null)
    {
        if (property_exists($this->response, $propertyName)) {
            $property = $this->response->{$propertyName};

            if (!is_array($property)) {
                return $this->property($property, $className);
            }

            $models = [];
            foreach ($property as $model) {
                $models[] = $this->property($model, $className);
            }

            return $models;
        }

        return null;
    }

    protected function property($property, $className = null)
    {
        if ($className === null || !class_exists($className)) {
            return $property;
        }

        return new $className($property);
    }
}
