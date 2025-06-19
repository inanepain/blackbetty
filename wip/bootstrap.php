<?php

declare(strict_types=1);

class ConsoleScriptManager {
    private static array $propertyValues = [true, false];

    public ?bool $nullSetOnce = null {
        get => $this->nullSetOnce;
        set => $this->nullSetOnce = $this->nullSetOnce === null ? $value : $this->nullSetOnce;
    }

    /**
     * This property is set to false by default and can only be set once.
     *
     * If set to true, it will not change back to false.
     * If set to false, it will remain false.
     *
     * @var bool
     */
    public bool $falseSetOnce {
        get => isset($this->falseSetOnce) ? $this->falseSetOnce : false;
        set => $this->falseSetOnce = isset($this->falseSetOnce) ? $this->falseSetOnce : $value;
    }

    public bool $trueSetOnce {
        get => isset($this->trueSetOnce) ? $this->trueSetOnce : true;
        set => $this->trueSetOnce = isset($this->trueSetOnce) ? $this->trueSetOnce : $value;
    }

    /**
     * Indicates a boolean value that is initially false until set to true.
     *
     * Unlike `falseSetOnce`, this property can be set to false repeatedly,
     *  until it is set to true after which it will remain true.
     *
     * @var bool
     */
    public bool $falseUntilTrue {
        get => isset($this->falseUntilTrue) ? $this->falseUntilTrue : true;
        set => $this->falseUntilTrue = isset($this->falseUntilTrue) ? $this->falseUntilTrue : $value;
    }

    public bool $trueUntilFalse {
        get => isset($this->trueUntilFalse) ? $this->trueUntilFalse : true;
        set => $this->trueUntilFalse = isset($this->trueUntilFalse) ? $this->trueUntilFalse : $value;
    }

    public function randomPropertyValue(): ?bool {
        $valueIndex = array_rand(static::$propertyValues, 1);
        return static::$propertyValues[$valueIndex];
    }
}

$csm = new ConsoleScriptManager();

$testCount = 4;
$properties = ['nullSetOnce', 'falseSetOnce', 'trueSetOnce'];
$valueToString = function ($value) {
    return match ($value) {
        null => 'null',
        false => 'false',
        true => 'true',
        default => 'unknown'
    };
};

foreach ($properties as $cmd) {
    echo "Property: $cmd => default (get): " . $valueToString($csm->$cmd) . PHP_EOL;
    for ($i = 1; $i <= $testCount; $i++) {
        $csm->$cmd = $new = $i == 1 ? $csm->randomPropertyValue() : !$new;
        echo "$i: Set: " . $valueToString($new) . ' => Get: ' . $valueToString($csm->$cmd) . PHP_EOL;
    }
}
