import { When, Given, Then } from "cypress-cucumber-preprocessor/steps";
Given(/^Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú asociación agregadores.$/, () => {
	cy.login();
    cy.visit("/ver/asociacion/agg");

});

When(/^El usuario ingresa en la pantalla$/, () => {
	return true;
});

Then("El sistema muestra la lista con los campos {string}", (args1) => {
	console.log(args1);
    cy.Validar_tabla(args1, "#agg_assoc_table > ", true);
    cy.screenshot();
});

Given(/^Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú asociación agregadores.$/, () => {
    cy.login();
    cy.visit("/ver/asociacion/agg");
});

When(/^cliqueo en el nueva asociación$/, () => {
	cy.get("#page-wrapper > div.wrapper.wrapper-content.animated.fadeInRight > div > div > div > div.ibox-title > div > a.btn.btn-success").click()
});

Then(/^El sistema abre la pantalla de asociar agregador.$/, () => {
    cy.screenshot();
});
