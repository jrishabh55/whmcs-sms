<?php
namespace JNEX\SMS;

use Countable;
use JsonSerializable;
use Illuminate\Database\Capsule\Manager as Capsule;

class Hooks implements Countable, JsonSerializable
{
    private $hooks = [];

    private static $init;

    public function __constructor()
    {
        return $this;
    }

    public static function init()
    {
        if (!static::$init) {
            return static::$init = new self;
        } else {
            return static::$init;
        }
    }

    public function add($hook)
    {
        if (\is_array($hook)) {
            $this->hooks = \array_merge($this->hooks, $hook);
        } else {
            array_push($this->hooks, $hook);
        }
        return $this;
    }

    public function exec()
    {
        if (!$this->count()) {
            return false;
        }

        foreach ($this->hooks as $hook) {
            add_hook($hook, 1, function (array $vars) use ($hook) {
                \call_user_func([$this, $hook], $vars);
            });
        }

        return $this;
    }

    public function __call($name, $args)
    {
        $vars = $args[0];
        return $this;
    }

    public function count()
    {
        return \count($this->hooks);
    }

    public function jsonSerialize()
    {
        return \json_encode($this->hooks);
    }
}
