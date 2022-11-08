// Reservas.spec.js created with Cypress
//
// Start writing your Cypress tests below!
// If you're unfamiliar with how Cypress works,
// check out the link below and learn how to write your first test:
// https://on.cypress.io/writing-first-test
import { When, Given, Then } from "cypress-cucumber-preprocessor/steps";

Given("Un usuario ingresa en el Listado Reservas", () => {
    cy.login();
    cy.visit("/ver/reserva");
});

When("El usuario visualiza la lista de reservas", () => {
    return true;
});

Then("Se ven las columnas {string}", (val_columnas) => {
    cy.Validar_tabla(val_columnas, "#list_reserve > ", true);
});
