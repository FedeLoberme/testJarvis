import { When, Given, Then, And } from "cypress-cucumber-preprocessor/steps";
import { isNull } from "lodash";
let BW_servicio_actual;
let temp_bw_upgrade;
let temp_bw_upgrade_unidad, BW_remanente, BW_remanente_unidad;

function convert_kb(size, unidad, sizeplustext) {
    let num_convertir, pos_mb, numero;

    cy.log("llegaron", unidad, size, sizeplustext);

    switch (unidad) {
        case "Mbps":
            num_convertir = 1024;
            break;
        case "Gbps":
            num_convertir = 1024 * 1024;
            break;
        default:
            num_convertir = 1;
            break;
    }

    size != 0
        ? (numero = size)
        : ((pos_mb = sizeplustext.indexOf("Mbps")),
          (numero = sizeplustext.substring(0, pos_mb)));

    cy.log(unidad, size, num_convertir, Number(numero));

    return Number(numero) * num_convertir;
}

Given(
    "Un usuario de consultoría, ingresó en el menú Admin celda, Sub menú reservas.",
    () => {
        cy.login();
        cy.visit("/ver/reserva");
    }
);

When("El usuario clickea en crear reserva Upgrade", () => {
    cy.get(".btn-success:nth-child(2)").click();
});
When("selecciona el servicio activo: {string}", (val_servicio) => {
    cy.get(".ico_input:nth-child(3)").click();
    cy.get("#list_all_servicio_filter .form-control").click();
    cy.get("#list_all_servicio_filter > label > input").type(val_servicio);
    cy.get("#list_all_servicio > tbody > tr > td:nth-child(4)")
        .invoke("text") // for input or textarea, .invoke('val')
        .then((text) => {
            BW_servicio_actual = text;
            cy.log(BW_servicio_actual);
        });
    cy.get(".fa-bullseye").click();
    //    cy.get("#crear_reserva_servicio_pop .btn:nth-child(1) > strong").click();
    cy.get(
        "#body > div.sweet-alert.showSweetAlert.visible > div.sa-button-container > button.confirm"
    ).click();

    cy.get("#bw_remanence_data")
        .invoke("text") // for input or textarea, .invoke('val')
        .then((text) => {
            BW_remanente = text;
        });

    cy.get("#bw_remanence_unit")
        .invoke("text") // for input or textarea, .invoke('val')
        .then((text) => {
            BW_remanente_unidad = text;
        });
});

Then(
    "El sistema carga el formulario de Upgrade los datos, celda, LINK, Cliente, tipo de servicio, estos datos no podrán ser modificables",
    () => {
        return "pending";
    }
);

Then("habilita el campo Oportunidad para que el usuario lo ingrese", () => {
    return "pending";
});

Then(
    "habilita el campo nuevo BW final del Servicio para que el usuario lo ingrese",
    () => {
        return "pending";
    }
);

Then("actualiza el cuadro Información de celda al momento de reservar", () => {
    return "pending";
});

Then("Completa el numero de oportunidad", () => {
    return "pending";
});

Then(
    "Completa el BW final de servicio {int} {string}",
    (val_bw_final, val_unidad) => {
        cy.get("#bw_input").clear();
        cy.get("#bw_input").type(val_bw_final);
        temp_bw_upgrade = val_bw_final;
        temp_bw_upgrade_unidad = val_unidad;
        cy.get("#size_sel").select("1").invoke("val").should("eq", "1");
    }
);

Then("Clickea Guardar", () => {
    cy.get("#alta_reserve_service > strong").click();
    cy.wait(600);
});

And("verifica que el bw ingresado sea mayor al del servicio", () => {
    cy.log(
        "verificar ",
        BW_servicio_actual,
        "debe ser mayor a ",
        temp_bw_upgrade,
        " ",
        temp_bw_upgrade_unidad
    );
    expect (temp_bw_upgrade.to.be.gte(convert_kb(0, "Mbps", BW_servicio_actual))
    );
});

Then(
    "El sistema verifica que el BW ingresado sea menor o igual al BW remanente",
    () => {
        cy.log("Verifica que exista BW remanente. Remanente: ",BW_remanente, BW_remanente_unidad," ",temp_bw_upgrade );
        expect(temp_bw_upgrade.to.be.lte.convert_kb(BW_remanente, BW_remanente_unidad, null));
    }
);

Then(
    "El sistema emite un cartel indicando no es posible realizar una reserva para liberar ancho de banda.",
    () => {
        return "pending";
    }
);

Then("No permite el guardado de la reserva.", () => {
    return "pending";
});

Then(
    "registra la reserva en la tabla RESERVE, donde BW_RESERVE será la diferencia entre el BW final ingresado por el usuario y el BW actual servicio.",
    () => {
        return "pending";
    }
);
