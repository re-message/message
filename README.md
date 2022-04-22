# Message Standard

This package defines the rules and formats for communication between clients and servers that are part of [Re: Message][1].

Standard based on JSON format and created to implement a [JSON-pure API][5]. This package uses the `symfony/serializer` for encoding and decoding JSON.

The `remessage/client` and `remessage/core` based on this standard.

## Requirements

PHP 8.1+ with these extensions:
1. json
1. mbstring

## Installation

You will need Composer to install:

`composer require remessage/message`

## Description

Message is any data sent as part of the server-client interaction. Any message **MUST** have a `type` high level property with the message type (see [Types](#types)).

### Transport

As a data transmission channel, HTTP or sockets can be used. See [Core documentation][2] for details.

When using the HTTP protocol, only action, response, error messages can be used.

### Types

There are several types of messages for communication. The main types of messages: action, response and error. These types of messages can be sent and received via any transport.

### Action

The Action message is a message, which is a request to perform some action and return its results as a [Response](#response). Action can be sent only from a client side.

Any action message **MUST** have a `name` and a `parameters` properties. The `name` property contains a name of action (e.g. `auth.sendCode`). The `parameters` property is a list of parameters for action.

Also, Action message can have these optional properties:
* `id` property: a random identifier for the Action message which **MUST** be returned in the [Response](#response) message if the identifier was sent
* `token` property: access token to this action (you can pass the token in [other ways][3])

Example:
```json
{
    "type": "action",
    "name": "auth.sendCode",
    "parameters": {
        "phone": "+79123456789",
        "requestId": "d0f2f571-d07d-4e1d-bdf6-e3470efe9ac5",
        "code": "012345"
    }
}
```

### Response

The Response message is a message returned as the result of the [Action](#action) if the action completed successfully. A message of this type **MUST** have a `content` property, that contains the results of action. Response can be sent only by the Core.

Also, Response message can have these optional properties:
* `id` property: an identifier from the Action message if the identifier was sent

Example:
```json
{
    "type": "response",
    "content": {
        "method": "sms",
        "requestId": "b4b12d26-8fd6-4d9f-aa2c-0e56ced951be",
        "expiredAt": 1587075673
    }
}
```

### Error

The Error message is the message returned if an error occurred while performing an action. The error message **MUST** have a `code` and `message` properties. The `code` property is a number code of error. The `message` property is a short description about error. A complete list of errors that may be thrown is available [here][4]. Error can be sent only by the Core.

Example:
```json
{
    "type": "error",
    "code": 51,
    "message": "One of the passed parameters is invalid."
}
```

[1]: https://remessage.ru
[2]: https://dev.remessage.ru/transport
[3]: https://dev.remessage.ru/auth
[4]: https://dev.remessage.ru/errors
[5]: https://mmikowski.github.io/json-pure/
