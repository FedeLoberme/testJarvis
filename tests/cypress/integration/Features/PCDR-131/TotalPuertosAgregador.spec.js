// TotalPuertosAgregador.spec.js created with Cypress
//
// Start writing your Cypress tests below!
// If you're unfamiliar with how Cypress works,
// check out the link below and learn how to write your first test:
// https://on.cypress.io/writing-first-test
import { When, Given, Then, And } from "cypress-cucumber-preprocessor/steps";

let Q_ten_agg, Q_giga_agg, var_temp1, var_temp2;

Given("Al ingresar en la pantalla de Dasboard", () => {
    cy.login();
});

When("Exista mas de {int} agregadores en estado crítico", (arg0) => {
    cy.get(
        "#page-wrapper > div.wrapper.wrapper-content.animated.fadeInRight > div.offset-md-3.wrapper.wrapper-content > div > div:nth-child(2) > div:nth-child(4) > a > div > div > div.col-xs-9.text-right > h2 > span"
    )
        .invoke("text")
        .then((text) => {
            Q_ten_agg = text;
            cy.log(text);
        });

    cy.get(
        "  #page-wrapper > div.wrapper.wrapper-content.animated.fadeInRight > div.offset-md-3.wrapper.wrapper-content > div > div:nth-child(2) > div:nth-child(5) > a > div > div > div.col-xs-9.text-right > h2 > span"
    )
        .invoke("text")
        .then((text) => {
            Q_giga_agg = text;
            cy.log(text);
        });
    var_temp1 = arg0;
});

Then("Se visualiza el control con color Rojo", () => {
    cy.log("verifica Agregadores Tengiga");

    if (Q_ten_agg >= var_temp1) {
        cy.get(
            "#page-wrapper > div.wrapper.wrapper-content.animated.fadeInRight > div.offset-md-3.wrapper.wrapper-content > div > div:nth-child(2) > div:nth-child(4) > a > div"
        ).should("have.attr", "class", "widget style1 red-bg");
    }
    cy.log("verifica Agregadores Giga");
    if (Q_giga_agg >= var_temp1) {
        cy.get(
            "#page-wrapper > div.wrapper.wrapper-content.animated.fadeInRight > div.offset-md-3.wrapper.wrapper-content > div > div:nth-child(2) > div:nth-child(5) > a > div"
        ).should("have.attr", "class", "widget style1 red-bg");
    }
});

When(
    "Exista entre {int} y {int} agregadores en estado crítico",
    (arg0, arg1) => {
        var_temp1 = arg0;
        var_temp2 = arg1;
    }
);

Then("Se visualiza el control con color amarillo", () => {
    //yellow-bg
    cy.log("verifica Agregadores Tengiga");

    if (Q_ten_agg >= var_temp1 && Q_ten_agg <= var_temp2) {
        cy.get(
            "#page-wrapper > div.wrapper.wrapper-content.animated.fadeInRight > div.offset-md-3.wrapper.wrapper-content > div > div:nth-child(2) > div:nth-child(4) > a > div"
        ).should("have.attr", "class", "widget style1 yellow-bg");
    }
    cy.log("verifica Agregadores Giga");
    if (Q_giga_agg >= var_temp1 && Q_giga_agg <= var_temp2) {
        cy.get(
            "#page-wrapper > div.wrapper.wrapper-content.animated.fadeInRight > div.offset-md-3.wrapper.wrapper-content > div > div:nth-child(2) > div:nth-child(5) > a > div"
        ).should("have.attr", "class", "widget style1 yellow-bg");
    }
});

Then("Se visualiza el control con color verde", () => {
    cy.log("verifica Agregadores Tengiga");

    if (Q_ten_agg >= var_temp1 && Q_ten_agg <= var_temp2) {
        cy.get(
            "#page-wrapper > div.wrapper.wrapper-content.animated.fadeInRight > div.offset-md-3.wrapper.wrapper-content > div > div:nth-child(2) > div:nth-child(4) > a > div"
        ).should("have.attr", "class", "widget style1 navy-bg");
    }
    cy.log("verifica Agregadores Giga");
    if (Q_giga_agg >= var_temp1 && Q_giga_agg <= var_temp2) {
        cy.get(
            "#page-wrapper > div.wrapper.wrapper-content.animated.fadeInRight > div.offset-md-3.wrapper.wrapper-content > div > div:nth-child(2) > div:nth-child(5) > a > div"
        ).should("have.attr", "class", "widget style1 navy-bg");
    }
});

When("El usuario cliquea en el control", () => {
    cy.get(".red-bg .col-xs-9").click();
});

Then("Se visualiza el listado de ocupacion del agregador", () => {
    cy.get("#list_port_agg_wrapper").should("to.be.visible");
});

And(
    "Abierto Por Puerto Giga y Puerto Tengiga se visualizan total de puertos vacantes, Total de anillos vacantes, % Ocupación, Estado",
    () => {}
);
Given("Un usuario ingreso en el listado de ocupacion de agregadores", () => {
    cy.login();
});

When("El usuario visualiza el agregador {string}", (arg0) => {});

Then("El estado del agregador es {string}", (arg0) => {});

And("el % de ocupación es {int}", (arg0) => {});
