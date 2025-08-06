<template>
    <div>
        <main id="main" class="main">
            <div class="pagetitle">
                <h1>{{ translate("Dashboard") }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">{{ translate("Home") }}</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ translate("Dashboard") }}
                        </li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->
            <h1></h1>

            <section class="section dashboard">
                <div class="row">
                    <!-- SUPERADMIN & ACCOUNTANT -->
                    <template
                        v-if="['superadmin', 'accountant'].includes(userRole)"
                    >
                        <div class="col-lg-12" :class="rtlClass">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div
                                        class="card info-card income-card bg-white h-100"
                                    >
                                        <div
                                            class="card-body d-flex flex-column"
                                        >
                                            <div
                                                class="d-flex align-items-center justify-content-between"
                                            >
                                                <h6>
                                                    {{ translate("Incomes") }}
                                                </h6>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="card-title">
                                                    {{ translate("Total") }}:
                                                    {{ incomeTypeTotal }}
                                                </h5>
                                                <div
                                                    v-for="income in incomeTypeDetails"
                                                    :key="income.id"
                                                    class="d-flex justify-content-between border-bottom py-1"
                                                >
                                                    <span>{{
                                                        income.name
                                                    }}</span>
                                                    <span
                                                        >{{
                                                            income.total_income_type
                                                        }}
                                                        ({{
                                                            income.percentage_of_total
                                                        }}%)</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div
                                        class="card info-card expense-card bg-white h-100"
                                    >
                                        <div
                                            class="card-body d-flex flex-column"
                                        >
                                            <div
                                                class="d-flex align-items-center justify-content-between"
                                            >
                                                <h6>
                                                    {{ translate("Expense") }}
                                                </h6>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h5 class="card-title">
                                                    {{ translate("Total") }}:
                                                    {{ expenseTypeTotal }}
                                                </h5>
                                                <div
                                                    v-for="expense in expenseTypeDetails"
                                                    :key="expense.id"
                                                    class="d-flex justify-content-between border-bottom py-1"
                                                >
                                                    <span>{{
                                                        expense.name
                                                    }}</span>
                                                    <span
                                                        >{{
                                                            expense.total_expense_type
                                                        }}
                                                        ({{
                                                            expense.percentage_of_total
                                                        }}%)</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter -->
                        <div class="row justify-content-end mb-4 mt-4">
                            <div class="col-md-4">
                                <div
                                    class="filter-box bg-white rounded-pill shadow-sm px-3 py-2 d-flex align-items-center gap-2"
                                >
                                    <i
                                        class="bi bi-funnel-fill text-primary fs-5"
                                    ></i>
                                    <Multiselect
                                        v-model="selectedFilter"
                                        :options="filterOptions"
                                        :searchable="true"
                                        @select="applyFilter"
                                        :placeholder="translate('Filter By')"
                                        class="w-100"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Cash In, Out, Balance -->
                        <div class="col-lg-12" :class="rtlClass">
                            <div class="row">
                                <div
                                    class="col-xxl-4 col-md-4"
                                    v-for="(item, idx) in cashSummary"
                                    :key="idx"
                                >
                                    <div class="card info-card bg-white">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                {{ item.title }}
                                            </h5>
                                            <div
                                                class="d-flex align-items-center justify-content-between"
                                            >
                                                <h6 :class="item.class">
                                                    {{
                                                        formatCurrency(
                                                            item.value
                                                        )
                                                    }}
                                                </h6>
                                                <span :class="item.iconBg"
                                                    ><i
                                                        :class="item.icon"
                                                        class="text-white"
                                                    ></i
                                                ></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bar Chart -->
                        <div class="col-lg-12" :class="rtlClass">
                            <div
                                class="card shadow-sm border-0 rounded-4 overflow-hidden chart-card"
                            >
                                <div
                                    class="card-header bg-gradient-blue text-white d-flex justify-content-between align-items-center px-4 py-3"
                                >
                                    <h5 class="mb-0 fw-semibold">
                                        {{
                                            translate(
                                                "Income vs Expense (Bar Chart - Selected Range)"
                                            )
                                        }}
                                    </h5>
                                    <i class="bi bi-bar-chart-steps fs-4"></i>
                                </div>
                                <div class="card-body bg-light p-4">
                                    <canvas id="barChart" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- ADMISSION DASHBOARD -->
                    <template
                        v-else-if="
                            ['superadmin', 'admission'].includes(userRole)
                        "
                    >
                        <div class="row g-4">
                            <div
                                v-for="(course, index) in admissionCourses"
                                :key="index"
                                class="col-md-4"
                            >
                                <div
                                    :class="[
                                        'card h-100 text-white admission-card',
                                        course.bg,
                                    ]"
                                >
                                    <div
                                        class="card-body d-flex justify-content-between align-items-center"
                                    >
                                        <!-- Left: Icon -->
                                        <div class="d-flex flex-column">
                                            <i
                                                :class="[
                                                    'fs-2 mb-2',
                                                    course.icon,
                                                ]"
                                            ></i>
                                            <h6 class="fw-bold mb-0">
                                                {{ course.name }}
                                            </h6>
                                            <small class="text-white-50">{{
                                                course.subtitle
                                            }}</small>
                                        </div>
                                        <!-- Right: Badge -->
                                        <span
                                            class="badge rounded-pill bg-light text-dark px-3 py-2"
                                        >
                                            {{ getRandomCount(index) }} طلباء
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- IFTAH DASHBOARD -->

                    <template
                        v-else-if="['superadmin', 'iftah'].includes(userRole)"
                    >
                        <div class="row g-4">
                            <div
                                v-for="(item, index) in iftahItems"
                                :key="index"
                                class="col-md-3"
                            >
                                <Link
                                    :href="item.link"
                                    class="card-box text-decoration-none d-block"
                                >
                                    <div
                                        :class="[
                                            'card h-100 text-white',
                                            item.bg,
                                        ]"
                                    >
                                        <div
                                            class="card-body d-flex flex-column justify-content-between"
                                        >
                                            <div
                                                class="d-flex justify-content-between align-items-center mb-2"
                                            >
                                                <i
                                                    :class="['fs-2', item.icon]"
                                                ></i>
                                                <span
                                                    class="badge rounded-pill px-3 py-1"
                                                    :class="
                                                        item.unanswered > 0
                                                            ? 'bg-danger'
                                                            : 'bg-success'
                                                    "
                                                >
                                                    {{
                                                        item.unanswered > 0
                                                            ? `${item.unanswered} unanswered`
                                                            : "✓"
                                                    }}
                                                </span>
                                            </div>
                                            <h5 class="fw-bold mb-0">
                                                {{ item.name }}
                                            </h5>
                                            <small class="text-white-50">{{
                                                item.description
                                            }}</small>
                                        </div>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </template>
                </div>
            </section>
        </main>
    </div>
