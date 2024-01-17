import "./bootstrap";

import Alpine from "alpinejs";
import DataTable from "datatables.net-dt";
import "remixicon/fonts/remixicon.css";
import 'simplebar'; // or "import SimpleBar from 'simplebar';" if you want to use it manually.
import 'simplebar/dist/simplebar.css';

// You will need a ResizeObserver polyfill for browsers that don't support it! (iOS Safari, Edge, ...)

window.Alpine = Alpine;
window.DataTable = DataTable;

Alpine.start();
