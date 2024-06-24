/// <reference types="cypress" />

Cypress.Commands.add("forceLogout", () => {
    cy.visit("/admin/logout"); // Adjust this to your actual logout route
  });
  
  describe("Create Discount Test", () => {
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
  
    it("should create a new discount", () => {
      // Visit the products page
      cy.visit("/admin/discounts");
      cy.get("#create-new").click();
  
      // Fill in the product creation form
      cy.get("#name").type("Test Discount");
      cy.get("#code").type("TEST123");
      cy.get("#value").type("50");
      cy.get("#description").type("This is a test discount.");
      cy.get("#start_date").type("2024-01-01");
      cy.get("#expiration_date").type("2024-01-02");
  
      // Submit the form
      cy.get("#submit").click();
      cy.get("#error").should("not.exist");
    });
  });
  