import {
    When,
    Given,
    Then
} from "cypress-cucumber-preprocessor/steps";

Given('Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú fronteras.', () => {
	return true;
});

When('El usuario ingresa en la pantalla', () => {
	return true;
});

Then('El sistema muestra la lista con los campos {string}', (args1) => {
	console.log(args1);
	return true;
});
