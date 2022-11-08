import { When, Given, Then, And } from "cypress-cucumber-preprocessor/steps";

Given('Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú fronteras para crear una frontera.', () => {
	return true;
});

When('El usuario clickea en nueva frontera', () => {
	return true;
});

When('utilizar la próxima frontera libre sugerida por el sistema 556', () => {
	return true;
});

When('elige el tipo de frontera {string}', (args1) => {
	console.log(args1);
	return true;
});

When('elige el tipo de Servicio {string}', (args1) => {
	console.log(args1);
	return true;
});

Then('El sistema habilita la carga de los campos {string}', (args1) => {
	console.log(args1);
	return true;
});

Given('El usuario de agregación IP, ya seleccionó el tipo de Frontera y el tipo de servicio en la pantalla Alta de frontera.', () => {
	return true;
});

When('elige una zona,', () => {
	return true;
});

Then('El sistema carga las listas de los router con los equipos habilitados en la zona.', () => {
	return true;
});

Given('El usuario de agregación IP, ya seleccionó el router', () => {
	return true;
});

When('elige un Router', () => {
	return true;
});

Then('el sistema muestra los puertos del equipos', () => {
	return true;
});

Given('El usuario de agregación IP, ya seleccionó los puertos del Router', () => {
	return true;
});

When('Se para en el campo Nombre de la interfaz', () => {
	return true;
});

Then('el sistema sugiere el nombre compuesto por Bundle-Ether mas el numero de frontera', () => {
	return true;
});

Then('Calcula el BW de la frontera, igual a la suma de los BW de los distintos puertos', () => {
	return true;
});

Given('El usuario de agregación IP, cargo todos los datos requeridos.', () => {
	return true;
});

When('pulsa Aceptar', () => {
	return true;
});

Then('El sistema realiza la validación de puertos', () => {
	return true;
});

Then('graba la frontera en la base', () => {
	return true;
});

Given('El usuario de agregación Ip, seleccionó distinta cantidad de puertos en el Router PE PEI que los seleccionados en el DM SAR', () => {
	return true;
});

Then('el sistema emite una alerta que indicando que no coinciden la cantidad de puertos entre ambos extremos', () => {
	return true;
});

Given('El usuario de agregación Ip, seleccionó distinta capacidad de puertos en el Router PE/PEI que en los elegidos en el DM/SAR', () => {
	return true;
});

Given('El usuario de agregación Ip, seleccionó distinta capacidad de puertos en el Router PE PEI que en los elegidos en el DM SAR', () =>{
return true;
});

Then('el sistema emite una alerta que indicando que no coinciden la capacidad de puertos entre ambos extremos', () => {
	return true;
});

Given('Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú fronteras', () => {
	return true;
});

Then('Se encuentra dentro de la pantalla de alta de frontera', () => {
	return true;
});

When('modifica el numero de frontera {int}', (args1) => {
	return true;
});

Then('El sistema Permite continuar con la carga.', () => {
	return true;
});

Then('El sistema emite una alerta de Frontera existente y no permite continuar con la carga.', () => {
	return true;
});

Given('usuario con el perfil de Agregación IP dentro de la pantalla de alta de frontera', () => {
	return true;
});

When('pulsa en el botón Cancelar', () => {
	return true;
});

Then('El sistema descarta la información ingresada hasta el momento', () => {
	return true;
});

Then('sale de la pantalla Alta de frontera', () => {
	return true;
});
