<?php

namespace Jurager\Commerce\ORM;

use ArrayObject;
use SimpleXMLElement;
use Jurager\Commerce\Commerce;

abstract class Model extends ArrayObject
{
    private bool $registered = false;

    /**
     * @var Commerce
     */
    public Commerce $owner;

    /**
     * @var null|SimpleXMLElement
     */
    public ?SimpleXMLElement $xml = null;

    /**
     * @return array
     */
    public function propertyAliases()
    {
        return [
            'Ид' => 'id',
            'Наименование' => 'name',
            'Значение' => 'value',
        ];
    }

    /**
     * @return string
     */
    public function getClearId(): string
    {
        return explode('#', $this->id, 2)[0];
    }

    /**
     * @return string
     */
    public function getIdSuffix(): string
    {
        return (string) \array_slice(explode('#', $this->id), 1)[0];
    }

    /**
     * Model constructor.
     *
     * @param Commerce $owner
     * @param SimpleXMLElement|null $xml
     */
    public function __construct(Commerce $owner, SimpleXMLElement $xml = null)
    {
        $this->owner = $owner;
        $this->xml = $xml ?: $this->loadXml();
        $this->init();

        parent::__construct();
    }

    /**
     * @param $name
     * @return null|string
     */
    protected function getPropertyAlias($name): ?string
    {
        $attributes = $this->xml;

        if ($idx = array_search($name, $this->propertyAliases())) {

            if (isset($attributes[$idx])) {
                return trim((string)$attributes[$idx]);
            }

            return trim((string)$this->xml->{$idx});
        }

        return null;
    }

    /**
     * @param $name
     * @return mixed|null|SimpleXMLElement|string
     */
    public function __get($name)
    {
        if (method_exists($this, $method = 'get' . ucfirst($name))) {
            return $this->$method();
        }

        if ($this->xml) {

            $attributes = $this->xml;

            if (isset($attributes[$name])) {
                return trim((string)$attributes[$name]);
            }

            if ($value = $this->xml->{$name}) {
                return $value;
            }

            if (($value = $this->getPropertyAlias($name)) !== null) {
                return $value;
            }
        }

        return null;
    }

    public function __set($name, $value)
    {
    }

    public function __isset($name)
    {
    }

    public function loadXml()
    {
        $this->register();

        return null;
    }

    public function init(): void
    {
        $this->register();
    }

    protected function register(): void
    {
        if ($this->xml && !$this->registered && ($namespaces = $this->xml->getNamespaces())) {
            $this->registered = true;
            foreach ($namespaces as $namespace) {
                $this->xml->registerXPathNamespace('c', $namespace);
            }
        }
    }

    /**
     * Лучше использовать данный метод, вместо стандартного xpath у SimpleXMLElement,
     * т.к. есть проблемы с namespace для xmlns.
     *
     * Для каждого элемента необходимо указывать namespace "c", например:
     * //c:Свойство/c:ВариантыЗначений/c:Справочник[c:ИдЗначения = ':параметр']
     *
     * @param string $path
     * @param array $args - Аргументы задаём в виде ['параметр' => 'значение'] без двоеточия
     * @return SimpleXMLElement[]
     */
    public function xpath(string $path, array $args = [])
    {
        $this->register();

        if (!$this->registered) {
            $path = str_replace('c:', '', $path);
        }

        if (!empty($args)) {
            foreach ($args as $ka => $kv) {
                $replace = (str_contains($kv, "'") ? ("concat('" . str_replace("'", "',\"'\",'", $kv) . "')") : "'" . $kv . "'");
                $path = str_replace(':' . $ka, $replace, $path);
            }
        }

        return $this->xml->xpath($path);
    }
}
