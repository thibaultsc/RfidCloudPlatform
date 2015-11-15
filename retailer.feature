Feature: Manage retailers
  In order to manage retailers
  As an API user
  I need to be able to create, retrieve, update and disable a retailer

  @createSchema
  Scenario: Create a retailer
    Given I am authenticated
    When I send a "POST" request to "/api/retailers" with body:
    """
    {
      "name": "My Retailer",
      "enabled": true
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "name" should be equal to "My Retailer"

  Scenario: Retrieve a retailer
    When I send a "GET" request to "/api/retailers/1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "name" should be equal to "My Retailer"
    And the JSON node "enabled" should be equal to "true"

  @dropSchema
  Scenario: Update and disable a retailer
    When I send a "PUT" request to "/api/retailers/1" with body:
    """
    {
      "name": "Another Retailer",
      "enabled": false
    }
    """
    Then the response status code should be 202
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "name" should be equal to "Another Retailer"
    And the JSON node "enabled" should be equal to "0"
