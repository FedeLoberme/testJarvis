// AplicarReserva.spec.js created with Cypress
//
// Start writing your Cypress tests below!
// If you're unfamiliar with how Cypress works,
// check out the link below And learn how to write your first test:
// https://on.cypress.io/n-first-test
import {
    When,
    Given,
    Then,
    And,
    But,
} from "cypress-cucumber-preprocessor/steps";


Given(
    "Un ingeniero de Cliente ingreso dentro del menu de Admin celda -> Reservas",
    () => {
        cy.login();
    }
);

And("Consulto en una reserva de Upgrade en estado Vigente", () => {});

When("Cliquea en aplicar Reserva", () => {});

Then("El sistema marca la reserva como Asignada", () => {});

And("cambia el BW con el BW final a aplicar de la reserva.", () => {});

Given(
    "Un ingeniero de Cliente ingreso dentro del menu de Admin celda -> Reservas",
    () => {}
);

And(
    "Consulto en una reserva de Upgrade en estado  distinto a Vigente",
    () => {}
);
When("Intenta Cliquear en aplicar Reserva", () => {});

Then("Se muestra la reserva", () => {});

But("el boton de aplicar reserva no esta disponible.", () => {});
