import { Controller } from "@hotwired/stimulus";
import { Chart, registerables } from "chart.js";

Chart.register(...registerables);

export default class extends Controller {
    static targets = ["canvas"];

    connect() {
        this.chart = new Chart(this.canvasTarget, {
            type: "bar",
            data: {
                labels: ["A", "B", "C"],
                datasets: [{
                    label: "Démo",
                    data: [12, 19, 3],
                    backgroundColor: ["#4F46E5", "#22C55E", "#EF4444"]
                }]
            }
        });
    }

    disconnect() {
        if (this.chart) {
            this.chart.destroy();
        }
    }
}
