/// <reference types="cypress" />

describe("Login Test", () => {
  beforeEach(() => {
    cy.forceLogout();
    // Visit the login page
    cy.visit("/admin/login");
  });

  it("should display login form and perform login", () => {
    // Fill in the email
    cy.get("#email-input").type(Cypress.env("CYPRESS_SUPER_ADMIN_ACCOUNT"));

    // Fill in the password
    cy.get("#password-input").type(Cypress.env("CYPRESS_SUPER_ADMIN_PASSWORD"));

    // Submit the form
    cy.get("#login-form").submit();

    // Check for successful login redirection
    cy.url().should("eq", Cypress.config("baseUrl") + "admin/");
  });

  it("should show error on invalid login", () => {
    // Fill in the email
    cy.get("#email-input").type("wrong-email@example.com");

    // Fill in the password
    cy.get("#password-input").type("wrongpassword");

    // Submit the form
    cy.get("#login-form").submit();

    // Check for error message
    cy.get(".text-red").should("contain", "Sai thông tin đăng nhập");
  });
});
