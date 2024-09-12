# Public Frontend (Nuxt.js SSR Application)

Nuxt is a framework for server-side rendering (SSR) Vue.js applications. It simplifies the development of universal or isomorphic web applications, providing SEO benefits and improved performance.

## Development Server

For the Nuxt Public SSR app build start the node container by running:

```shell
docker exec -it node /bin/bash
```

Then in folder within the node container **server/client/public** run the following commands:

```shell
npm install && npm run dev
```

## Production

Build the application for production:

```bash
npm install && npm run build
```
