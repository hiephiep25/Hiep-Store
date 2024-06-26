/// <reference types="cypress" />

Cypress.Commands.add("forceLogout", () => {
    cy.visit("/admin/logout"); // Adjust this to your actual logout route
  });
  
  describe("Export Test", () => {
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
  
    it("should export", () => {
      // Visit the products page
      cy.visit("/admin/shops");
  
      // Fill in the product creation form
      cy.get('#code').click();
      cy.get('.q-item').first().click();
      cy.get("#add").type("10");
      cy.get("#export").click();
    });
  });
  