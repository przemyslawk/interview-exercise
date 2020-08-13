<?php namespace AppJobs\Entities\Requirements;

interface RequirementInterface
{
    public function isValid(array $assets) : bool;
}
