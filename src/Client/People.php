<?php

namespace SDK\Client;

use SDK\Core\Client\API;
use SDK\Exception\FCClientException;

class People
{
  /**
   * API Service
   *
   * @var API
   */
  private $api;

  public function __construct(API $api)
  {
    $this->api = $api;
  }

  public function getMe(): ?object
  {
    try {

      $response = $this->api->private('GET', '/people/me');

      if ($response->getStatusCode() === 200) {
        $result = json_decode($response->getBody());

        if (isset($result->response)) {
          if ($result->response->success === false)
            throw new FCClientException($result->response->error);

          return $result->response->data;
        }
      }

      return null;
    } catch (\Exception $e) {
      if ($e instanceof FCClientException)
        throw new \Exception($e->getMessage());

      return null;
    }
  }

  public function createCustomer(array $data): ?int
  {
    try {

      $response = $this->api->private('POST', '/people/customer', ['json' => $data]);

      if ($response->getStatusCode() === 200) {
        $result = json_decode($response->getBody());

        if (isset($result->response)) {
          if ($result->response->success === false)
            throw new FCClientException($result->response->error);

          return $result->response->data->peopleId;
        }
      }

      return null;

    } catch (\Exception $e) {
      if ($e instanceof FCClientException)
        throw new \Exception($e->getMessage());

      return null;
    }
  }

  public function getIdByEmail(string $email): ?int
  {
    try {

      $response = $this->api->private('GET', sprintf('/email/find?email=%s', $email));

      if ($response->getStatusCode() === 200) {
        $result = json_decode($response->getBody());

        if (isset($result->response)) {
          if ($result->response->success === false)
            throw new FCClientException($result->response->error);

          return $result->response->data->people_id;
        }
      }

      return null;

    } catch (\Exception $e) {
      if ($e instanceof FCClientException)
        throw new \Exception($e->getMessage());

      return null;
    }
  }
}
