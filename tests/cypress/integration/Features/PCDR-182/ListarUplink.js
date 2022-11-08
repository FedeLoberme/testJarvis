import { When, Given, Then } from "cypress-cucumber-preprocessor/steps";

Given("usuario ingresa en la lista LINK UPLINK CELDA.", function () {
    // Write code here that turns the phrase above into concrete actions

    cy.login();
    cy.visit("/ver/link/celda");

    //  return 'pending';
});

When("El usuario se posiciona en el Uplink {string}", (varUplink) => {
    cy.get("#list_link_ipran_filter .form-control").click();
    cy.get("#list_link_ipran_filter .form-control").type(varUplink);
});

When("Ingresa en la Opcion de Listar servicios", function () {
    // Write code here that turns the phrase above into concrete actions
    cy.get(".fa-desktop").click();
});

Then("Se ingresa en la pantalla listar Servicios", function () {
    // Write code here that turns the phrase above into concrete actions
});

Then(
    "es {string} la lista de servicios con las columnas {string}",
    (var_resultado, val_columnas) => {
        cy.log("Verifica que la tabla tenga todos los campos.");
        cy.Validar_tabla(val_columnas, "#pop_servi_equipo > ", true);

        cy.log(
            "Verifica si tiene que tener datos o no. resultado esperado :",
            var_resultado
        );
        cy.Control_resultado_tabla("#servi_equipo", var_resultado);
        //#pop_servi_equipo > div > div > div.ibox.float-e-margins > div > div > table
    }
);
