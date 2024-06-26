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
      cy.get("#description").type("This is a test discount.");
      cy.get("#start").type("2024-01-01T08:30");
      cy.get("#end").type("2024-01-02T10:30");
      cy.get("#image").attachFile("kei.png");
  
      // Submit the form
      cy.get("#submit").click();
      cy.get("#error").should("not.exist");
    });
  });
  