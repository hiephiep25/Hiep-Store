import { defineConfig } from "cypress";

export default defineConfig({
  e2e: {
    setupNodeEvents(on, config) {
      // implement node event listeners here
      config.specPattern = [
        // "cypress/e2e/admin/login.cy.js",
        "cypress/e2e/admin/product/create-product.cy.js",
      ]
      return config
    },
    defaultCommandTimeout: 15000,
    chromeWebSecurity: false,
    slowTestThreshold: 20000,
    baseUrl: 'http://127.0.0.1:8000/',
  },
  env: {
    CYPRESS_SUPER_ADMIN_ACCOUNT: 'admin@gmail.com',
    CYPRESS_SUPER_ADMIN_PASSWORD: '25052002',
  },
  viewportWidth: 1920,
  viewportHeight: 1080,
  waitForAnimations: true,
  trashAssetsBeforeRuns: true,
  video: true,
  videoCompression: false,
  screenshotOnRunFailure: false,
  watchForFileChanges: true,
  retries: {
    runMode: 2,
    openMode: 0
  }
});
