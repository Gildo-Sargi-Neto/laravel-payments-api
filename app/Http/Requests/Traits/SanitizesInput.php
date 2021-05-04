<?php

namespace App\Http\Requests\Traits;

use Sanitizer;

trait SanitizesInput
{
    /**
     *  Sanitize input before validating.
     *
     *  @return void
     */
    public function validateResolved()
    {
        $filters = $this->filters();

        if ($this->hasBefore()) {
            $this->sanitize($filters['before']);
        }

        parent::validateResolved();

        if ($this->hasAfter()) {
            $this->sanitize($filters['after']);
        }

        if (!$this->hasAfter() && !$this->hasBefore()) {
            $this->sanitize($filters);
        }
    }

    private function hasBefore()
    {
        $filters = $this->filters();

        return key_exists('before', $filters) && is_array($filters['before']);
    }

    private function hasAfter()
    {
        $filters = $this->filters();

        return key_exists('after', $filters) && is_array($filters['after']);
    }

    /**
     *  Sanitize this request's input
     *
     *  @return void
     */
    public function sanitize($filters)
    {
        $this->sanitizer = Sanitizer::make($this->input(), $filters);

        $keysBefore = array_keys($this->all());

        $sanitizedInputs = $this->sanitizer->sanitize();

        $result = [];

        foreach ($keysBefore as $key) {
            $result[$key] = $sanitizedInputs[$key];
        }

        $this->replace($result);
    }

    /**
     *  Filters to be applied to the input.
     *
     *  @return void
     */
    public function filters()
    {
        return [];
    }
}
