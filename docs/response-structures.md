# Response

## JSON Response Structures

A document MUST contain at least one of the following top-level members:

data: the document’s “primary data”
errors: an array of error objects
meta: a meta object that contains non-standard meta-information.
The members data and errors MUST NOT coexist in the same document.

A document MAY contain any of these top-level members:

jsonapi: an object describing the server’s implementation
links: a links object related to the primary data.
included: an array of resource objects that are related to the primary data and/or each other (“included resources”).

The top-level links object MAY contain the following members:

self: the link that generated the current response document.
related: a related resource link when the primary data represents a resource relationship.
pagination links for the primary data.

data: can always be an array of multiple documents or a single document (not in an array)

See: <https://jsonapi.org/format/#document-structure>

### Simple Singular Example
**Success Example**

```json
{
  "data": {
    "type": "articles",
    "id": "1",
    "attributes": {
      "title": "Cool Article"
    },
    "relationships": {
      "author": {
        "links": {
          "self": "/articles/1/relationships/author",
          "related": "/articles/1/author"
        },
        "data": { 
          "type": "people", 
          "id": "9"
        }
      }
    }
  },
  "meta": {
    "copyright": "Copyright 2015 Example Corp.",
    "count": 127
  }
}
```

**Errors Example**
```json
{
  "errors": [
    {
      "id": 63245,
      "status": 500,
      "code": "Server Error",
      "title": "You do not have permission to request this data.",
      "detail": "Please contact the administrator to get permission to access this data.",
      "meta": {
        "required_permission": "moderator"
      }
    }
  ]
}
```

### Simple Multiple/Collection Examples
```json
{
  "data":[
    {
      "type":"articles",
      "id":"1",
      "attributes":{
        "title":"Cool Article"
      },
      "relationships":{
        "author":{
          "links":{
            "self":"/articles/1/relationships/author",
            "related":"/articles/1/author"
          },
          "data":{
            "type":"people",
            "id":"9"
          }
        }
      }
    },
    {
      "type":"articles",
      "id":"2",
      "attributes":{
        "title":"Another Article"
      },
      "relationships":{
        "author":{
          "links":{
            "self":"/articles/2/relationships/author",
            "related":"/articles/2/author"
          },
          "data":{
            "type":"people",
            "id":"51"
          }
        }
      }
    }
  ],
  "meta":{
    "copyright":"Copyright 2015 Example Corp.",
    "count":94
  }
}
```

**With Pagination: (should always be in the meta)**
Number: is the requested page number
Size: is the requested amount of objects per page
Total: is the total number of pages available for the given set
Count: is the total number of objects available for the given set

When the current page is 5:
```json
{
  "data":[
    ...
  ],
  "links": {
    "first": "/articles?page[number]=1&page[size]=10",
    "last": "/articles?page[number]=17&page[size]=10",
    "prev": "/articles?page[number]=3&page[size]=10",
    "next": "/articles?page[number]=5&page[size]=10"
  },
  "meta":{
    "page": {
      "number": 3,
      "size": 10,
      "total": 12
    },
    "count": 94
  }
}
```

## Using The Package
Creating a response:
```php
public function myControllerMethod() {
    return 
}
```