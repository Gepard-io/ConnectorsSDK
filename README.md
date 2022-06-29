# Connectors SDK for Gepard SaaS Platform

The **Connectors SDK** makes it easy for developers to create an integration with PIM, Marketplace or any custom source
of product content to deliver it into Gepard SaaS Platform for further processing.

## Glossary

**Connector** - a set of "commands" and "queries" with settings that defines how to access any external source to
retrieve and/or update data.

**Query** - a connector operation intended to retrieve data from external source and convert it to supported data
transfer object(s). Example: download products and convert them to save them on Gepard SaaS Platform.

**Command** - a connector operation intended to process data from payload, convert it and send to external source.
Example: upload products from Gepard SaaS Platform, convert them to save them in external system.

## Getting started

1. Create own connector definition class by extending `\GepardIO\ConnectorsSDK\Connector` class. If there are any
   settings that your connector require for its work - they should be defined and returned in `getSettings()` method.
   Examples of such "global" settings: credentials to access some API, API hostname, etc.

2. Create necessary query and/or command classes. Do not forget to add their class names to corresponding methods in
   connector (`getQueries()` and `getCommands()`).

3. Create GitHub repository with your integration and let us know that we can add new integration on our platform.

## Resources

* [Issues](https://github.com/Gepard-io/ConnectorsSDK/issues) - Report issues, submit pull requests, and get involved.
