<?php

namespace KmeCnin\Toolbox\Functional;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use ArrayIterator;

class CollectionIterator implements CollectionInterface, Countable, IteratorAggregate, ArrayAccess
{
    /** @var array */
    private $elements;

    /**
     * @param array|\Traversable $elements
     */
    public function __construct($elements = [])
    {
        if (is_array($elements)) {
            $this->elements = $elements;
            return;
        }

        if (is_object($elements) && method_exists($elements, 'toArray')) {
            $this->elements = $elements->toArray();
            return;
        }

        if ($elements instanceof \Traversable) {
            foreach ($elements as $element) {
                $this->elements[] = $element;
            }
            return;
        }
    }

    /**
     * @param array $elements
     * @return $this
     */
    public static function fromArray(array $elements)
    {
        return new CollectionIterator($elements);
    }

    /**
     * @param \Traversable $elements
     * @return $this
     */
    public static function fromTraversable(\Traversable $elements)
    {
        return new CollectionIterator($elements);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->elements;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->elements);
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return reset($this->elements) ?: null;
    }

    /**
     * @return mixed
     */
    public function last()
    {
        return end($this->elements) ?: null;
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->elements);
    }

    /**
     * @return mixed
     */
    public function next()
    {
        return next($this->elements);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->elements);
    }

    /**
     * @param mixed $key
     * @return null|mixed
     */
    public function remove($key)
    {
        if (!isset($this->elements[$key]) &&
            !array_key_exists($key, $this->elements)
        ) {
            return null;
        }

        $removed = $this->elements[$key];
        unset($this->elements[$key]);

        return $removed;
    }

    /**
     * @param mixed $element
     * @return bool
     */
    public function removeElement($element)
    {
        $key = array_search($element, $this->elements, true);

        if ($key === false) {
            return false;
        }

        unset($this->elements[$key]);

        return true;
    }

    /**
     * Required by interface ArrayAccess.
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetExists($offset)
    {
        return $this->containsKey($offset);
    }

    /**
     * Required by interface ArrayAccess.
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Required by interface ArrayAccess.
     *
     * @param mixed $offset
     * @param mixed $value
     * @return mixed
     */
    public function offsetSet($offset, $value)
    {
        if (!isset($offset)) {
            return $this->add($value);
        }

        $this->set($offset, $value);
    }

    /**
     * Required by interface ArrayAccess.
     *
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }

    /**
     * @param $key
     * @return bool
     */
    public function containsKey($key)
    {
        return isset($this->elements[$key]) || array_key_exists($key, $this->elements);
    }

    /**
     * @param $element
     * @return bool
     */
    public function contains($element)
    {
        return in_array($element, $this->elements, true);
    }

    /**
     * @param callable $p
     * @return bool
     */
    public function exists(callable $p)
    {
        foreach ($this->elements as $key => $element) {
            if ($p($key, $element)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param mixed $element
     * @return mixed
     */
    public function indexOf($element)
    {
        return array_search($element, $this->elements, true);
    }

    /**
     * @param mixed $key
     * @return null|mixed
     */
    public function get($key)
    {
        return isset($this->elements[$key]) ? $this->elements[$key] : null;
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return array_keys($this->elements);
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return array_values($this->elements);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->elements);
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->elements[$key] = $value;
    }

    /**
     * @param $value
     * @return bool
     */
    public function add($value)
    {
        $this->elements[] = $value;

        return true;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->elements);
    }

    /**
     * Required by interface IteratorAggregate.
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->elements);
    }

    /**
     * @param callable $func
     * @return static
     */
    public function map(callable $func)
    {
        $result = new static(array_map($func, $this->elements));
        return $result;
    }

    /**
     * Will assign result to $export if provided.
     *
     * @param array $export
     * @return $this
     */
    public function export(array &$export = null)
    {
        $export = $this->elements;
        return $this;
    }

    /**
     * Map collection according to given callable and map the keys too.
     * Data returned by callable must be an array of 1 entry.
     * `return [$newKey => $newValue];`
     *
     * @param callable $func
     * @return static
     */
    public function mapWithKeys(callable $func)
    {
        $elements = [];
        foreach ($this->elements as $element) {
            $returnedMapping = $func($element);
            $keys = array_keys($returnedMapping);
            $key = reset($keys);
            $value = reset($returnedMapping);
            $elements[$key] = $value;
        }
        return new static($elements);
    }

    /**
     * @param callable       $func
     * @param null|mixed     $initial
     * @return static
     */
    public function reduce(callable $func, $initial = null)
    {
        return array_reduce($this->elements, $func, $initial);
    }

    /**
     * @param callable $p
     * @return static
     */
    public function filter(callable $p)
    {
        return new static(array_filter($this->elements, $p));
    }

    /**
     * @param callable $p
     * @return bool
     */
    public function all(callable $p)
    {
        foreach ($this->elements as $key => $element) {
            if (!$p($key, $element)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param callable $p
     * @return array
     */
    public function partition(callable $p)
    {
        $matches = $noMatches = array();

        foreach ($this->elements as $key => $element) {
            if ($p($key, $element)) {
                $matches[$key] = $element;
            } else {
                $noMatches[$key] = $element;
            }
        }

        return array(new static($matches), new static($noMatches));
    }

    /**
     * Returns a string representation of this object.
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . '@' . spl_object_hash($this);
    }

    public function clear()
    {
        $this->elements = array();
    }

    /**
     * @param      $offset
     * @param null $length
     * @return array
     */
    public function slice($offset, $length = null)
    {
        return array_slice($this->elements, $offset, $length, true);
    }

    public function unique(): self
    {
        return new static(array_values(array_unique($this->elements)));
    }

    public function flatten(): self
    {
        $flattened = [];
        array_walk_recursive($this->elements, function ($a) use (&$flattened) {
            $flattened[] = $a;
        });

        return new static($flattened);
    }

    public function values(): self
    {
        return new static(array_values($this->elements));
    }
}
