<template>
    <div class="actions">
        <i
            class="bi bi-whatsapp text-success mt-1"
            title="Share on Whatsapp"
            @click="generateAndShare('whatsapp')"
        ></i>

        <i class="bi bi-download" @click="downloadPng" title="Download PNG"></i>
    </div>

    <!-- Hidden receipt captured as PNG -->
    <div ref="receiptRef" class="slip-root">
        <div class="slip-border">
            <!-- Top row: Book & Receipt -->
            <div class="top-row">
                <div class="book">
                    {{ translate("Book No") }} <span> {{ bookNo }} </span>
                </div>
                <div class="rec">
                    {{ translate("Receipt No") }}
                    <span> {{ entry.ref_no || "-" }} </span>
                </div>
            </div>

            <!-- Logo + Title -->
            <div class="logo-wrap">
                <img
                    class="logo"
                    src="https://jamianumaniapak.com/images/frontlogo.png"
                    alt="Logo"
                />
            </div>

            <div class="title">
                {{ translate("Jamia Darul Uloom Numania (Registered)") }}
            </div>
            <div class="place-box">
                {{ translate("Tehsil & District: Charsadda, Pakistan") }}
            </div>

            <!-- Date line -->
            <div class="line-row">
                <div class="amount-label">{{ translate("Amount") }}</div>
                <div class="line-flex">
                    {{ translate("Rs") }}
                    <span class="line"></span>
                    <span class="line mid">{{ translate("Month") }}</span>
                    <span class="line"></span>
                    <span class="line mid">{{ translate("Year") }}</span>
                    <span class="line"></span>
                </div>
            </div>

            <!-- Our filled rows (styled like the original ruled lines) -->
            <div class="filled">
                <div class="kv">
                    <span>{{ translate("Amount") }}:</span>
                    <span class="val">{{ formatCurrency(amount) }}</span>
                </div>
            </div>

            <div class="rule"></div>

            <div class="filled">
                <div class="kv">
                    <span>{{ translate("Benefactor / Donor") }}:</span>
                    <span class="val">{{ entry.received_from || "-" }}</span>
                </div>
            </div>

            <div class="rule"></div>

            <div class="filled">
                <div class="kv">
                    <span>{{ translate("Complete Address") }}:</span>
                    <span class="val">{{ entry.address || "-" }}</span>
                </div>
            </div>

            <div class="rule"></div>

            <div class="kv space-between">
                <div>
                    <span>{{ translate("Through") }}:</span>
                    <span class="val">{{ entry.method || "-" }}</span>
                </div>
                <div class="sig">
                    <div class="sig-line"></div>
                    <div class="sig-text">
                        {{ translate("Signature of Receiver") }}
                    </div>
                </div>
            </div>

            <div class="date-foot">
                {{ translate("Date") }}:
                <span class="line date">{{
                    entry.transaction_date || "-"
                }}</span>
                <span class="sep"></span>
                {{ translate("Islamic Date") }}:
                <span class="line date">{{ entry.islamic_date || "-" }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import html2canvas from "html2canvas";
import { ref, computed } from "vue";

const props = defineProps({
    entry: { type: Object, required: true },
    transactionEntries: { type: Array, required: true },
    indexForBalance: { type: Number, default: 0 },
    currency: { type: String, default: "Rs" },
    translate: { type: Function, default: (s) => s },
    bookNo: { type: String, default: "05" },
});

const t = (k) => (props.translate ? props.translate(k) : k);
const receiptRef = ref(null);

const amount = computed(() => {
    const direct = parseFloat(props.entry?.amount);
    if (!isNaN(direct) && direct > 0) return direct;
    const ci = parseFloat(props.entry?.cash_in) || 0;
    const co = parseFloat(props.entry?.cash_out) || 0;
    return ci || co || 0;
});

function formatCurrency(n) {
    const num = Number(n) || 0;
    return `${props.currency} ${num.toLocaleString()}`;
}

async function toDataUrl() {
    const el = receiptRef.value;
    const canvas = await html2canvas(el, { scale: 2, backgroundColor: "#fff" });
    return canvas.toDataURL("image/png");
}

async function generateAndShare() {
    const dataUrl = await toDataUrl();
    try {
        const blob = await (await fetch(dataUrl)).blob();
        const file = new File(
            [blob],
            `receipt-${props.entry?.ref_no || "txn"}.png`,
            { type: "image/png" }
        );

        if (navigator.canShare && navigator.canShare({ files: [file] })) {
            await navigator.share({
                title: t("Transaction Receipt"),
                text: t("Please find the receipt attached."),
                files: [file],
            });
            return;
        }
    } catch (_) {}
    // Desktop fallback
    const w = window.open();
    w.document.write(
        `<img src="${dataUrl}" style="width:100%; height:auto;"/>`
    );
    w.document.title = t("Receipt");
}

async function downloadPng() {
    const dataUrl = await toDataUrl();
    const a = document.createElement("a");
    a.href = dataUrl;
    a.download = `receipt-${props.entry?.ref_no || "txn"}.png`;
    a.click();
}
</script>

<style scoped>
/* Buttons */
.actions {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}
.btn {
    padding: 10px 14px;
    border-radius: 999px;
    border: none;
    cursor: pointer;
}
.btn-secondary {
    background: #1b2850;
    color: #fff;
}
.btn-wa {
    background: #25d366;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 8px;
}
.wa-icon {
    display: inline-flex;
}

/* Slip container: 720px wide looks crisp on A5 ratio */
.slip-root {
    position: fixed;
    left: -99999px;
    top: -99999px;
    width: 720px;
    background: #fff;
    padding: 18px;
    font-family: "Times New Roman", Georgia, serif;
    color: #000;
}

/* Outer border + padding */
.slip-border {
    border: 3px solid #000;
    border-radius: 8px;
    padding: 18px 18px 22px;
}

/* Top row like the original */
.top-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
    font-size: 20px;
    font-weight: 700;
}
.top-row .book span,
.top-row .rec span {
    border-bottom: 2px solid #000;
    padding: 0 10px;
}

