import { When, Given, Then } from "cypress-cucumber-preprocessor/steps";

Given(
    "Un usuario de ingeniería ingresa en el menu de inventario submenu Sitios Jarvis,  Ledzite",
    () => {
        cy.login();
    }
);

When("Consulta ingresa en la lista", () => {
    cy.visit("/ver/ledzite");
});

Then(
    "El sistema muestra los campos de la tabla NODELEDZITE: {string}",
    (val_columnas) => {
        cy.Validar_tabla(val_columnas, "#list_ledzite > ", false);
    }
);

When("Consulta el sitio {string}", (val_node) => {
    cy.visit("/ver/ledzite");
    cy.get("#list_ledzite_filter .form-control").type(val_node);
});

Then(
    "El sistema mostrará los campos de Sitios de Ledzite y colocara libres los campos de Jarvis",
    () => {
        cy.get("td:nth-child(2)").should("contain", "");
    }
);

Then(
    "El sistema mostrará los campos de Sitios en particular, de acuerdo a la informacion que se posea en la tabla NODELEDZITE",
    () => {
        return "pending";
    }
);
