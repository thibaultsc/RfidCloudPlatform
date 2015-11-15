Feature: Manage Duraltags
  In order to use Duraltags
  As an API user
  I need to be able to create and retrieve Duraltags

  @createSchema
  Scenario: Create a retailer
    Given I am authenticated
    When I send a "POST" request to "/api/retailers" with body:
    """
    {
      "name": "My Retailer"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "name" should be equal to "My Retailer"

  Scenario: Create a Duraltag
    When I send a "POST" request to "/api/duraltags" with body:
    """
    {
      "qrCode": "1234",
      "rfid": "5678",
      "type": 2,
      "retailer": "/api/retailers/1"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@id" should be equal to "/api/duraltags/1"
    And the JSON node "qrCode" should be equal to "1234"
    And the JSON node "rfid" should be equal to "5678"
    And the JSON node "type" should be equal to "2"
    And the JSON node "retailer" should be equal to "/api/retailers/1"

  Scenario: Create a Duraltag with a slash in the QR code
    When I send a "POST" request to "/api/duraltags" with body:
    """
    {
      "qrCode": "1/234",
      "rfid": "5670",
      "type": 3,
      "retailer": "/api/retailers/1"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@id" should be equal to "/api/duraltags/2"
    And the JSON node "qrCode" should be equal to "1/234"
    And the JSON node "rfid" should be equal to "5670"
    And the JSON node "type" should be equal to "3"
    And the JSON node "retailer" should be equal to "/api/retailers/1"

  Scenario: Retrieve a Duraltag
    When I send a "GET" request to "/api/duraltags/1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@id" should be equal to "/api/duraltags/1"
    And the JSON node "qrCode" should be equal to "1234"
    And the JSON node "rfid" should be equal to "5678"
    And the JSON node "type" should be equal to "2"
    And the JSON node "retailer" should be equal to "/api/retailers/1"

  Scenario: Retrieve a Duraltag
    When I send a "GET" request to "/api/duraltags/1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "qrCode" should be equal to "1234"
    And the JSON node "rfid" should be equal to "5678"
    And the JSON node "type" should be equal to 2
    And the JSON node "retailer" should be equal to "/api/retailers/1"

  Scenario: Create an item association
    When I send a "POST" request to "/api/item_associations" with body:
    """
    {
      "ean": "ABC",
      "status": 1,
      "enabled": true,
      "duraltag": "/api/duraltags/1"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@id" should be equal to "/api/item_associations/1"
    And the JSON node "ean" should be equal to "ABC"
    And the JSON node "status" should be equal to 1
    And the JSON node "enabled" should be equal to 1
    And the JSON node "duraltag" should be equal to "/api/duraltags/1"

  Scenario: Create an item association giving the Duraltag's RFID
    When I send a "POST" request to "/api/item_associations" with body:
    """
    {
      "ean": "DEF",
      "status": 2,
      "enabled": true,
      "rfid": "5678"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@id" should be equal to "/api/item_associations/2"
    And the JSON node "ean" should be equal to "DEF"
    And the JSON node "status" should be equal to 2
    And the JSON node "enabled" should be equal to 1
    And the JSON node "duraltag" should be equal to "/api/duraltags/1"

  Scenario: Create an item association giving the Duraltag's QR code
    When I send a "POST" request to "/api/item_associations" with body:
    """
    {
      "ean": "ABC",
      "status": 4,
      "enabled": true,
      "qrCode": "1234"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@id" should be equal to "/api/item_associations/3"
    And the JSON node "ean" should be equal to "ABC"
    And the JSON node "status" should be equal to "4"
    And the JSON node "enabled" should be equal to 1
    And the JSON node "duraltag" should be equal to "/api/duraltags/1"

  Scenario: Retrieve an item association
    When I send a "GET" request to "/api/item_associations/1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@id" should be equal to "/api/item_associations/1"
    And the JSON node "ean" should be equal to "ABC"
    And the JSON node "status" should be equal to "1"
    And the JSON node "enabled" should be equal to 0
    And the JSON node "duraltag" should be equal to "/api/duraltags/1"

  Scenario: Update an item association by QR code
    When I send a "PUT" request to "/api/item_associations/qrCode/1234" with body:
    """
    {
      "ean": "ABC",
      "status": 2,
      "enabled": true
    }
    """
    Then the response status code should be 202
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@id" should be equal to "/api/item_associations/3"
    And the JSON node "ean" should be equal to "ABC"
    And the JSON node "status" should be equal to 2
    And the JSON node "enabled" should be equal to 1
    And the JSON node "duraltag" should be equal to "/api/duraltags/1"

  Scenario: Update an item association by RFID
    When I send a "PUT" request to "/api/item_associations/rfid/5678" with body:
    """
    {
      "ean": "ABC",
      "status": 3,
      "enabled": true
    }
    """
    Then the response status code should be 202
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@id" should be equal to "/api/item_associations/3"
    And the JSON node "ean" should be equal to "ABC"
    And the JSON node "status" should be equal to 3
    And the JSON node "enabled" should be equal to 1
    And the JSON node "duraltag" should be equal to "/api/duraltags/1"

  Scenario: Create an item association with a QR code including a slash
    When I send a "POST" request to "/api/item_associations" with body:
    """
    {
      "ean": "ABC",
      "status": 4,
      "enabled": true,
      "qrCode": "1/234"
    }
    """
    Then the response status code should be 201
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@id" should be equal to "/api/item_associations/4"
    And the JSON node "ean" should be equal to "ABC"
    And the JSON node "status" should be equal to "4"
    And the JSON node "enabled" should be equal to 1
    And the JSON node "duraltag" should be equal to "/api/duraltags/2"

  Scenario: Update an item association with a QR code including a slash
    When I send a "PUT" request to "/api/item_associations/qrCode/1/234" with body:
    """
    {
      "ean": "ABC",
      "status": 4,
      "enabled": true
    }
    """
    Then the response status code should be 202
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"
    And the JSON node "@id" should be equal to "/api/item_associations/4"
    And the JSON node "ean" should be equal to "ABC"
    And the JSON node "status" should be equal to "4"
    And the JSON node "enabled" should be equal to 1
    And the JSON node "duraltag" should be equal to "/api/duraltags/2"

  Scenario: Delete a Duraltag
    When I send a "DELETE" request to "/api/item_associations/1"
    Then the response status code should be 204

  Scenario: Create Duraltags by url in batch
    When I send a "POST" request to "/api/batch/duraltags" with body:
    """
    [
    {
      "qrCode": "QRCODE",
      "rfid": "RFID",
      "type": 2,
      "retailer": "/api/retailers/1"
    },
    {
      "qrCode": "QRCODE",
      "rfid": "RFID",
      "type": 2,
      "retailer": "/api/retailers/1"
    },
    {
      "qrCode": "QRCODE",
      "rfid": "RFID",
      "type": 2,
      "retailer": "/api/retailers/1"
    }
    ]
    """
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"

  Scenario: Create Item Associations by url in batch
    When I send a "POST" request to "/api/batch/item_associations" with body:
    """
     [
     {
      "ean": "ABC",
      "status": 4,
      "enabled": true,
      "qrCode": "1234"
    },
    {
      "ean": "ABCD",
      "status": 4,
      "enabled": true,
      "rfid": "2345"
    },
    {
      "ean": "ABC",
      "status": 4,
      "enabled": true,
      "qrCode": "QRCODE"
    },
    {
      "ean": "ABC",
      "status": 1,
      "enabled": true,
      "rfid": "RFID"
    },
    {
      "ean": "ABC",
      "status": 1,
      "enabled": true,
      "rfid": "RFID"
    }
    ]
    """
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/ld+json"

  Scenario: Create Item Associations by url in batch in CSV
    When I send a "POST" request to "/api/batch/item_associations/csv" with body:
    """
    ean,status,enabled,qrCode,rfid
    EAN,4,true,56783436,
    EAN,3,true,,4543
    EAN,4,true,56789886,
    """
    Then the response status code should be 200
    And the response should be in JSON

  @dropSchema
  Scenario: Delete a Duraltag
    When I send a "DELETE" request to "/api/duraltags/1"
    Then the response status code should be 204