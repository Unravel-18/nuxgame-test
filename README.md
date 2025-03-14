## 🍬 Stack includes

* API
  * Laravel
  * PHP-FPM
  * MySQL (and separate database for testing)
  * Redis
  * MailHog
* Gateway
  * Nginx (as reverse-proxy)
  * Certbot

## 📜 Introduction

The project is just separate pre-configured Laravel and Nuxt applications that are stored in the same [monorepo](https://en.wikipedia.org/wiki/Monorepo).

Each app has its docker templates for development and production and does not have the actual application code.
So you can install and run them completely separately from each other.
There are also no restrictions to adding more, for example, a mobile or an admin panel application.

## ⚙ Installation

### API

```bash
#Initialize App
cd api
make env.dev
make bup

#Initialize DB
make db.migrate

#Bash
make bash
```

This will build and run api application server on host `http://localhost:8000`.


### Gateway (optional)

#### Single host

If you want to host API and client apps on the single host machine, you may set up subdomains rather than rely on published ports.

The project includes a simple gateway application that can easily help with this.

It can also be useful to run locally and set up an application to use subdomains and test CORS and other possible issues.

If you want to deploy your project using the "single host" approach, install the `gateway` application according to [its documentation](./gateway/README.md).
For local development you can ignore it completely.

## 🔌 Network communication

API and WEB requests sent by the browser are proxied directly via published ports to the running server instances.

But the SSR request is sent by the node server, not the browser, and should be sent directly to the host of the API docker service.

## Additional information

You also can modify your `hosts` file to include next lines:

```bash
127.0.0.1	api.example.local
127.0.0.1	example.local
```
Now you can access your API and client apps using these domains.

## 📑 Documentation

- [API](./api/README.md)
- [Gateway](./gateway/README.md)
