
  const { createProxyMiddleware } = require("http-proxy-middleware");

  module.exports = {
    // First middleware: Set Cache-Control headers
    function (req, res, next) {
      res.setHeader("Cache-Control", "no-cache, no-store, must-revalidate");
      res.setHeader("Pragma", "no-cache");
      res.setHeader("Expires", "0");
      next();
    },
    // Use the 'middleware' option to create a proxy that masks the deep URL.
    middleware: [
      // This middleware intercepts requests to the root and proxies them to the deep path.
      createProxyMiddleware("/", {
        target:
          "http://localhost/projects/create-prisma-php-app/sqlite-support/",
        changeOrigin: true,
        pathRewrite: {
          "^/": "/projects/create-prisma-php-app/sqlite-support/", // Rewrite the path.
        },
      }),
    ],
    proxy: "http://localhost:3000", // Proxy the BrowserSync server.
    files: "src/**/*.*",
    notify: false,
    open: false,
    ghostMode: false,
  };