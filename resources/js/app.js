import "./bootstrap";
import "./vendor/jquery.min.js";
import "./vendor/jquery.smartWizard.min.js";
import "./vendor/bootstrap.min.js";
import "./vendor/jquery.cookie.js";

import "./vendor/adminlte.min.js";
import "./vendor/select2.full.min.js";
import "./vendor/fontawesome-iconpicker.min.js";
// import "./vendor/theme.js";
// import "./vendor/DataTables_2/datatables.min.js"
// import "./vendor/DataTables_2/datatables.js"

import "./vendor/jquery.countdown.js";

// import "./vendor/datatables.min.js";

import { createApp } from "vue";

window.App = window.App || {};

import Questions from "./components/Questions.vue";

const rootComponent = {};
const app = createApp(rootComponent);

app.component("question", Questions);

const mountedApp = app.mount("#app");
window.App = mountedApp;
