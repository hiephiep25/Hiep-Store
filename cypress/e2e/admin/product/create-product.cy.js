/// <reference types="cypress" />

Cypress.Commands.add("forceLogout", () => {
  cy.visit("/admin/logout"); // Adjust this to your actual logout route
});

describe("Create Product Test", () => {
  beforeEach(() => {
    // Force logout before each test to ensure a clean state
    cy.forceLogout();
    // Visit the login page
    cy.visit("/admin/login");
    // Perform login
    cy.get("#email-input").type(Cypress.env("CYPRESS_SUPER_ADMIN_ACCOUNT"));
    cy.get("#password-input").type(Cypress.env("CYPRESS_SUPER_ADMIN_PASSWORD"));
    cy.get("#login-form").submit();
    // Ensure login was successful
    cy.url().should("eq", Cypress.config("baseUrl") + "admin/");
  });

  it("should create a new product", () => {
    // Visit the products page
    cy.visit("/admin/products");
    cy.get("#create-new-product-button").click();

    // Fill in the product creation form
    cy.get("#name").type("Test Product");
    cy.get("#code").type("TEST123");
    cy.get("#brand").type("Test Brand");
    cy.get("#category_id").click();
    cy.get('.q-menu', { timeout: 20000 }).should('be.visible');
    cy.get('.q-item').contains('Hoa quả').click();
    cy.get("#description").type("This is a test product.");
    cy.get("#qty").type("10");
    cy.get("#price_per_qty").type("100");
    cy.get("#manufacture_day").type("2024-01-01");
    cy.get("#expiry_day").type("2025-01-01");

    // Upload an image file
    cy.get("#image").attachFile("kei.png");

    // Submit the form
    cy.get("#submit").click();
    cy.get("#error").should("not.exist");
  });
});
