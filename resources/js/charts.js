import { Chart, DoughnutController, LineController, BarController, ArcElement, LineElement, PointElement, BarElement, CategoryScale, LinearScale, Legend, Tooltip, Filler } from 'chart.js';
Chart.register(DoughnutController, LineController, BarController, ArcElement, LineElement, PointElement, BarElement, CategoryScale, LinearScale, Legend, Tooltip, Filler);
window.Chart = Chart;
