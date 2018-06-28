<?php
namespace app\models\sql;


use yii\db\Query as MySQL;
use yii\sphinx\Query as Sphinx;

abstract class SqlAbstract
{
    const FIELDS_DEFAULT = ['*'];

    protected $command;
    protected $fields = null;
    protected $limit = null;
    protected $offset = null;

    public function __construct($db = 'MySQL')
    {
        if ($db === 'MySQL') {
            $this->command = new MySQL();
        }
    }

    public function setFields($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    abstract public function build();

    public function all()
    {
        $this->afterBuild();
        return $this->command->all();
    }

    public function count()
    {
        return $this->command->count();
    }

    public function one()
    {
        return $this->command->one();
    }

    protected function afterBuild()
    {
        if ($this->limit !== null) {
            $this->command->limit($this->limit);
        }
        if ($this->offset !== null) {
            $this->command->offset($this->offset);
        }
    }

    protected function getFields()
    {
        return $this->fields ?: static::FIELDS_DEFAULT;
    }

    public function getSql()
    {
        return $this->command
            ->createCommand()
            ->getRawSql();
    }
}