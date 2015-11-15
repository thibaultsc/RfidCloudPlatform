Feature: Authenticate an user
  In order to use the API
  As an API user
  I must be authenticated

  @createSchema
  Scenario: Deny access to unauthenticated user
    When I send a "GET" request to "/api/"
    Then the response status code should be 401

  Scenario: Authenticate
    Given A user "test" with password "p4ssw0rd" exists
    When I send a "POST" request to "/api/login_check" with parameters:
      | key      | value    |
      | username | test     |
      | password | p4ssw0rd |
    Then the response should be in JSON
    And the JSON node "token" should exist

  Scenario: Access protected resource
    Given I am authenticated
    When I send a "GET" request to "/api/"
    Then the response status code should be 200

  @dropSchema
  Scenario: Access another protected resource
    When I send a "GET" request to "/api/retailers"
    Then the response status code should be 200
