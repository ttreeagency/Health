# Health Monitoring for Flow Framework or Neos CMS

_Package in development, not ready for production_

## Features

- [x] Create endpoints to display your application health status
- [x] API to create multiple health status endpoints
- [x] API to create custom check
- [x] Implement a health check for Database monitoring
- [x] Implement a health check for ElasticSearch monitoring
- [x] Implement a health check for Redis monitoring
- [ ] Create endpoints to display your application metrics (promotheus)
- [ ] API to create multiple metrics endpoints
- [ ] API to create custom metrics
- [ ] Implement a metrics for the number of node in the CR, for live workspace
- [ ] Implement a metrics for the number of node in the CR, for non live workspaces
- [ ] Implement a metrics for database size
- [ ] Implement a metrics for elasticsearch indexes size
- [ ] Implement a metrics for asset disk usage


## How to create custom status endpoints ?

In your `Settings.yaml`:

### Preset definition

```yaml

Ttree:
  Health:
    presets:
      default:
        checks:
          database:
            class: Ttree\Health\Check\DatabaseCheck
          elasticsearch:
            class: Ttree\Health\Check\ElasticSearchCheck
          newsletterSender:
            class: Ttree\Health\Check\NewsletterSenderCheck
            
```

### Routing configuration

Then you can create your routing configuration, in your `Routes.yaml`:

```yaml

-
  name: 'health - monitoring endpoint'
  uriPattern: 'health'
  defaults:
    '@package':    'Ttree.Health'
    '@controller': 'Monitoring'
    '@action':     'index'
    '@format':     'json'
    'preset':      'default'
  appendExceedingArguments: true
  httpMethods: [GET]
  
```

The response should be something like this:

```json
{
  "endpoint": "default",
  "success": {
    "count": 1,
    "message": {
      "database": {
        "status": "Success",
        "message": "Database access works"
      }
    }
  },
  "warnings": {
    "count": 1,
    "message": {
      "elasticsearch": {
        "status": "Warning",
        "message": "ElasticSearchCheck is not in green state"
      }
    }
  },
  "errors": {
    "count": 1,
    "message": {
      "newsletterSender": {
        "status": "Error",
        "message": "Newsletter Sender is down"
      }
    }
  }
}
``` 

The response status is `200` if there is not errors and warnings.

## How to create custom check ?

Your custom check must implement `Ttree\Health\Check\CheckInterface`. The response of the `run` method must return an
instance of `Ttree\Health\Result\ResultInterface`. You can use the builtin `ErrorResult`, `WarningResult` and `SuccessResult`. 

_Currently the provided check contains "dummy" code. Real implementation will be done later when the architecture of the
package is finished._

## How to create custom metrics endpoints ?

TODO

## Sponsors & Contributors

The development of this package is sponsored by ttree (https://ttree.ch).
