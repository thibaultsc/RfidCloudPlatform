Feature: Manage users
  In order to access the API
  As an API user
  I need to be able to create and use a user account

  @createSchema
  Scenario: Create the retailer "Retailer #1"
    Given I am authenticated
    When I send a "POST" request to "/api/retailers" with body:
    """
    {
      "name": "Retailer #1"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "name" should be equal to "Retailer #1"

  Scenario: Create the retailer "Retailer #2"
    When I send a "POST" request to "/api/retailers" with body:
    """
    {
      "name": "Retailer #2"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "name" should be equal to "Retailer #2"

  Scenario: Create an user
    When I send a "POST" request to "/api/users" with body:
    """
    {
      "username": "tibo",
      "email": "thibaultsc@gmail.com",
      "enabled": true,
      "plainPassword": "test",
      "retailers": [
        "/api/retailers/1",
        "/api/retailers/2"
      ],
      "roles": [
        "ROLE_USER"
      ]
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@id" should be equal to "/api/users/2"
    And the JSON node "username" should be equal to "kevin"
    And the JSON node "email" should be equal to "kevin@les-tilleuls.coop"
    And the JSON node "enabled" should be equal to "true"
    And the JSON node "retailers[0]" should be equal to "/api/retailers/1"
    And the JSON node "retailers[1]" should be equal to "/api/retailers/2"
    And the JSON node "roles[0]" should be equal to "ROLE_USER"

  Scenario: Retrieve an user
    When I send a "GET" request to "/api/users/2"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "username" should be equal to "tibo"
    And the JSON node "email" should be equal to "thibaultsc@gmail.com"
    And the JSON node "enabled" should be equal to "true"
    And the JSON node "retailers[0]" should be equal to "/api/retailers/1"
    And the JSON node "retailers[1]" should be equal to "/api/retailers/2"
    And the JSON node "roles[0]" should be equal to "ROLE_USER"

  @dropSchema
  Scenario: Update an user
    When I send a "PUT" request to "/api/users/2" with body:
    """
    {
      "username": "JeNeSuisPlusTibo",
      "email": "thibaultsc@gmail.com",
      "enabled": false,
      "plainPassword": "NouveauMotDePasse",
      "retailers": [
        "/api/retailers/2"
      ],
      "roles": [
        "ROLE_SUPER_ADMIN"
      ]
    }
    """
    Then the response status code should be 202
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "username" should be equal to "JeNeSuisPlusTibo"
    And the JSON node "email" should be equal to "thibaultsc@gmail.com"
    And the JSON node "enabled" should be equal to "0"
    And the JSON node "retailers[0]" should be equal to "/api/retailers/2"
    And the JSON node "retailers[1]" should not exist
    And the JSON node "roles[0]" should be equal to "ROLE_SUPER_ADMIN"