</template>

<script>
import Master from "../Layout/Master.vue";
import { Chart, registerables } from "chart.js";
import Multiselect from "@vueform/multiselect";
import axios from "axios";

Chart.register(...registerables);

export default {
    layout: Master,
    components: {
        Multiselect,
    },
    computed: {
        userRole() {
            return this.$page.props.user.role;
        },
        rtlClass() {
            return this.$page.props.default_language === "PK" ||
                this.$page.props.default_language === "SA"
                ? "rtl-text"
                : "";
        },
    },
    data() {
        return {
            admissionCourses: [
                {
                    name: "تَخَصُّص فِی الفِقْہِ ایک سال",
                    subtitle: "Year 1",
                    bg: "bg-gradient-blue",
                    icon: "bi bi-journal-bookmark",
                },
                {
                    name: "تَخَصُّص فِی الفِقْہِ دو سال",
                    subtitle: "Year 2",
                    bg: "bg-gradient-purple",
                    icon: "bi bi-journal-richtext",
                },
                {
                    name: "تحصُّص فِي اللُّغَاتِ",
                    subtitle: "Linguistics",
                    bg: "bg-gradient-green",
                    icon: "bi bi-translate",
                },
                {
                    name: "دورہ حدیث",
                    subtitle: "Hadith Studies",
                    bg: "bg-gradient-orange",
                    icon: "bi bi-book",
                },
                {
                    name: "درجہ سابعہ",
                    subtitle: "Class 7",
                    bg: "bg-gradient-teal",
                    icon: "bi bi-7-square",
                },
                {
                    name: "درجہ سادسہ",
                    subtitle: "Class 6",
                    bg: "bg-gradient-pink",
                    icon: "bi bi-6-square",
                },
                {
                    name: "درجہ خامسہ",
                    subtitle: "Class 5",
                    bg: "bg-gradient-sky",
                    icon: "bi bi-5-square",
                },
                {
                    name: "درجہ رابعہ",
                    subtitle: "Class 4",
                    bg: "bg-gradient-cyan",
                    icon: "bi bi-4-square",
                },
                {
                    name: "درجہ ثالثہ",
                    subtitle: "Class 3",
                    bg: "bg-gradient-yellow",
                    icon: "bi bi-3-square",
                },
                {
                    name: "درجہ ثانیہ",
                    subtitle: "Class 2",
                    bg: "bg-gradient-indigo",
                    icon: "bi bi-2-square",
                },
                {
                    name: "درجہ اولیٰ",
                    subtitle: "Class 1",
                    bg: "bg-gradient-red",
                    icon: "bi bi-1-square",
                },
                {
                    name: "متوسطا",
                    subtitle: "Middle",
                    bg: "bg-gradient-gray",
                    icon: "bi bi-stack",
                },
            ],

            iftahItems: [
                {
                    name: "Books",
                    link: "/books",
                    icon: "bi bi-book",
                    description: "Manage Islamic Books",
                    bg: "bg-gradient-primary",
                    unanswered: 0,
                },
                {
                    name: "Bayanaat",
                    link: "/bayanaat",
                    icon: "bi bi-mic",
                    description: "Upload speeches",
                    bg: "bg-gradient-purple",
                    unanswered: 0,
                },
                {
                    name: "Islamic Names",
                    link: "/islamic-names",
                    icon: "bi bi-person-bounding-box",
                    description: "Track name suggestions",
                    bg: "bg-gradient-success",
                    unanswered: 0,
                },
                {
                    name: "Question & Answers",
                    link: "/questions-answers",
                    icon: "bi bi-question-circle",
                    description: "Answer pending questions",
                    bg: "bg-gradient-warning",
                    unanswered: 12, // Example
                },
            ],
            transactionEntries: [],
            incomeTypeDetails: [],
            incomeTypeTotal: 0,
            expenseTypeDetails: [],
            expenseTypeTotal: 0,
            expenseDetails: [],
            cashIn: 0,
            cashOut: 0,
            balance: 0,
            last6MonthsData: [],
            last12MonthsData: [],
            selectedFilter: "3", // Default to last 3 months
            titleCashIn: "Current Month Cash In",
            titleCashIn: "Current Month Cash Out",
            titleCashIn: "Last 3 Months Cash In",
            titleCashOut: "Last 3 Months Cash Out",
            titleBalance: "Last 3 Months Balance",
            filterLabel: "Last 3 Months",
            filterOptions: [
                { value: "1", label: this.translate("Current Month") },
                { value: "3", label: this.translate("Last 3 Months") },
                { value: "6", label: this.translate("Last 6 Months") },
                { value: "12", label: this.translate("Last 1 Year") },
                // { value: "all", label: "Overall" },
            ],
        };
    },
    methods: {
        getRandomCount(seed) {
            return Math.floor(100 + ((seed * 73) % 900));
        },
        formatCurrency(value) {
            return new Intl.NumberFormat("en-PK", {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            }).format(value);
        },

        fetchExpenseDetails() {
            axios
                .get(route("api.dashboard.expense.details.fetch"))
                .then((response) => {
                    this.expenseDetails = response.data || [];
                    this.expenseTypeDetails = response.data.expense_types;
                    this.expenseTypeTotal = response.data.total_expense;
                })
                .catch((error) => {
                    console.error("Error fetching transactions:", error);
                });
        },
        fetchIncomeDetails() {
            axios
                .get(route("api.dashboard.income.details.fetch"))
                .then((response) => {
                    this.incomeTypeDetails = response.data.income_types;
                    this.incomeTypeTotal = response.data.total_income;
                })
                .catch((error) => {
                    console.error("Error fetching transactions:", error);
                });
        },
        applyFilter() {
            if (this.selectedFilter === "all") {
                // Set filter label and titles for overall data
                this.filterLabel = "Overall";
                this.titleCashIn = "Overall Cash In";
                this.titleCashOut = "Overall Cash Out";
                this.titleBalance = "Overall Balance";

                // Pass all entries to calculateStats
                this.calculateStats(this.transactionEntries);
            } else {
                // Handle month-based filtering
                const filterMonths = parseInt(this.selectedFilter);
                const currentDate = new Date();

                const filteredData = this.transactionEntries.filter((entry) => {
                    const entryDate = new Date(entry.transaction_date);
                    const monthDifference =
                        (currentDate.getFullYear() - entryDate.getFullYear()) *
                            12 +
                        currentDate.getMonth() -
                        entryDate.getMonth();
                    return monthDifference < filterMonths;
                });

                this.filterLabel = `Last ${this.selectedFilter} Months`;
                this.titleCashIn = `${this.filterLabel} Cash In`;
                this.titleCashOut = `${this.filterLabel} Cash Out`;
                this.titleBalance = `${this.filterLabel} Balance`;

                this.calculateStats(filteredData);
            }

            this.updateCharts();
        },
        updateCharts() {
            // Check and destroy existing charts
            if (this.barChart) {
                this.barChart.destroy();
                this.barChart = null;
            }
            // if (this.lineChart) {
            //     this.lineChart.destroy();
            //     this.lineChart = null;
            // }

            if (this.selectedFilter === "all") {
                // Aggregate totals for cash in and cash out
                const totalCashIn = this.transactionEntries.reduce(
                    (sum, entry) => sum + parseFloat(entry.cash_in || 0),
                    0
                );

                const totalCashOut = this.transactionEntries.reduce(
                    (sum, entry) => sum + parseFloat(entry.cash_out || 0),
                    0
                );

                // Bar Chart (Overall Data for All)
                const barCtx = document
                    .getElementById("barChart")
                    .getContext("2d");
                this.barChart = new Chart(barCtx, {
                    type: "bar",
                    data: {
                        labels: ["Cash In", "Cash Out"], // Overall categories
                        datasets: [
                            {
                                label: "Overall Data",
                                data: [totalCashIn, totalCashOut],
                                backgroundColor: ["#4caf50", "#f44336"], // Green for Cash In, Red for Cash Out
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            },
                            tooltip: {
                                callbacks: {
                                    label: (context) =>
                                        `${
                                            context.label
                                        }: ${this.formatCurrency(context.raw)}`,
                                },
                            },
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: "Transaction Type",
                                },
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: "Amount",
                                },
                                beginAtZero: true,
                            },
                        },
                    },
                });
            } else {
                // Existing logic for monthly filters
                const barCtx = document
                    .getElementById("barChart")
                    .getContext("2d");
                this.barChart = new Chart(barCtx, {
                    type: "bar",
                    data: {
                        labels: this.last6MonthsData.map((item) => item.label),
                        datasets: [
                            {
                                label: "Income",
                                data: this.last6MonthsData.map(
                                    (item) => item.income
                                ),
                                backgroundColor: "#4caf50",
                            },
                            {
                                label: "Expense",
                                data: this.last6MonthsData.map(
                                    (item) => item.expense
                                ),
                                backgroundColor: "#f44336",
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: "top",
                            },
                            tooltip: {
                                callbacks: {
                                    label: (context) =>
                                        `${
                                            context.dataset.label
                                        }: ${this.formatCurrency(context.raw)}`,
                                },
                            },
                        },
                    },
                });

                const lineCtx = document
                    .getElementById("lineChart")
                    .getContext("2d");

                this.lineChart = new Chart(lineCtx, {
                    type: "line", // Line chart type
                    data: {
                        labels: this.last12MonthsData.map((item) => item.label), // X-axis labels: Months or other periods
                        datasets: [
                            {
                                label: "Income", // Label for Income line
                                data: this.last12MonthsData.map(
                                    (item) => item.income
                                ), // Data for Income
                                borderColor: "#4caf50", // Green line for Income
                                fill: false, // No fill under the line
                                tension: 0.4, // Smooth curve
                            },
                            {
                                label: "Expense", // Label for Expense line
                                data: this.last12MonthsData.map(
                                    (item) => item.expense
                                ), // Data for Expense
                                borderColor: "#f44336", // Red line for Expense
                                fill: false, // No fill under the line
                                tension: 0.4, // Smooth curve
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: "top", // Legend position at the top
                            },
                            tooltip: {
                                callbacks: {
                                    label: (context) =>
                                        `${
                                            context.dataset.label
                                        }: ${this.formatCurrency(context.raw)}`, // Format tooltip currency
                                },
                            },
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: "Month", // X-axis title (e.g., Month)
                                },
                                ticks: {
                                    autoSkip: true,
                                    maxTicksLimit: 12, // Limit the number of ticks on the x-axis
                                },
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: "Amount", // Y-axis title (e.g., Amount)
                                },
                                beginAtZero: true, // Start y-axis from 0
                            },
                        },
                    },
                });
            }
        },

        fetchTransactionEntries() {
            axios
                .get(route("api.dashbaord.transaction.fetch"))
                .then((response) => {
                    this.transactionEntries = response.data || [];

                    this.applyFilter();
                })
                .catch((error) => {
                    console.error("Error fetching transactions:", error);
                });
        },

        calculateStats() {
            const currentDate = new Date();

            // Filter transactions based on selected time range
            const filteredEntries = this.transactionEntries.filter((entry) => {
                const entryDate = new Date(entry.transaction_date);

                if (isNaN(entryDate)) return false; // Skip invalid dates

                if (this.selectedFilter === "all") return true;

                const filterMonths = parseInt(this.selectedFilter, 10);
                const pastDate = new Date();
                pastDate.setMonth(currentDate.getMonth() - filterMonths);
                pastDate.setDate(1); // Ensuring we start from the first of the month

                return entryDate >= pastDate;
            });

            // Calculate total cash in and out
            this.cashIn = filteredEntries.reduce(
                (sum, entry) => sum + (parseFloat(entry.cash_in) || 0),
                0
            );
            this.cashOut = filteredEntries.reduce(
                (sum, entry) => sum + (parseFloat(entry.cash_out) || 0),
                0
            );

            this.balance = this.cashIn - this.cashOut;

            // Ensure separate calculations for 6-month and 12-month data
            this.last6MonthsData = this.groupDataByMonths(filteredEntries, 6);
            this.last12MonthsData = this.groupDataByMonths(filteredEntries, 12);
        },

        applyFilter() {
            const filterMonths =
                this.selectedFilter === "all"
                    ? Infinity
                    : parseInt(this.selectedFilter);
            const currentDate = new Date();

            const filteredData = this.transactionEntries.filter((entry) => {
                const entryDate = new Date(entry.transaction_date);
                const monthDifference =
                    (currentDate.getFullYear() - entryDate.getFullYear()) * 12 +
                    currentDate.getMonth() -
                    entryDate.getMonth();
                return monthDifference < filterMonths;
            });

            this.calculateStats(filteredData);
            this.updateCharts();
        },

        groupDataByMonths(entries, months) {
            const groupedData = [];
            const currentDate = new Date();

            const formatMonth = new Intl.DateTimeFormat("en-US", {
                month: "short", // Abbreviated month name (e.g., Jan, Feb)
                year: "numeric", // Full year (e.g., 2025)
            });

            for (let i = 0; i < months; i++) {
                const month = new Date();
                month.setMonth(currentDate.getMonth() - i);
                const monthLabel = formatMonth.format(month);

                groupedData.push({
                    label: monthLabel,
                    income: 0,
                    expense: 0,
                });
            }

            entries.forEach((entry) => {
                const entryDate = new Date(entry.transaction_date);
                const monthLabel = formatMonth.format(entryDate);

                const groupIndex = groupedData.findIndex(
                    (item) => item.label === monthLabel
                );

                if (groupIndex !== -1) {
                    groupedData[groupIndex].income +=
                        parseFloat(entry.cash_in) || 0;
                    groupedData[groupIndex].expense +=
                        parseFloat(entry.cash_out) || 0;
                }
            });

            return groupedData;
        },
    },
    mounted() {
        this.fetchTransactionEntries();
    },
    watch: {
        transactionEntries() {
            this.applyFilter();
        },
        selectedFilter() {
            this.applyFilter();
        },
    },
    created() {
        this.fetchIncomeDetails();
        this.fetchExpenseDetails();
    },
};
</script>

