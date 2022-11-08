import {
    When,
    Given,
    Then
} from "cypress-cucumber-preprocessor/steps";
Given('Un usuario con el perfil de Agregación IP, ingresó la pantalla Relacionar AGG con PE-PEI', () => {
    cy.login();
});

When('Un agregador es elegido', () => {
	return true;
});

Then('El sistema muestra los dato de IP de gestión del agregador y el campo Prefijo del agregador, ultimo octeto de la ip de gestión.', () => {
	console.log("args1");
    return true;
});
