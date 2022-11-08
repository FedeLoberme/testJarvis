import { user, contrasena } from "../../fixtures/config.json";

// control filas de una tabla
//    cy.get('table tbody tr').should('have.length', 5);

//cy.contains('Example Text').parent('.tr');

//La función  Validar_tabla se utiliza para controlar tablas. Controla que las columnas informadas
// exista, y que la tabla posea la misma cantidad de columnas que las informadas en la Feature
// parámetros:
// cadena_campos - Todos los campos de la tabla separados por ,
// Selector - Selector (JS) de la tabla a controlar
// Opcion - ¿Posee un campo opcion o adicional? <true, si posee, false si no posee>

Cypress.Commands.add("Validar_tabla", (cadena_campos, selector, Opcion) => {
    cy.log("Busca columna ", cadena_campos, Opcion);
    var partsArray = cadena_campos.split(",");
    let varopcion = 0;
    Opcion == true ? (varopcion = 1) : (varopcion = 0);
    cy.log("Valida el total de columnas esperadas :", partsArray.length);

    cy.get(selector)
        .find("th")
        .should("have.length", partsArray.length + varopcion);

    partsArray.forEach((element) => {
        cy.get(selector).contains(element.trim()).should("to.exist");
    });
});

Cypress.Commands.add("login", () => {
    cy.visit("/login");
    cy.get("#username").click();
    cy.get("#username").type(user);
    cy.get("#password").type(contrasena, { log: false });
    cy.get(".btn-danger").click();

    if (user != "ADMIN_JARVIS") {
        cy.log("el boton existe");
        cy.get("#myBtnSi").click();
    } else {
        cy.log("el boton no existe");
    }

    cy.url().should("contain", "/home");
});

Cypress.Commands.add("Control_resultado_tabla", (selector, var_mostrar) => {
    let varfilas = 1;
    let valida = "be.eq";
    let Vresult = "not.visible";
    var_mostrar == "visible"
        ? ((varfilas = 1),
          (Vresult = "be.visible"),
          (valida = "be.gte"),
          cy.get(selector).find("tr").its("length").should(valida, varfilas))
        : ((varfilas = 0), (Vresult = "not.exist"), (valida = "be.eq"));
    cy.get(selector).find("tr").should(Vresult);
});