<style scoped>
@import "@vueform/multiselect/themes/default.css";
.info-card {
    background: #f8f9fa;
    border: none;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    padding: 20px;
}

.icon-bubble {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
canvas {
    width: 100% !important;
    height: 400px !important;
}

/* style for the iftah dashboard */
.card-box .card {
    border: none;
    border-radius: 16px;
    padding: 1.2rem;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s ease-in-out;
}
.card-box .card:hover {
    transform: scale(1.03);
}
.bg-gradient-primary {
    background: linear-gradient(135deg, #44b4ff, #2f80ed);
}
.bg-gradient-purple {
    background: linear-gradient(135deg, #7f00ff, #e100ff);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #1abc9c, #16a085);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #f39c12, #f1c40f);
}

/* style for Admission user dashboard */
.admission-card {
    border: none;
    border-radius: 16px;
    padding: 1.2rem;
    transition: transform 0.2s ease-in-out;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}
.admission-card:hover {
    transform: scale(1.03);
}
.bg-gradient-blue {
    background: linear-gradient(135deg, #44b4ff, #2f80ed);
}
.bg-gradient-purple {
    background: linear-gradient(135deg, #7f00ff, #e100ff);
}
.bg-gradient-green {
    background: linear-gradient(135deg, #11998e, #38ef7d);
}
.bg-gradient-orange {
    background: linear-gradient(135deg, #f39c12, #f1c40f);
}
.bg-gradient-teal {
    background: linear-gradient(135deg, #20c997, #17a2b8);
}
.bg-gradient-pink {
    background: linear-gradient(135deg, #ff758c, #ff7eb3);
}
.bg-gradient-sky {
    background: linear-gradient(135deg, #74ebd5, #9face6);
}
.bg-gradient-cyan {
    background: linear-gradient(135deg, #00c9ff, #92fe9d);
}
.bg-gradient-yellow {
    background: linear-gradient(135deg, #fddb92, #d1fdff);
}
.bg-gradient-indigo {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
}
.bg-gradient-red {
    background: linear-gradient(135deg, #ff416c, #ff4b2b);
}
.bg-gradient-gray {
    background: linear-gradient(135deg, #bdc3c7, #2c3e50);
}

/* main dashboard for accouting style */
.card.info-card {
    border: none;
    border-radius: 16px;
    padding: 1.5rem;
    color: #ffffff;
    background: linear-gradient(
        135deg,
        #1c92d2,
        #f2fcfe
    ); /* fallback gradient */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
}
.card.info-card:hover {
    transform: scale(1.01);
}

/* Specific Gradient Overrides */
.card.info-card.income-card {
    background: linear-gradient(135deg, #44b4ff, #2f80ed);
}

.card.info-card.expense-card {
    background: linear-gradient(135deg, #ff416c, #ff4b2b);
}

/* Section Title */
.card h6 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff;
}

/* Total Value */
.card .card-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 1rem;
}

/* Breakdown Rows */
.card .border-bottom {
    font-size: 0.95rem;
    padding-bottom: 0.5rem;
    margin-bottom: 0.5rem;
    border-color: rgba(255, 255, 255, 0.3);
    color: #ffffff;
}

.card .border-bottom span:last-child {
    font-weight: 500;
    color: #f1f1f1;
    white-space: nowrap;
}
/* filter deisgn  */
.filter-box {
    border: 1px solid #e0e0e0;
    transition: box-shadow 0.3s ease;
}
.filter-box:hover {
    box-shadow: 0 0 0 4px rgba(44, 123, 255, 0.1);
}

/* bar chart design */
.chart-card {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
}

.card-header.bg-gradient-blue {
    background: linear-gradient(135deg, #36d1dc, #5b86e5);
}

.card-body.bg-light {
    background-color: #f8f9fa;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

#barChart {
    max-height: 300px;
}
</style>
