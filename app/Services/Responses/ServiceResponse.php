<?php

namespace App\Services\Responses;

class ServiceResponse
{
    /**
     * @var bool
     */
    public $success;

    /**
     * @var string
     */
    public $message;

    /**
     * @var mixed
     */
    public $data;

    /**
     * @param bool   $success
     * @param string $message
     * @param mixed  $data
     */
    public function __construct(
        bool $success,
        string $message,
        $data = null
    ) {
        $this->success        = $success;
        $this->message        = $message;
        $this->data           = $data;
    }

    /**
     * Returns the properties of this class in array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'success'        => $this->success,
            'message'        => $this->message,
            'data'           => $this->data,
        ];
    }
}