/* Center logo */
.logo-wrap {
    display: flex;
    justify-content: center;
    margin: 6px 0 2px;
}
.logo {
    height: 72px;
    width: auto;
    object-fit: contain;
}

/* Title + place box */
.title {
    text-align: center;
    font-size: 28px;
    font-weight: 800;
    margin-top: 2px;
}
.place-box {
    text-align: center;
    display: inline-block;
    padding: 4px 12px;
    margin: 8px auto 8px;
    border: 2px solid #000;
    border-radius: 6px;
    font-size: 16px;
    display: block;
    width: max-content;
}

/* Amount/date thin row imitating the top ruled area */
.line-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 10px 2px 4px;
}
.amount-label {
    font-size: 18px;
    font-weight: 700;
}
.line-flex {
    display: flex;
    align-items: center;
    gap: 10px;
}
.line {
    display: inline-block;
    min-width: 160px;
    border-bottom: 2px solid #000;
    height: 0.9em;
}
.line.mid {
    min-width: 120px;
}

/* Horizontal rule lines */
.rule {
    height: 2px;
    background: #000;
    margin: 16px 0;
    opacity: 0.9;
}

/* Filled rows (label : value) aligned like lines */
.filled .kv {
    display: flex;
    gap: 12px;
    font-size: 18px;
}
.filled .kv .val {
    display: inline-block;
    min-width: 70%;
    border-bottom: 1px solid #000;
}

/* Spacing + signature block */
.kv.space-between {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    font-size: 18px;
}
.sig {
    width: 45%;
    text-align: center;
}
.sig-line {
    border-top: 1px solid #000;
    height: 0;
    margin-top: 26px;
}
.sig-text {
    font-size: 14px;
    margin-top: 6px;
}

/* Footer date row */
.date-foot {
    margin-top: 10px;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.date-foot .line.date {
    min-width: 160px;
    border-bottom: 1px solid #000;
}
.date-foot .sep {
    flex: 1;
}
</style>
