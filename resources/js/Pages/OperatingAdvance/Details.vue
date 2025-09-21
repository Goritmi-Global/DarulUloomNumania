<template>
  <main id="main" class="main">
    <!-- Page Title -->
    <div class="pagetitle d-flex justify-content-between align-items-start mb-3">
      <div>
        <h1 class="theme-text-color mb-1">{{ translate("Operating Advance Details") }}</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <Link href="/dashboard">{{ translate("Darul Oloom") }}</Link>
            </li>
            <li class="breadcrumb-item active">{{ record.name }}</li>
          </ol>
        </nav>
      </div>
    </div>

    <section class="section">
      <!-- Summary -->
      <div class="row g-3 mb-4">
        <!-- Person Card -->
        <div class="col-md-4">
          <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden">
            <div class="summary-header p-3"></div>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="icon-circle">
                  <i class="bi bi-person-badge"></i>
                </div>
              </div>
              <div>
                <div class="text-muted small">{{ translate("Name") }}</div>
                <div class="fw-semibold">{{ record.name }}</div>
                <div class="small text-muted mt-1">
                  {{ record.designation ?? '-' }} · {{ record.contact ?? '-' }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Metrics (Out + Net only) -->
        <div class="col-md-8">
          <div class="card border-0 shadow-lg rounded-4 h-100">
            <div class="card-body d-grid metrics-grid">
               
              <div class="metric-tile highlight">
                <div class="d-flex justify-content-between align-items-center">
                  <span class="text-muted small">{{ translate("Net") }}</span>
                  <span class="badge rounded-pill" :class="totals.net >= 0 ? 'bg-success' : 'bg-danger'">
                    {{ totals.net >= 0 ? translate('In') : translate('Out') }}
                  </span>
                </div>
                <div class="fs-4 fw-bold">{{ formatCurrency(totals.net) }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Transactions (plain table) -->
      <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="card-title theme-text-color m-0">
              {{ translate("All Transactions for this record") }}
            </h5>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle m-0">
              <thead class="table-primary">
                <tr>
                  <th>#</th>
                  <th>{{ translate("Date") }}</th>
                  <th>{{ translate("Islamic date") }}</th>
                  <th>{{ translate("Receipt No") }}</th>
                  <th>{{ translate("Method") }}</th>
                  <th>{{ translate("Received From") }}</th>
                  <th>{{ translate("Received By") }}</th>
                  <th class="text-end">{{ translate("Amount") }}</th>
                  <th>{{ translate("Remarks") }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(t, i) in paged" :key="t.id">
                  <td class="text-muted">{{ indexBase + i + 1 }}</td>
                  <td>{{ t.transaction_date }}</td>
                  <td>{{ t.islamic_date }}</td>
                  <td>{{ t.ref_no }}</td>
                  <td>{{ t.method }}</td>
                  <td>{{ t.received_from ?? '-' }}</td>
                  <td>{{ t.received_by ?? '-' }}</td>
                  <td class="text-end text-danger">
                    -{{ formatCurrency(t.cash_out || 0) }}
                  </td>
                  <td class="small text-muted">{{ t.remarks ?? '-' }}</td>
                </tr>
                <tr v-if="!transactions.length">
                  <td colspan="9" class="text-center text-muted py-4">
                    {{ translate("No records found") }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
            <div class="d-flex align-items-center gap-2">
              <span class="text-muted small">{{ translate("Rows per page") }}</span>
              <select class="form-select form-select-sm w-auto"
                      v-model.number="perPage">
                <option v-for="s in pageSizes" :key="s" :value="s">{{ s }}</option>
              </select>
              <span class="text-muted small ms-2">
                {{ showingFrom }}–{{ showingTo }} {{ translate("of") }} {{ transactions.length }}
              </span>
            </div>
            <nav>
              <ul class="pagination mb-0">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                  <button class="page-link" @click="goPrev" :disabled="currentPage === 1">
                    {{ translate("Previous") }}
                  </button>
                </li>
                <li class="page-item" v-for="n in pages" :key="n" :class="{ active: n === currentPage }">
                  <button class="page-link" @click="goTo(n)">{{ n }}</button>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                  <button class="page-link" @click="goNext" :disabled="currentPage === totalPages">
                    {{ translate("Next") }}
                  </button>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
import Master from "../Layout/Master.vue";
import { Link } from '@inertiajs/vue3';

export default {
  layout: Master,
  name: 'OperatingAdvanceDetails',
  components: { Link },

  props: {
    record: { type: Object, required: true },
    transactions: { type: Array, default: () => [] },
    totals: { type: Object, default: () => ({ in: 0, out: 0, net: 0 }) },
  },

  data() {
    return {
      perPage: 10,
      currentPage: 1,
      pageSizes: [10, 20, 30, 50, 100],
    };
  },

  computed: {
    totalPages() {
      return Math.max(1, Math.ceil(this.transactions.length / this.perPage));
    },
    indexBase() {
      return (this.currentPage - 1) * this.perPage;
    },
    paged() {
      return this.transactions.slice(this.indexBase, this.indexBase + this.perPage);
    },
    pages() {
      return Array.from({ length: this.totalPages }, (_, i) => i + 1);
    },
    showingFrom() {
      return this.transactions.length ? this.indexBase + 1 : 0;
    },
    showingTo() {
      return Math.min(this.indexBase + this.perPage, this.transactions.length);
    },
  },

  methods: {
    goTo(n) { if (n >= 1 && n <= this.totalPages) this.currentPage = n; },
    goPrev() { if (this.currentPage > 1) this.currentPage--; },
    goNext() { if (this.currentPage < this.totalPages) this.currentPage++; },
    formatCurrency(v) {
      return new Intl.NumberFormat('en-PK', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
      }).format(v || 0);
    },
  },
};
</script>

<style scoped>
/* keep only non-table polish */
.summary-header{
  background: linear-gradient(90deg, rgba(28,13,130,0.12), rgba(28,13,130,0.02));
  min-height: 18px;
}
.icon-circle{
  width: 40px; height: 40px; border-radius: 50%;
  display: grid; place-items: center;
  background: rgba(28,13,130,0.08);
  color: #1C0D82;
  font-size: 1.1rem;
}
 
.metric-tile{
  background: #f8f9fb; border-radius: 18px; padding: 33px 16px; height: 100%; display: flex; flex-direction: column; justify-content: center; margin-top: 10px;
}
.metric-tile.highlight{ background: #f6f9ff; border: 1px dashed rgba(28,13,130,0.25); }
</style>
