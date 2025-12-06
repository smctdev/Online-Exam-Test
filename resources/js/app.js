// Load jQuery FIRST
import $ from "jquery";
window.$ = window.jQuery = $;

// Bootstrap (if using v4 plugins)
import "bootstrap";
import "./bootstrap";
// Other plugins that depend on jQuery
import "smartwizard";
import "jquery.cookie";
import "admin-lte";
import "select2";
import "jquery-countdown";
import "datatables.net-bs5";

// CSS imports
import "@fortawesome/fontawesome-free/css/all.min.css";
import "select2-bootstrap-5-theme/dist/select2-bootstrap-5-theme.min.css";
import "fontawesome-iconpicker/dist/css/fontawesome-iconpicker.min.css";

// SweetAlert2, lodash, etc.
import Swal from "sweetalert2";
import printJS from "print-js";
import _ from "lodash";
import Pusher from "pusher-js";

// Globals
window.Swal = Swal;
window.printJS = printJS;
window._ = _;
window.Pusher = Pusher;

import { createApp } from "vue";

window.App = window.App || {};

import Questions from "./components/Questions.vue";

const rootComponent = {};
const app = createApp(rootComponent);

app.component("question", Questions);

const mountedApp = app.mount("#app");
window.App = mountedApp;
