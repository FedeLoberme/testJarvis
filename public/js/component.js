class SomeComponent extends HTMLElement {
    constructor() {
        super();

    }

    connectedCallback() {

    }

    attributeChangedCallback() {

    }

    static get observedAttributes() {
        return [''];
    }
}

window.customElements.define('some-component', SomeComponent);