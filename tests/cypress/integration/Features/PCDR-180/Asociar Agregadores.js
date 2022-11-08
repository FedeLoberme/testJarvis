import { When, Given, Then } from "cypress-cucumber-preprocessor/steps";

Given(
    "El usuario de agregación IP, ingresó en la lista equipos agregadores al Agg {string}, cliqueo sobre el icono de asociar equipos e ingreso en la pantalla con el agregador seleccionado.",
    (Val_agregador) => {
        cy.login();
        cy.visit("/ver/AGG");
        cy.get("#claro_agregador_filter > label > input").type(Val_agregador);
        cy.get(".ibox-content:nth-child(2) > .table-responsive").click();
        cy.get("a:nth-child(7) > .fa").click();
    }
);

When(
    "Ingresa el numero de Prefijo de frontera {string}",
    (Val_Nro_frontera) => {
    //    cy.get("#prefix_inpt").should('have.value',Val_Nro_frontera);
    }
);

When(
    "selecciona una zona de la lista como ZONA HOME {string}",
    (VAL_ZONA_HOME) => {
        cy.get("#zh_sel").select(VAL_ZONA_HOME);
    }
);

When(
    "se selecciona un router PE {string} de los perteneciente a la zona {string} para ser asignado como router PE home",
    (Val_PE, VAL_ZONA_HOME) => {
        cy.wait(500);
		cy.get("#pe_mlps_btn_1").click();
		cy.get("#pe_pei_table_filter > label > input").clear();
		cy.get("#pe_pei_table_filter > label > input").type(Val_PE);
		cy.get("#pe_pei_table > tbody > tr.odd > td:nth-child(5) > a > i").click();

    }
);

When(
    "se selecciona un router PEI {string} de los perteneciente a la zona {string} para ser asignado como router PEI home",
    (Val_PI, VAL_ZONA_HOME) => {
		cy.wait(500);
		cy.get("#pe_int_btn_1").click();
		cy.get("#pe_pei_table_filter > label > input").clear();
		cy.get("#pe_pei_table_filter > label > input").type(Val_PI);
		cy.get("#pe_pei_table > tbody > tr.odd > td:nth-child(5) > a > i").click();
    }
);

When(
    "selecciona una de la lista una zona, como ZONA MULTIHOME HOME {string} distinta a la zona {string}",
    (VAL_ZONA_MH, VAL_ZONA_HOME) => {
        cy.get("#zmh_sel").select(VAL_ZONA_MH);
    }
);

When(
    "se selecciona un router PE {string} perteneciente a la zona {string} para ser asignado como router PE Multi home",
    (Val_PE_MH, VAL_ZONA_MH) => {
		cy.wait(500);
		cy.get("#pe_mlps_btn_2").click();
		cy.get("#pe_pei_table_filter > label > input").clear();
		cy.get("#pe_pei_table_filter > label > input").type(Val_PE_MH);
		cy.get("#pe_pei_table > tbody > tr.odd > td:nth-child(5) > a > i").click();
    }
);

When(
    "se selecciona un router PEI {string} perteneciente a la zona {string} para ser asignado como router PEI Multi home",
    (Val_PI_MH, VAL_ZONA_MH) => {
		cy.wait(500);
		cy.get("#pe_int_btn_2").click();
		cy.get("#pe_pei_table_filter > label > input").clear();
		cy.get("#pe_pei_table_filter > label > input").type(Val_PI_MH);
		cy.get("#pe_pei_table > tbody > tr.odd > td:nth-child(5) > a > i").click();
    }
);

Then("a {string}", (Resultado_esperado) => {

    cy.get("#accept_relate_agg_pe_pei > strong").click();
	cy.screenshot();
});
