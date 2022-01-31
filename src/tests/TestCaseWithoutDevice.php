<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCaseWithoutDevice extends BaseTestCase
{
  use CreatesApplication;

  protected $basepath;
  protected $endpoint;

  public function __construct()
  {
    parent::__construct();
    $this->basepath = '/api/v1/';
  }

  protected function getBaseURL(): string
  {
    return $this->basepath.$this->endpoint;
  }

  protected function getURL($path): string
  {
    return $this->basepath.$path;
  }

  protected function setEndpoint(string $endpoint)
  {
    $this->endpoint = $endpoint;
  }
}
