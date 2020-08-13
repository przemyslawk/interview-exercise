<?php

declare(strict_types=1);

namespace AppJobs\Entities\Requirements;

class Entity implements RequirementInterface
{
    /** @var string */
    private $condition;

    /**
     * Entity constructor.
     * @param $condition
     */
    public function __construct(string $condition)
    {
        $this->condition = $condition;
    }

    /**
     * @param array $assets
     * @return bool
     */
    public function isValid(array $assets) : bool
    {
        if ($this->condition === '') {
            return true;
        }

        return (bool)in_array($this->condition, $assets);
    }
}
