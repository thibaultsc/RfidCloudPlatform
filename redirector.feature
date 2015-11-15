Feature: Manage Duraltags
  In order to use the redirector
  As an API user
  I need to be able to create redirect rule

  @createSchema
  Scenario: A non-existing QR code must redirect to a 404 error
    When I send a "GET" request to "/NONEXISTING"
    Then the response status code should be 404

  Scenario: Test that the retailer rule match without EAN associed
    When I send a "GET" request to "/QRCODE2"
    Then the response status code should be 404

  Scenario: Add a redirection rule for all Duraltags of a Retailer
    Given The database is populated with test data
    And I am authenticated
    When I send a "POST" request to "/api/redirect_rules" with body:
    """
    {
      "retailer": "/api/retailers/1",
      "url": "http://example.com/{qrCode}",
      "status": 1
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@context" should be equal to "/api/contexts/RedirectRule"
    And the JSON node "@id" should be equal to "/api/redirect_rules/1"
    And the JSON node "@type" should be equal to "RedirectRule"
    And the JSON node "ean" should be equal to 0
    And the JSON node "url" should be equal to "http://example.com/{qrCode}"
    And the JSON node "status" should be equal to 1
    And the JSON node "enabled" should be equal to true
    And the JSON node "retailer" should be equal to "/api/retailers/1"
    And the JSON node "duraltag" should be equal to 0

  Scenario: Test that the retailer rule match without EAN
    When I send a "HEAD" request to "/QRCODE2"
    Then the response status code should be 302
    And the header "Location" should be equal to "http://example.com/QRCODE2"

  Scenario: Test that the retailer rule match
    When I send a "HEAD" request to "/QRCODE"
    Then the response status code should be 302
    And the header "Location" should be equal to "http://example.com/QRCODE"

  Scenario: Test that a scan entry is added
    When I send a "GET" request to "/api/scans"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "hydra:member[0]" should exist
    And the JSON node "hydra:member[0].redirectRule.@id" should be equal to "/api/redirect_rules/1"
    And the JSON node "hydra:member[0].url" should be equal to "http://example.com/QRCODE"

  Scenario: Add a redirection rule for an EAN code
    When I send a "POST" request to "/api/redirect_rules" with body:
    """
    {
      "retailer": "/api/retailers/1",
      "ean": "EAN",
      "url": "http://example.com/{ean}",
      "status": 2
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@context" should be equal to "/api/contexts/RedirectRule"
    And the JSON node "@id" should be equal to "/api/redirect_rules/2"
    And the JSON node "@type" should be equal to "RedirectRule"
    And the JSON node "ean" should be equal to "EAN"
    And the JSON node "url" should be equal to "http://example.com/{ean}"
    And the JSON node "status" should be equal to 2
    And the JSON node "enabled" should be equal to true
    And the JSON node "retailer" should be equal to "/api/retailers/1"
    And the JSON node "duraltag" should be equal to 0

  Scenario: Test that the EAN rule match
    When I send a "HEAD" request to "/QRCODE"
    Then the response status code should be 302
    And the header "Location" should be equal to "http://example.com/EAN"

  Scenario: Test a redirect rule
    When I send a "GET" request to "/itnotexists"
    Then the response status code should be 404

  Scenario: Test that a scan entry is added
    When I send a "GET" request to "/api/scans"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "hydra:member[1]" should exist
    And the JSON node "hydra:member[0].redirectRule.@id" should be equal to "/api/redirect_rules/2"
    And the JSON node "hydra:member[0].url" should be equal to "http://example.com/EAN"

  Scenario: Add a redirection rule for a specific Duraltag
    When I send a "POST" request to "/api/redirect_rules" with body:
    """
    {
      "retailer": "/api/retailers/1",
      "duraltag": "/api/duraltags/1",
      "url": "http://example.com/{rfid}",
      "status": 3
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@context" should be equal to "/api/contexts/RedirectRule"
    And the JSON node "@id" should be equal to "/api/redirect_rules/3"
    And the JSON node "@type" should be equal to "RedirectRule"
    And the JSON node "ean" should be equal to 0
    And the JSON node "url" should be equal to "http://example.com/{rfid}"
    And the JSON node "status" should be equal to 3
    And the JSON node "enabled" should be equal to true
    And the JSON node "retailer" should be equal to "/api/retailers/1"
    And the JSON node "duraltag" should be equal to "/api/duraltags/1"

  Scenario: Test that the EAN rule match
    When I send a "HEAD" request to "/QRCODE"
    Then the response status code should be 302
    And the header "Location" should be equal to "http://example.com/RFID"

  Scenario: Test that a scan entry is added
    When I send a "GET" request to "/api/scans"
    Then the response status code should be 200
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "hydra:member[2]" should exist
    And the JSON node "hydra:member[0].redirectRule.@id" should be equal to "/api/redirect_rules/3"
    And the JSON node "hydra:member[0].url" should be equal to "http://example.com/RFID"

  @dropSchema
  Scenario: Add an invalid rule
    When I send a "POST" request to "/api/redirect_rules" with body:
    """
    {
      "retailer": "/api/retailers/1",
      "duraltag": "/api/duraltags/1",
      "ean": "EAN",
      "url": "http://example.com/bad",
      "status": 3
    }
    """
    Then the JSON should be equal to:
    """
    {
      "@context": "/api/contexts/ConstraintViolationList",
      "@type": "ConstraintViolationList",
      "hydra:title": "An error occurred",
      "hydra:description": "\"ean\" and \"duraltag\" properties cannot be set together.\n",
      "violations": [
        {
          "propertyPath": "",
          "message": "\"ean\" and \"duraltag\" properties cannot be set together."
        }
      ]
    }
    """
