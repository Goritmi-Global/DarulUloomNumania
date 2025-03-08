<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">{{ person_name }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Alsmi</a></li>
                        <li class="breadcrumb-item">Accounts</li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </nav>
            </div>
        </div>

        <section class="section">
            <div class="card p-4">
                <div class="card-body c-form-card">
                    <div class="table-responsive">
                        <table id="ledgerTable" class="table table-striped" v-if="formattedLedger.length">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Cash In</th>
                                    <th>Cash Out</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(entry, index) in formattedLedger" :key="entry.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ formatDate(entry.transaction_date) }}</td>
                                    <td >
                                        {{ entry.cash_in > 0 ? formatCurrency(entry.cash_in) : "-" }}
                                    </td>
                                    <td >
                                        {{ entry.cash_out > 0 ? formatCurrency(entry.cash_out) : "-" }}
                                    </td>
                                    <td >
                                        {{ entry.balance_sign }}{{ formatCurrency(entry.running_balance) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <p v-else>No transactions found.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import Master from "../Layout/Master.vue";

export default {
    layout: Master,
    props: ["person_name", "ledger"],

    computed: {
        formattedLedger() {
            let balance = 0;
            return [...this.ledger]
                .sort((a, b) => new Date(a.transaction_date) - new Date(b.transaction_date)) // Sort by date
                .map(entry => {
                    const cash_in = entry.credit === "1" ? parseFloat(entry.amount) : 0;
                    const cash_out = entry.debit === "1" ? parseFloat(entry.amount) : 0;

                    balance += cash_in - cash_out; // Calculate running balance
                    const balance_sign = balance >= 0 ? "" : "-"; // Add sign based on balance

                    return {
                        ...entry,
                        cash_in,
                        cash_out,
                        running_balance: Math.abs(balance), // Always show positive value, sign added separately
                        balance_sign
                    };
                });
        }
    },

    mounted() {
        this.$nextTick(() => {
            $("#ledgerTable").DataTable();
        });
    },

    methods: {
        formatDate(date) {
            const d = new Date(date);
            return d.toLocaleDateString("en-PK", {
                day: "2-digit",
                month: "short",
                year: "numeric",
            });
        },

        formatCurrency(amount) {
            return new Intl.NumberFormat("en-PK", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
                useGrouping: true
            }).format(amount).replace(/[^\d.,]/g, ""); // Removes currency symbol
        }
    }
};
</script>
