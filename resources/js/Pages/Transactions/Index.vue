<template>
    <main id="main" class="main">
        <div class="pagetitle d-flex justify-content-between">
            <div>
                <h1 class="theme-text-color">{{ translate("Transaction") }}</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">{{
                                translate("Darul Oloom")
                            }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            {{ translate("Transaction") }}
                        </li>
                        <li class="breadcrumb-item active">
                            {{ translate("Index") }}
                        </li>
                    </ol>
                </nav>
            </div>
            <div>
                <button
                    class="btn btn-success mt-3"
                    data-bs-toggle="modal"
                    ref="openTransactionModal"
                    data-bs-target="#transactionmodal"
                    @click="
                        clearFields();
                        form.process_type = ['Income'];
                        pluckExpIncTypes('Income');
                    "
                >
                    <i class="bi bi-arrow-down-circle"></i>
                    {{ translate("Income") }}
                </button>
                <button
                    class="btn btn-success mt-3 ms-2"
                    data-bs-toggle="modal"
                    ref="openTransactionModal"
                    data-bs-target="#transactionmodal"
                    @click="
                        clearFields();
                        form.process_type = ['Expense'];
                        pluckExpIncTypes('Expense');
                    "
                >
                    <i class="bi bi-arrow-up-circle"></i>
                    {{ translate("Expense") }}
                </button>
                <button
                    class="btn btn-success mt-3 ms-2"
                    data-bs-toggle="modal"
                    ref="openTransactionModal"
                    data-bs-target="#transactionmodal"
                    @click="
                        clearFields();
                        form.process_type = 'Advance';
                        pluckExpIncTypes('Advance');
                    "
                >
                    <i class="bi bi-cash-coin"></i>
                    {{ translate("Advance") }}
                </button>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5
                        class="card-title theme-text-color"
                        :class="{
                            'rtl-text':
                                $page.props.default_language === 'PK' ||
                                $page.props.default_language === 'SA',
                        }"
                    >
                        {{ translate("All Transaction Entries") }}
                    </h5>

                    <!-- Top right tools -->
                    <div
                        class="d-flex justify-content-between align-items-center gap-2 p-2"
                    >
                        <input
                            v-model.trim="tableQuery"
                            type="text"
                            class="form-control"
                            style="max-width: 260px"
                            :placeholder="
                                translate('Global search in table...')
                            "
                        />
                        <div class="dropdown">
                            <button
                                class="btn btn-light border dropdown-toggle"
                                data-bs-toggle="dropdown"
                            >
                                {{ translate("Export Options") }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a
                                        class="dropdown-item d-flex align-items-center"
                                        href="#"
                                        @click.prevent="exportToExcel"
                                    >
                                        <i
                                            class="bi bi-file-earmark-excel me-2 text-success"
                                        ></i>
                                        {{ translate("Export Excel") }}
                                    </a>
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item d-flex align-items-center"
                                        href="#"
                                        @click.prevent="exportToPDF"
                                    >
                                        <i
                                            class="bi bi-file-earmark-pdf me-2 text-danger"
                                        ></i>
                                        {{ translate("Export PDF") }}
                                    </a>
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item d-flex align-items-center"
                                        href="#"
                                        @click.prevent="printSlip"
                                    >
                                        <i class="bi bi-printer me-2"></i>
                                        {{ translate("Print List") }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Filters (kept intact) -->
                    <div class="card card-body p-2">
                        <div class="d-flex justify-content-between c-filter">
                            <div class="d-flex align-items-center gap-1">
                                <div class="col-auto">
                                    <Multiselect
                                        v-model="selectedFilter"
                                        :options="[
                                            'Monthly',
                                            'Yearly',
                                            'Custom',
                                        ]"
                                        :searchable="true"
                                        :placeholder="translate('Filter By')"
                                        @clear="fetchTransactionEntries"
                                    />
                                </div>

                                <div
                                    class="col-auto d-flex gap-2"
                                    v-if="selectedFilter === 'Monthly'"
                                >
                                    <div class="col-auto">
                                        <Multiselect
                                            v-model="selectedYear"
                                            :options="yearsOptions"
                                            :searchable="true"
                                            @clear="fetchTransactionEntries"
                                            :placeholder="
                                                translate('Select Year')
                                            "
                                        />
                                    </div>
                                    <div class="col-auto">
                                        <Multiselect
                                            v-model="selectedMonth"
                                            :options="monthsOptions"
                                            :searchable="true"
                                            @clear="fetchTransactionEntries"
                                            :placeholder="
                                                translate('Select Month')
                                            "
                                        />
                                    </div>
                                </div>

                                <div
                                    class="col-auto"
                                    v-if="selectedFilter === 'Yearly'"
                                >
                                    <Multiselect
                                        v-model="selectedYear"
                                        :options="yearsOptions"
                                        :searchable="true"
                                        @clear="fetchTransactionEntries"
                                        placeholder="Select Year"
                                    />
                                </div>

                                <div
                                    class="col-auto d-flex gap-2"
                                    v-if="selectedFilter === 'Custom'"
                                >
                                    <input
                                        type="date"
                                        class="form-control"
                                        v-model="startDate"
                                        :class="{
                                            'invalid-bg': formErrors.startDate,
                                        }"
                                        placeholder="Start Date"
                                    />
                                    <input
                                        type="date"
                                        class="form-control"
                                        v-model="endDate"
                                        :class="{
                                            'invalid-bg': formErrors.endDate,
                                        }"
                                        :placeholder="translate('End Date')"
                                    />
                                </div>

                                <div class="col-auto">
                                    <Multiselect
                                        v-model="filterTransactionType"
                                        :options="processTypeOptions"
                                        :placeholder="
                                            translate('Filter By Type')
                                        "
                                        :searchable="true"
                                        @clear="fetchTransactionEntries"
                                    />
                                </div>

                                <div class="col-auto">
                                    <button
                                        @click="fetchTransactionEntries"
                                        class="btn btn-success"
                                        :disabled="serachingLoading"
                                    >
                                        <span
                                            v-if="serachingLoading"
                                            class="spinner-border spinner-border-sm"
                                        ></span>
                                        <i v-else class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <span class="text-danger" v-if="FilterErrors">{{
                            FilterErrors
                        }}</span>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ translate("Date") }}</th>
                                    <th>{{ translate("Islamic date") }}</th>
                                    <th>{{ translate("Reciept No") }}</th>
                                    <th>{{ translate("Type") }}</th>
                                    <th>{{ translate("Cash In") }}</th>
                                    <th>{{ translate("Cash Out") }}</th>
                                    <th>{{ translate("Balance") }}</th>
                                    <th>{{ translate("Action") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(entry, idx) in visibleEntries"
                                    :key="entry.id"
                                >
                                    <td>{{ tableIndex(idx) }}</td>
                                    <td>{{ entry.transaction_date }}</td>
                                    <td>{{ entry.islamic_date }}</td>
                                    <td>{{ entry.ref_no }}</td>
                                    <td>
                                        {{
                                            entry.income_type ??
                                            entry.expense_type ??
                                            entry.advance_type
                                        }}
                                    </td>
                                    <td>
                                        {{ formatCurrency(entry.cash_in) ?? 0 }}
                                    </td>
                                    <td>
                                        {{
                                            formatCurrency(entry.cash_out) ?? 0
                                        }}
                                    </td>
                                    <td>
                                        {{ calculateBalance(globalIndex(idx)) }}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button
                                                class="btn btn-sm fs-6"
                                                title="View"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewTransactionModal"
                                                @click="
                                                    viewEntry(
                                                        entry,
                                                        globalIndex(idx)
                                                    )
                                                "
                                            >
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button
                                                class="btn btn-sm fs-6"
                                                title="Edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#transactionmodal"
                                                @click="
                                                    showEntry(entry.id);
                                                    clearFields();
                                                "
                                            >
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <DeleteModal
                                                :deleteId="entry.id"
                                                @deleteThis="deleteThis"
                                            />
                                            <!-- <button
                                                class="btn btn-sm fs-6"
                                                title="Print"
                                                @click="
                                                    printSingleSlip(
                                                        entry,
                                                        globalIndex(idx)
                                                    )
                                                "
                                            >
                                                <i class="bi bi-printer"></i>
                                            </button> -->

                                            <!-- <button
                                                class="btn btn-sm fs-6"
                                                title="Share"
                                                @click="
                                                    shareSlip(
                                                        entry,
                                                        globalIndex(idx)
                                                    )
                                                "
                                            >
                                                <i
                                                    class="bi bi-whatsapp text-success"
                                                ></i>
                                            </button> -->
                                            <ReceiptShare
                                                :entry="entry"
                                                :transactionEntries="
                                                    transactionEntries
                                                "
                                                :indexForBalance="
                                                    indexForBalance
                                                "
                                                :translate="translate"
                                                bookNo="05"
                                            />
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="!visibleEntries.length">
                                    <td
                                        colspan="9"
                                        class="text-center text-muted"
                                    >
                                        {{ translate("No records found") }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination + size -->
                    <div
                        class="d-flex justify-content-between align-items-center flex-wrap gap-2"
                    >
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-muted">
                                {{ translate("Rows per page") }}
                            </span>
                            <select
                                class="form-select form-select-sm"
                                style="width: 90px"
                                v-model.number="perPage"
                            >
                                <option
                                    v-for="s in pageSizes"
                                    :key="s"
                                    :value="s"
                                >
                                    {{ s }}
                                </option>
                            </select>
                            <span class="text-muted ms-2">
                                {{ showingFrom }}–{{ showingTo }}
                                {{ translate("of") }}
                                {{ filteredEntries.length }}
                            </span>
                        </div>
                        <nav>
                            <ul class="pagination mb-0">
                                <li
                                    class="page-item"
                                    :class="{ disabled: currentPage === 1 }"
                                >
                                    <button
                                        class="page-link"
                                        @click="goPrev"
                                        :disabled="currentPage === 1"
                                    >
                                        {{ translate("Previous") }}
                                    </button>
                                </li>
                                <li
                                    class="page-item"
                                    v-for="n in pages"
                                    :key="n"
                                    :class="{ active: n === currentPage }"
                                >
                                    <button class="page-link" @click="goTo(n)">
                                        {{ n }}
                                    </button>
                                </li>
                                <li
                                    class="page-item"
                                    :class="{
                                        disabled: currentPage === totalPages,
                                    }"
                                >
                                    <button
                                        class="page-link"
                                        @click="goNext"
                                        :disabled="currentPage === totalPages"
                                    >
                                        {{ translate("Next") }}
                                    </button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Add/Edit Modal (kept intact) -->
            <div
                class="modal fade"
                id="transactionmodal"
                tabindex="-1"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary" v-if="form.id">
                                {{ form.remarks }} - {{ form.method }}
                                <small>({{ form.date }})</small>
                            </h5>
                            <h5 class="modal-title text-primary" v-else>
                                {{ translate("New Transaction Entry") }}
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-body p-3">
                                <div class="row g-3">
                                    <div class="col-12 col-md-12 mb-3">
                                        <label>{{
                                            translate("Process Type")
                                        }}</label>
                                        <Multiselect
                                            v-model="form.process_type"
                                            :options="processTypeOptions"
                                            :searchable="false"
                                            readonly
                                            @select="
                                                pluckExpIncTypes(
                                                    form.process_type
                                                );
                                                clearProcessType();
                                            "
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.process_type,
                                            }"
                                        />
                                        <div
                                            class="invalid-feedback animated fadeIn"
                                            v-if="formErrors.process_type"
                                        >
                                            {{ formErrors.process_type[0] }}
                                        </div>
                                    </div>

                                    <div
                                        class="col-12 col-md-6"
                                        v-if="form.process_type == 'Income'"
                                    >
                                        <label>{{
                                            translate("Income Type")
                                        }}</label>
                                        <Multiselect
                                            v-model="form.income_type"
                                            :options="IncomeTypesOptions"
                                            :searchable="true"
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.income_type,
                                            }"
                                        />
                                        <div
                                            class="invalid-feedback animated fadeIn"
                                            v-if="formErrors.income_type"
                                        >
                                            {{ formErrors.income_type[0] }}
                                        </div>
                                    </div>

                                    <div
                                        class="col-12 col-md-6"
                                        v-if="form.process_type == 'Expense'"
                                    >
                                        <label>{{
                                            translate("Expense Type")
                                        }}</label>
                                        <Multiselect
                                            v-model="form.expense_type"
                                            :options="ExpenseTypesOptions"
                                            :searchable="true"
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.expense_type,
                                            }"
                                        />
                                        <div
                                            class="invalid-feedback animated fadeIn"
                                            v-if="formErrors.expense_type"
                                        >
                                            {{ formErrors.expense_type[0] }}
                                        </div>
                                    </div>

                                    <div
                                        class="col-12 col-md-6"
                                        v-if="form.process_type === 'Advance'"
                                    >
                                        <label>{{
                                            translate("Advance Type")
                                        }}</label>
                                        <Multiselect
                                            v-model="form.advance_type"
                                            :options="AdvanceTypesOptions"
                                            :searchable="true"
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.advance_type,
                                            }"
                                        />
                                        <div
                                            class="invalid-feedback animated fadeIn"
                                            v-if="formErrors.advance_type"
                                        >
                                            {{ formErrors.advance_type[0] }}
                                        </div>
                                    </div>

                                    <div
                                        class="col-12 col-md-6"
                                        v-if="
                                            form.process_type == 'Borrow' ||
                                            form.process_type == 'Lend'
                                        "
                                    >
                                        <label>{{ "Select person" }}</label>
                                        <Multiselect
                                            v-model="form.person"
                                            :options="personsOptions"
                                            :searchable="true"
                                            :class="{
                                                'invalid-bg': formErrors.person,
                                            }"
                                        />
                                        <div
                                            class="invalid-feedback animated fadeIn"
                                            v-if="formErrors.person"
                                        >
                                            {{ formErrors.person[0] }}
                                        </div>
                                    </div>

                                    <div
                                        class="col-md-6 col-12"
                                        v-if="
                                            form.process_type == 'Income' ||
                                            form.process_type == 'Borrow'
                                        "
                                    >
                                        <label for="cash_in">{{
                                            translate("Cash In")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="cash_in"
                                            v-model="form.cash_in"
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.cash_in,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.cash_in"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.cash_in[0] }}
                                        </div>
                                    </div>

                                    <div
                                        class="col-md-6 col-12"
                                        v-if="
                                            form.process_type == 'Expense' ||
                                            form.process_type == 'Lend' ||
                                            form.process_type == 'Advance'
                                        "
                                    >
                                        <label for="cash_out">{{
                                            translate("Cash Out")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="cash_out"
                                            v-model="form.cash_out"
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.cash_out,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.cash_out"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.cash_out[0] }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <label for="remarks">{{
                                            translate("Description")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="remarks"
                                            v-model="form.remarks"
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.remarks,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.remarks"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.remarks[0] }}
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label>{{
                                            translate("Payment Method")
                                        }}</label>
                                        <Multiselect
                                            v-model="form.method"
                                            :options="methodTypesOpions"
                                            :searchable="true"
                                            :class="{
                                                'invalid-bg': formErrors.method,
                                            }"
                                        />
                                        <div
                                            class="invalid-feedback animated fadeIn"
                                            v-if="formErrors.method"
                                        >
                                            {{ formErrors.method[0] }}
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{{
                                            translate("English Date")
                                        }}</label>
                                        <Datepicker
                                            autoApply
                                            :enable-time-picker="false"
                                            :class="{
                                                'invalid-bg': formErrors.date,
                                            }"
                                            v-model="form.date"
                                            @update:modelValue="convertToHijri"
                                        />
                                        <div
                                            v-if="formErrors.date"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.date[0] }}
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <label class="form-label">{{
                                            translate("Islamic Date")
                                        }}</label>
                                        <Datepicker
                                            v-model="form.islamic_date"
                                            :enable-time-picker="false"
                                            autoApply
                                            :disabled="true"
                                            :input-props="{ readonly: true }"
                                        />
                                        <div
                                            v-if="formErrors.islamic_date"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.islamic_date[0] }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <label>{{
                                            translate("Received from")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.received_from"
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.received_from,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.received_from"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.received_from[0] }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <label>{{
                                            translate("Received By")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.received_by"
                                            :class="{
                                                'invalid-bg':
                                                    formErrors.received_by,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.received_by"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.received_by[0] }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <label>{{
                                            translate("Reciept No")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.ref_no"
                                            :class="{
                                                'invalid-bg': formErrors.ref_no,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.ref_no"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.ref_no[0] }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <label>{{
                                            translate("Receipt image")
                                        }}</label>
                                        <br />
                                        <CropperOffCanvas
                                            @croppedImg="croppedImgPassToForm"
                                            accept=".jpg,.jpeg,.png"
                                        />
                                        <br />
                                        <img
                                            v-if="form.receipt_image"
                                            :src="
                                                form.receipt_image ??
                                                '/images/default.jpg'
                                            "
                                            :width="100"
                                        />
                                        <img
                                            v-else-if="existing_receipt_image"
                                            :src="
                                                existing_receipt_image ??
                                                '/images/default.jpg'
                                            "
                                            :width="100"
                                        />
                                        <img
                                            v-else
                                            :src="'/images/default.jpg'"
                                            :width="100"
                                        />
                                        <div
                                            v-if="formErrors.receipt_image"
                                            class="invalid-feedback"
                                        >
                                            {{ formErrors.receipt_image[0] }}
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button
                                            type="submit"
                                            class="btn btn-success"
                                            v-if="formStatus == 1"
                                            @click="submit"
                                        >
                                            Save
                                        </button>
                                        <button
                                            class="btn btn-success"
                                            type="button"
                                            disabled
                                            v-else
                                        >
                                            Saving
                                            <span
                                                class="spinner-border spinner-border-sm"
                                            ></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button
                    hidden
                    data-bs-toggle="modal"
                    data-bs-target="#customermodal"
                    ref="closeModal"
                ></button>
            </div>

            <!-- Details Modal -->
            <div
                class="modal fade"
                id="viewTransactionModal"
                tabindex="-1"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Transaction Details</h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                            ></button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Date</th>
                                        <td>
                                            {{ selectedEntry.transaction_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Islamic Date</th>
                                        <td>
                                            {{ selectedEntry.islamic_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Receipt No</th>
                                        <td>{{ selectedEntry.ref_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <td>
                                            {{
                                                selectedEntry.income_type ??
                                                selectedEntry.expense_type ??
                                                selectedEntry.advance_type
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Method</th>
                                        <td>{{ selectedEntry.method }}</td>
                                    </tr>
                                    <tr>
                                        <th>Received From</th>
                                        <td>
                                            {{ selectedEntry.received_from }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Received By</th>
                                        <td>{{ selectedEntry.received_by }}</td>
                                    </tr>
                                    <tr>
                                        <th>Cash In</th>
                                        <td>
                                            {{
                                                formatCurrency(
                                                    selectedEntry.cash_in
                                                )
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Cash Out</th>
                                        <td>
                                            {{
                                                formatCurrency(
                                                    selectedEntry.cash_out
                                                )
                                            }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Remarks</th>
                                        <td>{{ selectedEntry.remarks }}</td>
                                    </tr>
                                    <tr v-if="selectedEntry.receipt_image">
                                        <th>Receipt Image</th>
                                        <td>
                                            <img
                                                :src="
                                                    selectedEntry.receipt_image
                                                "
                                                width="200"
                                                @error="setAltImg"
                                            />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                Close
                            </button>
                            <button
                                class="btn btn-primary"
                                @click="
                                    printSingleSlip(
                                        selectedEntry,
                                        selectedIndex
                                    )
                                "
                            >
                                <i class="bi bi-printer me-1"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>

<script>
import axios from "axios";
import Master from "../Layout/Master.vue";
import ReceiptShare from "./ReceiptShare.vue";
import html2canvas from "html2canvas";
import Multiselect from "@vueform/multiselect";
import * as XLSX from "xlsx";
import jsPDF from "jspdf";
import "jspdf-autotable";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import moment from "moment-hijri";

window.onload = function () {
    window.downloadSlip = function () {
        html2canvas(document.getElementById("slipContent")).then((canvas) => {
            const link = document.createElement("a");
            link.download = "TransactionSlip.png";
            link.href = canvas.toDataURL();
            link.click();
        });
    };

    window.shareSlip = function () {
        html2canvas(document.getElementById("slipContent")).then((canvas) => {
            canvas.toBlob((blob) => {
                const file = new File([blob], "TransactionSlip.png", {
                    type: "image/png",
                });
                if (
                    navigator.canShare &&
                    navigator.canShare({ files: [file] })
                ) {
                    navigator
                        .share({
                            title: "Transaction Slip",
                            text: "Here is your receipt",
                            files: [file],
                        })
                        .catch(console.error);
                } else {
                    alert("Your browser doesn't support native sharing.");
                }
            });
        });
    };
};

export default {
    layout: Master,
    created() {
        this.process_type = "Income";
    },
    components: { Multiselect, Datepicker, html2canvas, ReceiptShare },
    data() {
        return {
            today: this.getPakistanDate(),
            transactionEntries: [],
            selectedFilter: "",
            selectedMonth: String(new Date().getMonth() + 1).padStart(2, "0"),
            selectedYear: String(new Date().getFullYear()),
            startDate: "",
            endDate: "",
            filterTransactionType: "",
            months: [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ],
            years: Array.from(
                { length: 10 },
                (_, i) => new Date().getFullYear() - i
            ),

            form: {
                id: "",
                cash_in: "",
                cash_out: "",
                date: "",
                islamic_date: "",
                ref_no: "",
                method: "",
                remarks: "",
                expense_type: "",
                income_type: "",
                advance_type: "",
                process_type: "",
                receipt_image: "",
                person: "",
                business_type: "",
                received_from: "",
                received_by: "",
            },
            formErrors: [],
            formStatus: 1,
            isCashInReadonly: false,
            isCashOutReadonly: false,
            ExpenseTypesOptions: [],
            IncomeTypesOptions: [],
            AdvanceTypesOptions: [],
            methodTypesOpions: ["Bank", "Cash"],
            processTypeOptions: [
                { label: "Expense (خرچ)", value: "Expense" },
                { label: "Income (آمدنی)", value: "Income" },
                { label: "Operating Advance (ادھار)", value: "Advance" },
            ],
            monthsOptions: [
                { value: 1, label: "January" },
                { value: 2, label: "February" },
                { value: 3, label: "March" },
                { value: 4, label: "April" },
                { value: 5, label: "May" },
                { value: 6, label: "June" },
                { value: 7, label: "July" },
                { value: 8, label: "August" },
                { value: 9, label: "September" },
                { value: 10, label: "October" },
                { value: 11, label: "November" },
                { value: 12, label: "December" },
            ],
            personsOptions: [],
            yearsOptions: Array.from(
                { length: 2050 - 2020 + 1 },
                (_, i) => 2020 + i
            ),
            existing_receipt_image: "",
            FilterErrors: "",
            serachingLoading: false,
            pdfBtnLoader: false,
            excelBtnLoader: false,
            printBtnLoader: false,

            selectedEntry: {},
            selectedIndex: -1,

            /* Table search + pagination */
            tableQuery: "",
            currentPage: 1,
            perPage: 10,
            pageSizes: [10, 20, 30, 50, 100],
        };
    },
    mounted() {
        this.fetchTransactionEntries();
        this.pluckPersons();
    },
    computed: {
        filteredEntries() {
            const q = (this.tableQuery || "").toLowerCase().trim();
            if (!q) return this.transactionEntries;
            return this.transactionEntries.filter((e) => {
                const type =
                    e.income_type || e.expense_type || e.advance_type || "";
                return [
                    e.transaction_date,
                    e.islamic_date,
                    e.ref_no,
                    type,
                    e.remarks,
                    e.method,
                    e.received_from,
                    e.received_by,
                    String(e.cash_in),
                    String(e.cash_out),
                ].some((v) => (v || "").toString().toLowerCase().includes(q));
            });
        },
        totalPages() {
            return Math.max(
                1,
                Math.ceil(this.filteredEntries.length / this.perPage)
            );
        },
        visibleEntries() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filteredEntries.slice(start, start + this.perPage);
        },
        pages() {
            const arr = [];
            for (let i = 1; i <= this.totalPages; i++) arr.push(i);
            return arr;
        },
        showingFrom() {
            if (!this.filteredEntries.length) return 0;
            return (this.currentPage - 1) * this.perPage + 1;
        },
        showingTo() {
            return Math.min(
                this.currentPage * this.perPage,
                this.filteredEntries.length
            );
        },
    },
    watch: {
        perPage() {
            this.currentPage = 1;
        },
        filteredEntries() {
            if (this.currentPage > this.totalPages)
                this.currentPage = this.totalPages;
        },
    },
    methods: {
        /* --- Helpers for table numbering --- */
        tableIndex(idxOnPage) {
            return (this.currentPage - 1) * this.perPage + idxOnPage + 1;
        },
        globalIndex(idxOnPage) {
            return (this.currentPage - 1) * this.perPage + idxOnPage;
        },

        /* --- Pagination buttons --- */
        goTo(n) {
            if (n >= 1 && n <= this.totalPages) this.currentPage = n;
        },
        goPrev() {
            if (this.currentPage > 1) this.currentPage--;
        },
        goNext() {
            if (this.currentPage < this.totalPages) this.currentPage++;
        },
        shareSlip(entry, indexForBalance) {
            let runningBalance = 0;
            for (let i = 0; i <= indexForBalance; i++) {
                const e = this.transactionEntries[i];
                runningBalance +=
                    (parseFloat(e.cash_in) || 0) -
                    (parseFloat(e.cash_out) || 0);
            }

            const text = `
------------------------------------------------
                 TRANSACTION RECEIPT
------------------------------------------------
Receipt No: ${entry.ref_no || "-"}
Date: ${entry.transaction_date || "-"}
Islamic Date: ${entry.islamic_date || "-"}

Type: ${entry.income_type || entry.expense_type || entry.advance_type || "-"}
Method: ${entry.method || "-"}

Received From: ${entry.received_from || "-"}
Received By:   ${entry.received_by || "-"}

Cash In:  ${this.formatCurrency(entry.cash_in || 0)}
Cash Out: ${this.formatCurrency(entry.cash_out || 0)}
Balance:  ${this.formatCurrency(runningBalance)}

Remarks: ${entry.remarks || "-"}
------------------------------------------------
`;

            const url = `https://wa.me/?text=${encodeURIComponent(text)}`;
            window.open(url, "_blank");
        },
        getPakistanDate() {
            const formatter = new Intl.DateTimeFormat("en-CA", {
                timeZone: "Asia/Karachi",
                year: "numeric",
                month: "2-digit",
                day: "2-digit",
            });
            const parts = formatter.formatToParts(new Date());
            const year = parts.find((p) => p.type === "year").value;
            const month = parts.find((p) => p.type === "month").value;
            const day = parts.find((p) => p.type === "day").value;
            return `${year}-${month}-${day}`;
        },
        clearProcessType() {
            this.form.cash_in = "";
            this.form.cash_out = "";
        },
        fetchTransactionEntries() {
            this.serachingLoading = true;
            this.FilterErrors = "";
            if (
                this.selectedFilter === "Monthly" &&
                (!this.selectedMonth || !this.selectedYear)
            ) {
                this.FilterErrors = this.translate(
                    "Please select both Month and Year for the Monthly filter."
                );
                this.serachingLoading = false;
                return;
            }
            if (this.selectedFilter === "Yearly" && !this.selectedYear) {
                this.FilterErrors = this.translate(
                    "Please select a Year for the Yearly filter."
                );
                this.serachingLoading = false;
                return;
            }
            if (
                this.selectedFilter === "Custom" &&
                (!this.startDate || !this.endDate)
            ) {
                this.FilterErrors = this.translate(
                    "Please select both Start Date and End Date for the Custom filter."
                );
                this.serachingLoading = false;
                return;
            }

            const formData = new FormData();
            formData.append("selectedFilter", this.selectedFilter);
            if (this.selectedMonth)
                formData.append("selectedMonth", this.selectedMonth);
            if (this.selectedYear)
                formData.append("selectedYear", this.selectedYear);
            if (this.startDate) formData.append("startDate", this.startDate);
            if (this.endDate) formData.append("endDate", this.endDate);
            if (this.filterTransactionType)
                formData.append("transaction_type", this.filterTransactionType);

            axios
                .post(route("api.transaction.fetch"), formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                })
                .then((response) => {
                    this.serachingLoading = false;
                    this.transactionEntries = response.data;
                    this.currentPage = 1;
                })
                .catch((error) => {
                    this.serachingLoading = false;
                    toastr.error(error.response.data.message);
                });
        },
        calculateBalance(index) {
            let balance = 0;
            for (let i = 0; i <= index; i++) {
                const e = this.transactionEntries[i];
                balance +=
                    (parseFloat(e.cash_in) || 0) -
                    (parseFloat(e.cash_out) || 0);
            }
            return this.formatCurrency(balance);
        },
        submit() {
            if (this.form.date)
                this.form.date = moment(this.form.date).format("YYYY/MM/DD");
            const formData = new FormData();
            const s = (v) => ((v ?? "").toString().trim() === "" ? "" : v);

            formData.append("id", s(this.form.id));
            formData.append("cash_in", s(this.form.cash_in));
            formData.append("cash_out", s(this.form.cash_out));
            formData.append("date", s(this.form.date));
            formData.append("islamic_date", s(this.form.islamic_date));
            formData.append("ref_no", s(this.form.ref_no));
            formData.append("method", s(this.form.method));
            formData.append("remarks", s(this.form.remarks));
            formData.append("person", s(this.form.person));
            formData.append("expense_type", s(this.form.expense_type));
            formData.append("income_type", s(this.form.income_type));
            formData.append("advance_type", s(this.form.advance_type));
            formData.append("process_type", s(this.form.process_type));
            formData.append("received_from", s(this.form.received_from));
            formData.append("received_by", s(this.form.received_by));
            if (this.form.receipt_image)
                formData.append("receipt_image", this.form.receipt_image);

            axios
                .post(route("api.transaction.store"), formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                })
                .then(() => {
                    this.formStatus = 1;
                    this.fetchTransactionEntries();
                    toastr.success(
                        this.translate("Transaction entry saved successfully.")
                    );
                    this.$refs.closeModal?.click();
                })
                .catch((error) => {
                    this.formStatus = 1;
                    toastr.error(error.response.data.message);
                    this.formErrors = error.response.data.errors;
                });
        },
        printSingleSlip(entry, indexForBalance) {
            let runningBalance = 0;
            for (let i = 0; i <= indexForBalance; i++) {
                const e = this.transactionEntries[i];
                runningBalance +=
                    (parseFloat(e.cash_in) || 0) -
                    (parseFloat(e.cash_out) || 0);
            }
            const currentDateTime = new Date().toLocaleString("en-US", {
                day: "2-digit",
                month: "short",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit",
                hour12: true,
            });
            const html = `
    <html>
    <head>
      <meta charset="utf-8" />
      <title>Receipt</title>
      <style>
        @page { size: 500mm auto; margin: 4mm; }
        @media print { body { -webkit-print-color-adjust: exact; print-color-adjust: exact; } }
        body { font-family: monospace; font-size: 14px; }
        .slip { width: 500mm; margin: 0 auto; }
        .center { text-align: center; }
        .title { font-weight: 700; font-size: 18px; margin-bottom: 6px; }
        .row { display:flex; justify-content:space-between; margin: 4px 0; }
        .dot { border-top: 1px dashed #000; margin: 8px 0; }
        .mt8 { margin-top: 8px; }
      </style>
    </head>
    <body>
      <div class="slip">
        <div class="center title">Transaction Receipt</div>
        <div class="center">Jamia Darul Uloom Noamaniya</div>
        <div class="dot"></div>
        <div class="row"><span>Date</span><span>${
            entry.transaction_date || "-"
        }</span></div>
        <div class="row"><span>Islamic Date</span><span>${
            entry.islamic_date || "-"
        }</span></div>
        <div class="row"><span>Receipt No</span><span>${
            entry.ref_no || "-"
        }</span></div>
        <div class="row"><span>Type</span><span>${
            entry.income_type || entry.expense_type || entry.advance_type || "-"
        }</span></div>
        <div class="row"><span>Method</span><span>${
            entry.method || "-"
        }</span></div>
        <div class="row"><span>Received From</span><span>${
            entry.received_from || "-"
        }</span></div>
        <div class="row"><span>Received By</span><span>${
            entry.received_by || "-"
        }</span></div>
        <div class="dot"></div>
        <div class="row"><span>Cash In</span><span>${this.formatCurrency(
            entry.cash_in || 0
        )}</span></div>
        <div class="row"><span>Cash Out</span><span>${this.formatCurrency(
            entry.cash_out || 0
        )}</span></div>
        <div class="row"><span>Balance (till this)</span><span>${this.formatCurrency(
            runningBalance
        )}</span></div>
        <div class="dot"></div>
        <div>Remarks: ${entry.remarks || "-"}</div>
        <div class="center mt8">Printed: ${currentDateTime}</div>
      </div>
      <script>window.onload = function(){ window.print(); window.close(); }<\/script>
    </body>
    </html>`;
            const w = window.open("", "_blank");
            w.document.write(html);
            w.document.close();
        },
        formatCurrency(value) {
            return new Intl.NumberFormat("en-PK", {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            }).format(value || 0);
        },
        clearFields() {
            this.form = {
                id: "",
                remarks: "",
                cash_in: "",
                cash_out: "",
                date: "",
                receipt_image: "",
                islamic_date: "",
                ref_no: "",
                method: "",
                expense_type: "",
                income_type: "",
                advance_type: "",
                process_type: "",
                person: "",
                business_type: "",
                received_from: "",
                received_by: "",
            };
            this.existing_receipt_image = "";
            this.formErrors = [];
        },
        showEntry(entry_id) {
            axios
                .get(route("api.transaction.show", entry_id))
                .then((response) => {
                    if (response.data.process_type === "Income")
                        this.pluckIncomeTypes();
                    if (response.data.process_type === "Expense")
                        this.pluckExpenseTypes();

                    this.form = {
                        id: response.data.id,
                        cash_in: parseInt(response.data.cash_in),
                        cash_out: response.data.cash_out,
                        date: response.data.transaction_date,
                        islamic_date: response.data.islamic_date,
                        ref_no: response.data.ref_no,
                        method: response.data.method,
                        received_from: response.data.received_from,
                        received_by: response.data.received_by,
                        remarks: response.data.remarks,
                        expense_type: response.data.expense_type || "",
                        income_type: response.data.income_type || "",
                        advance_type: response.data.advance_type || "",
                        process_type: response.data.process_type || "",
                        person: response.data.person || "",
                    };
                    this.existing_receipt_image = response.data.receipt_image;
                })
                .catch((error) => {
                    toastr.error(error.response.data.message);
                    this.formErrors = error.response.data.errors;
                });
        },
        deleteThis(id) {
            axios
                .delete(route("api.transaction.delete", id))
                .then(() => {
                    this.fetchTransactionEntries();
                    toastr.success("Transaction entry deleted successfully.");
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        pluckExpIncTypes(processType) {
            if (processType == "Income") this.pluckIncomeTypes();
            if (processType == "Expense") this.pluckExpenseTypes();
            if (processType == "Advance") this.pluckAdvanceTypes();
        },
        pluckIncomeTypes() {
            axios
                .get(route("api.income.pluck"))
                .then((response) => {
                    this.IncomeTypesOptions = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching income types:", error);
                });
        },
        pluckExpenseTypes() {
            axios
                .get(route("api.expense.pluck"))
                .then((response) => {
                    this.ExpenseTypesOptions = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching expense types:", error);
                });
        },
        pluckAdvanceTypes() {
            axios
                .get(route("api.advance.pluck"))
                .then((response) => {
                    this.AdvanceTypesOptions = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching advance types:", error);
                });
        },
        pluckPersons() {
            axios
                .get(route("api.persons.pluck"))
                .then((response) => {
                    this.personsOptions = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        exportToExcel() {
            this.excelBtnLoader = true;
            const formData = new FormData();
            formData.append("selectedFilter", this.selectedFilter);
            if (this.selectedMonth)
                formData.append("selectedMonth", this.selectedMonth);
            if (this.selectedYear)
                formData.append("selectedYear", this.selectedYear);
            if (this.startDate) formData.append("startDate", this.startDate);
            if (this.endDate) formData.append("endDate", this.endDate);
            if (this.filterTransactionType)
                formData.append("transaction_type", this.filterTransactionType);

            axios
                .post(route("download-excel"), formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                    responseType: "blob",
                })
                .then((response) => {
                    this.excelBtnLoader = false;
                    const url = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    const a = document.createElement("a");
                    a.href = url;
                    a.download = "transaction_report.xlsx";
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                })
                .catch((error) => {
                    this.excelBtnLoader = false;
                    toastr.error(
                        error.response?.data?.message ||
                            "Error generating Excel"
                    );
                });
        },
        exportToPDF() {
            this.pdfBtnLoader = true;
            const formData = new FormData();
            formData.append("selectedFilter", this.selectedFilter);
            if (this.selectedMonth)
                formData.append("selectedMonth", this.selectedMonth);
            if (this.selectedYear)
                formData.append("selectedYear", this.selectedYear);
            if (this.startDate) formData.append("startDate", this.startDate);
            if (this.endDate) formData.append("endDate", this.endDate);
            if (this.filterTransactionType)
                formData.append("transaction_type", this.filterTransactionType);

            axios
                .post(route("download-pdf"), formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                    responseType: "blob",
                })
                .then((response) => {
                    const link = document.createElement("a");
                    const url = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    link.href = url;
                    link.setAttribute("download", "TransactionReport.pdf");
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    this.pdfBtnLoader = false;
                })
                .catch((error) => {
                    this.pdfBtnLoader = false;
                    toastr.error(
                        error.response?.data?.message || "Error generating PDF"
                    );
                });
        },
        formatDate(date) {
            const d = new Date(date);
            return d.toLocaleDateString("en-US", {
                day: "2-digit",
                month: "short",
                year: "numeric",
            });
        },
        warning() {
            toastr.warning(
                "This feature is not added yet! Working in progress."
            );
        },
        croppedImgPassToForm(img) {
            this.form.receipt_image = img;
        },
        setAltImg(event) {
            event.target.src = "/images/default.jpg";
        },
        /* Main list print — kept the same as you asked */
        printSlip() {
            let printWindow = window.open("", "_blank");
            const getMonthName = (m) =>
                new Date(2025, m - 1, 1).toLocaleString("en-US", {
                    month: "long",
                });
            let currentDateTime = new Date().toLocaleString("en-US", {
                day: "2-digit",
                month: "short",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit",
                hour12: true,
            });
            let title = this.translate("All Transactions List");
            if (this.selectedFilter === "Monthly") {
                const monthName = getMonthName(this.selectedMonth);
                title = `${this.translate("Transactions for")} ${monthName} ${
                    this.selectedYear
                }`;
            } else if (this.selectedFilter === "Yearly" && this.selectedYear) {
                title = `${this.translate("Transactions for the Year")} ${
                    this.selectedYear
                }`;
            } else if (
                this.selectedFilter === "Custom" &&
                this.startDate &&
                this.endDate
            ) {
                title = `${this.translate(
                    "Transactions from"
                )} ${this.formatDate(this.startDate)} ${this.translate(
                    "to"
                )} ${this.formatDate(this.endDate)}`;
            }

            printWindow.document.write(`
        <html>
        <head>
            <style>
            .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
            .header img { height: 100px; }
            .title { font-size: 20px; font-weight: bold; margin-top: 10px; }
            body { font-family: Arial, sans-serif; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            th, td { border: 1px solid black; padding: 8px; text-align: left; font-size: 9px; }
            th { background-color: #f2f2f2; }
            .footer { text-align: right; font-size: 9px; margin-top: 20px; }
            </style>
        </head>
        <body>
            <div class="header">
                <img src="/images/logo.jpg" alt="Logo" />
                <div class="title">${title}</div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>${this.translate("Date")}</th>
                        <th>${this.translate("Islamic date")}</th>
                        <th>${this.translate("Receipt No")}</th>
                        <th>${this.translate("Type")}</th>
                        <th>${this.translate("Cash In")}</th>
                        <th>${this.translate("Cash Out")}</th>
                        <th>${this.translate("Balance")}</th>
                    </tr>
                </thead>
                <tbody>
                    ${this.transactionEntries
                        .map(
                            (entry, index) => `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${entry.transaction_date}</td>
                            <td>${entry.islamic_date}</td>
                            <td>${entry.ref_no}</td>
                            <td>${
                                entry.income_type ??
                                entry.expense_type ??
                                entry.advance_type
                            }</td>
                            <td>${this.formatCurrency(entry.cash_in) ?? 0}</td>
                            <td>${this.formatCurrency(entry.cash_out) ?? 0}</td>
                            <td>${this.calculateBalance(index)}</td>
                        </tr>
                    `
                        )
                        .join("")}
                </tbody>
            </table>
            <div class="footer">${this.translate(
                "Printed"
            )}: ${currentDateTime}</div>
        </body>
        </html>`);
            printWindow.document.close();
            printWindow.onload = function () {
                printWindow.print();
                printWindow.close();
            };
        },
        editTransaction() {},
        convertToHijri(date) {
            this.form.islamic_date = date
                ? moment(date).format("iYYYY/iM/iD")
                : "";
        },
        viewEntry(entry, idx) {
            this.selectedEntry = entry || {};
            this.selectedIndex = idx ?? -1;
        },
    },
};
</script>

<style scoped>
@import "@vueform/multiselect/themes/default.css";
.invalid-bg {
    border-color: #f8d4d4;
    background-color: #f8d4d4;
}
.invalid-feedback {
    color: red;
    font-size: 0.875rem;
}
.c-filter .multiselect {
    width: 200px !important;
}
</style>
