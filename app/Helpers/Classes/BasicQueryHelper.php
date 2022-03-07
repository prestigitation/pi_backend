<?php
namespace App\Helpers\Classes;

use App\Helpers\Interfaces\QueryHelperInterface;
use Illuminate\Database\Eloquent\Builder;

class BasicQueryHelper implements QueryHelperInterface {
    private $query;
    private $data;
    private $pluralizer;

    public function __construct(Builder $query, array $data) {
        $this->query = $query;
        $this->data = $data;
        $this->pluralizer = new Pluralizer();
    }
    public function query(string $name): self {
        $this->query->when(isset($this->data[$name]), function (Builder $query) use ($name) {
            foreach($this->data[$name] as $key => $dataPart) {
                $this->baseQuery($query, $name, $key, $dataPart);
            }
        });
        return $this;
    }
    public function baseQuery(Builder $query, string $name, string $key, mixed $dataPart): void {
        var_dump('name'.$name.'key'.$key.'dataPart'.$dataPart);
        $query->where($this->pluralizer->apluralize($name).'_'.$key, $dataPart[$key]);
    }
}
