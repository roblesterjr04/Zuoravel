<?php

namespace Lester\Zuoravel\Models;

use Illuminate\Database\Eloquent\Model;
use Lester\Zuoravel\Facades\Zuora;

abstract class RestModel extends Model
{

    private $client;
    protected $object;

    protected $guarded = [];

    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->client = Zuora::getZuoraClient();
        $this->table = $this->object;
    }

    public static function create(array $options = [])
    {

    }

    public function update(array $attributes = [], array $options = [])
    {

    }

    public static function get($id)
    {
        $options = Zuora::getZuoraClient()->get((new static())->getObject() . '/' . $id);
        return new static((array)$options);
    }

    public function getObject()
    {
        return $this->object;
    }

    public static function all($arguments = [])
    {
        $model = new static();
        $collectionOf = strtolower(str_plural(class_basename($model->collectionOf)));
        $options = Zuora::getZuoraClient()->get($model->getObject(), [], $arguments);

        /*$queryParams = [];
        if (property_exists($options, 'nextPage')) {
            $query = parse_url($options->nextPage, PHP_URL_QUERY);
            parse_str($query, $queryParams);
        }*/

        $collection = collect($options->$collectionOf)->map(function($item) use ($model) {
            return new $model->collectionOf((array)$item);
        });
        $collection->nextPage = $options->nextPage;
        $collection->arguments = $arguments;
        return $collection;
    }

    public function describe()
    {
        $className = strtolower(class_basename($this));
        return $this->client->get('describe/' . $className);
    }

    /*public static function __callStatic($method, $arguments)
    {
        return (new static)->$method(...$arguments);
    }*/

}
