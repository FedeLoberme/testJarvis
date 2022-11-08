import { When, Given, Then } from "cypress-cucumber-preprocessor/steps";
Given(
    "Un usuario de ingeniería al cliente, ingresó en el menú Admin Celdas, Sub menú reservas, para crear una reserva.",
    () => {
        cy.login();
        cy.visit("/ver/reserva");
    }
);

When("El usuario cliquea en crear una reserva", () => {
    cy.get(".btn-success:nth-child(1)").click();
});

Then(
    "El sistema muestra en {int} el BW y la unidad en {string}.",
    (valor, valor_unidad) => {
        cy.get("input#BW_chain").should("have.text", "");
        cy.get("select#bw_max_size option:selected").should(
            "have.text",
            valor_unidad
        );
    }
);

Then(
    "El sistema solicita que ingrese capacidad y Unidad para registrar la solicitud",
    () => {
        cy.get("select#bw_max_size")
            .select("1")
            .invoke("val")
            .should("eq", "1");
        cy.get("input#BW_chain").type("50");
    }
);

Given(
    "Un usuario de ingeniería al cliente, ingresó en el menú inventario -> administrativo -> Servicios",
    () => {
        cy.login();
        cy.visit("/ver/servicio");
    }
);

When("El usuario cliquea en Nuevo Servicio", () => {
    cy.get(".ibox-tools > .btn").click();
});

Then(
    "El sistema muestra en {int} el Ancho de banda y la unidad en {string}.",
    (valor, valor_unidad) => {
        cy.get("input#n_max").should("have.text", "");
        cy.get("select#max option:selected").should("have.text", valor_unidad);
    }
);

Then(
    "El sistema solicita que ingrese capacidad y Unidad para registrar el servicio",
    () => {
        cy.get("#n_max").type("50");
        cy.get("select#max").select("1").invoke("val").should("eq", "1");
    }
);

Given(
    "Un usuario de ingeniería al cliente, ingresó en el menú Admin Celdas, Sub menú reservas, para crear una reserva sobre servicio.",
    () => {
        cy.login();
        cy.visit("/ver/reserva");
    }
);

When("El usuario cliquea en crear una reserva sobre servicio", () => {
    cy.get(".btn-success:nth-child(2)").click();
});

Then(
    "El sistema muestra en {int} el BW y la unidad en {string}.",
    (valor, valor_unidad) => {
        cy.get("input#bw_input").should("have.text", "");
        cy.get("select#size_sel option:selected").should(
            "have.text",
            valor_unidad
        );
    }
);

Then(
    "El sistema solicita que ingrese capacidad y Unidad para registrar la solicitud upgrade",
    () => {
        cy.get("select#size_sel").select("1").invoke("val").should("eq", "1");
        cy.get("input#bw_input").type("50");
    }
);
