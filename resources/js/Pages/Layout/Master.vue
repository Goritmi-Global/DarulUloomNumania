<template>
  <div
    class="main"
    :class="{
      'c-jameel-noori':
        $page.props.default_language === 'PK' ||
        $page.props.default_language === 'SA',
    }"
  >
    <!-- HEADER -->
    <header id="header" class="app-header fixed-top d-flex align-items-center">
      <div class="d-flex align-items-center justify-content-between w-100">
        <!-- Left: Logo + Toggle -->
        <div class="d-flex align-items-center gap-3">
          <button class="icon-btn d-lg-none" type="button">
            <i class="bi bi-list toggle-sidebar-btn"></i>
          </button>

          <a :href="route('dashboard')" class="logo d-flex align-items-center gap-2">
            <img :src="'/images/frontlogo.png'" alt="logo" class="logo-img" />
            <span class="logo-text">Darul Ul Oloom</span>
          </a>
        </div>

        <!-- Middle: quick link -->
        <a
          class="nav-link nav-icon ms-2 globe-link"
          :href="route('/')"
          target="_blank"
          title="Browse Website"
        >
          <i class="bi bi-globe"></i>
        </a>

        <!-- Right: language + profile -->
        <nav class="header-nav ms-auto">
          <ul class="d-flex align-items-center m-0">
            <!-- Language -->
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle lang-toggle"
                href="#"
                id="languageDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                {{ translate(user_language_name) }}
              </a>
              <ul class="dropdown-menu dropdown-menu-end c-global-radius languages" aria-labelledby="languageDropdown">
                <li
                  v-for="(language, index) in languages"
                  :key="index"
                  :class="language.code === $page.props.default_language ? 'lang-active' : ''"
                >
                  <a class="dropdown-item" href="javascript:void(0)" @click="changeLang(language.code)">
                    {{ language.name }}
                  </a>
                </li>
              </ul>
            </li>

            <!-- Mobile profile (md-) -->
            <li class="nav-item dropdown d-block d-lg-none">
              <a class="nav-link nav-profile d-flex align-items-center gap-2 pe-0" href="#" data-bs-toggle="dropdown">
                <span class="avatar-circle"><i class="bi bi-person"></i></span>
                <span class="dropdown-toggle">
                  {{ $page.props.user.first_name }} {{ $page.props.user.last_name }}
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-title px-3 pt-2 pb-1">
                  <small class="text-muted">{{ translate("Signed in as") }}</small>
                  <div class="fw-semibold">
                    {{ $page.props.user.first_name }} {{ $page.props.user.last_name }}
                  </div>
                </li>
                <li><hr class="dropdown-divider my-2" /></li>
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="/profile">
                    <i class="bi bi-gear"></i>
                    <span>{{ translate("Account Settings") }}</span>
                  </a>
                </li>
                <li><hr class="dropdown-divider my-2" /></li>
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="javascript:;" @click="logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>{{ translate("Sign Out") }}</span>
                  </a>
                </li>
              </ul>
            </li>

            <!-- Desktop profile -->
            <li class="nav-item dropdown pe-3 d-none d-lg-block">
              <a class="nav-link nav-profile d-flex align-items-center gap-2 pe-0" href="#" data-bs-toggle="dropdown">
                <span class="avatar-circle"><i class="bi bi-person"></i></span>
                <span class="dropdown-toggle user-name">
                  {{ $page.props.user.first_name }} {{ $page.props.user.last_name }}
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-title px-3 pt-2 pb-1">
                  <small class="text-muted">{{ translate("Signed in as") }}</small>
                  <div class="fw-semibold">
                    {{ $page.props.user.first_name }} {{ $page.props.user.last_name }}
                  </div>
                </li>
                <li><hr class="dropdown-divider my-2" /></li>
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="/profile">
                    <i class="bi bi-gear"></i>
                    <span>{{ translate("Account Settings") }}</span>
                  </a>
                </li>
                <li><hr class="dropdown-divider my-2" /></li>
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="javascript:;" @click="logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>{{ translate("Sign Out") }}</span>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </header>
    <!-- END HEADER -->

    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar pt-5">
      <ul class="sidebar-nav" id="sidebar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link" :class="{ active: isActive('/dashboard') }" href="/dashboard">
            <i class="bi bi-house-door"></i>
            <span>{{ translate("Dashboard") }}</span>
          </a>
        </li>

        <!-- Accounts -->
        <li
          class="nav-item"
          v-if="['superadmin', 'accountant'].includes($page.props.user.role)"
        >
          <a
            class="nav-link with-caret"
            :class="{ collapsed: !isParentActive(accountsLinks) }"
            data-bs-toggle="collapse"
            data-bs-target="#accounts-nav"
            href="#"
          >
            <i class="bi bi-wallet2"></i>
            <span>{{ translate("Accounts") }}</span>
            <i class="bi bi-chevron-down ms-auto caret"></i>
          </a>
          <ul
            id="accounts-nav"
            class="nav-content collapse"
            :class="{ show: isParentActive(accountsLinks) }"
            data-bs-parent="#sidebar-nav"
          >
            <li v-for="link in accountsLinks" :key="link.path">
              <a :href="link.path" :class="{ active: isActive(link.path) }">
                <i :class="link.icon"></i>
                <span>{{ translate(link.label) }}</span>
              </a>
            </li>
          </ul>
        </li>

        <!-- Students -->
        <li
          class="nav-item"
          v-if="['superadmin', 'admission'].includes($page.props.user.role)"
        >
          <a
            class="nav-link with-caret"
            :class="{ collapsed: !isParentActive(studentLinks) }"
            data-bs-toggle="collapse"
            data-bs-target="#students-nav"
            href="#"
          >
            <i class="bi bi-person-lines-fill"></i>
            <span>{{ translate("Students") }}</span>
            <i class="bi bi-chevron-down ms-auto caret"></i>
          </a>
          <ul
            id="students-nav"
            class="nav-content collapse"
            :class="{ show: isParentActive(studentLinks) }"
            data-bs-parent="#sidebar-nav"
          >
            <li v-for="link in studentLinks" :key="link.path">
              <a :href="link.path" :class="{ active: isActive(link.path) }">
                <i class="bi bi-chevron-right"></i>
                {{ translate(link.label) }}
              </a>
            </li>
          </ul>
        </li>


        <!-- Teachers  -->


         <li class="nav-item" v-if="$page.props.user.role === 'superadmin'">
          <a class="nav-link" :href="'/teachers'" :class="{ active: isActive('/teachers') }">
            <i class="bi bi-people-fill"></i>
            <span>{{ translate("Teachers") }}</span>
          </a>
        </li>


        <!-- Session Module -->
          <li class="nav-item" v-if="$page.props.user.role === 'superadmin'">
          <a class="nav-link" :href="'/sessions'" :class="{ active: isActive('/sessions') }">
            <i class="bi bi-people-fill"></i>
            <span>{{ translate("Sessions") }}</span>
          </a>
        </li>

         <li class="nav-item" v-if="$page.props.user.role === 'superadmin'">
          <a class="nav-link" :href="'/hostels'" :class="{ active: isActive('/hostels') }">
            <i class="bi bi-people-fill"></i>
            <span>{{ translate("Hostel") }}</span>
          </a>
        </li>
         

        <!-- Darul Iftah -->
        <li
          class="nav-item"
          v-if="['superadmin', 'iftah'].includes($page.props.user.role)"
        >
          <a
            class="nav-link with-caret"
            :class="{ collapsed: !isParentActive(iftahLinks) }"
            data-bs-toggle="collapse"
            data-bs-target="#darul-iftah-nav"
            href="#"
          >
            <i class="bi bi-journal-bookmark"></i>
            <span>{{ translate("Darul Iftah") }}</span>
            <i class="bi bi-chevron-down ms-auto caret"></i>
          </a>
          <ul
            id="darul-iftah-nav"
            class="nav-content collapse"
            :class="{ show: isParentActive(iftahLinks) }"
            data-bs-parent="#sidebar-nav"
          >
            <li v-for="link in iftahLinks" :key="link.path">
              <a :href="link.path" :class="{ active: isActive(link.path) }">
                <i class="bi bi-chevron-right"></i>
                {{ translate(link.label) }}
              </a>
            </li>
          </ul>
        </li>

        <!-- Users & Settings (superadmin) -->
        <li class="nav-item" v-if="$page.props.user.role === 'superadmin'">
          <a class="nav-link" :href="'/users'" :class="{ active: isActive('/users') }">
            <i class="bi bi-people-fill"></i>
            <span>{{ translate("Software Users") }}</span>
          </a>
        </li>
        <li class="nav-item" v-if="$page.props.user.role === 'superadmin'">
          <a
            class="nav-link with-caret"
            :class="{ collapsed: !isParentActive(['/languages']) }"
            data-bs-toggle="collapse"
            data-bs-target="#settings-nav"
            href="#"
          >
            <i class="bi bi-gear"></i>
            <span>{{ translate("Settings") }}</span>
            <i class="bi bi-chevron-down ms-auto caret"></i>
          </a>
          <ul
            id="settings-nav"
            class="nav-content collapse"
            :class="{ show: isParentActive(['/languages']) }"
            data-bs-parent="#sidebar-nav"
          >
            <li>
              <a :href="'/languages'" :class="{ active: isActive('/languages') }">
                <i class="bi bi-translate"></i>
                {{ translate("Languages") }}
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </aside>
    <!-- END SIDEBAR -->

    <!-- PAGE CONTENT -->
    <slot></slot>

    <!-- FOOTER -->
    <footer id="footer" class="footer bg-light text-center py-3">
      <div class="text-muted small">
        &copy; {{ new Date().getFullYear() }}
        {{ translate("Jamia Darol Uloom Noumania Utmanzai") }}.
        {{ translate("All Rights Reserved") }}<br />
        {{ translate("Designed by") }}
        <a href="https://goritmi.co.uk" target="_blank">Goritmi Ltd</a>
      </div>
    </footer>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      languages: [],
      user_language_name: "",
      accountsLinks: [
        { path: "/transactions",       label: "Transactions",       icon: "bi bi-cash" },
        { path: "/expense/types",      label: "Expense Types",      icon: "bi bi-dash-circle" },
        { path: "/income/types",       label: "Income Types",       icon: "bi bi-plus-circle" },
        { path: "/operating/advance",  label: "Operating Advance",  icon: "bi bi-plus-circle" },
        { path: "/income-statements",  label: "Income Statements",  icon: "bi bi-file-earmark-text" },
        { path: "/reports",            label: "Reports",            icon: "bi bi-bar-chart-line" },
      ],
      studentLinks: [
        { path: "/students",           label: "All Students" },
        { path: "/enrolled-students",  label: "Enrolled Students" },
      ],
      iftahLinks: [
        { path: "/introduction",       label: "Introduction" },
        { path: "/books",              label: "Books" },
        { path: "/bayanaat",           label: "Bayanaat" },
        { path: "/islamic-names",      label: "Islamic Names" },
        { path: "/questions-answers",  label: "Questions & Answers" },
      ],
    };
  },
  created() {
    this.fetchLanguages();
  },
  mounted() {
    // load external scripts (kept)
    const bootstrapJs = document.createElement("script");
    bootstrapJs.src = "/backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js";
    document.head.appendChild(bootstrapJs);

    const mainJs = document.createElement("script");
    mainJs.src = "/backend/assets/js/main.js";
    document.head.appendChild(mainJs);
  },
  methods: {
    isActive(route) {
      return this.$page.url === route || this.$page.url.startsWith(route + "/");
    },
    isParentActive(links) {
      return links.some((l) => this.$page.url.startsWith(l.path));
    },
    logout() {
      axios
        .post(
          route("api.logout"),
          {},
          { headers: { Authorization: "Bearer " + this.$page.props.auth_token } }
        )
        .then(() => this.$inertia.get(route("login")));
    },
    fetchLanguages() {
      axios
        .get(route("api.all.languages"), {
          headers: { Authorization: "Bearer " + this.$page.props.auth_token },
        })
        .then((res) => {
          this.languages = res.data;
          const userLang = res.data.find(
            (p) => p.code === this.$page.props.default_language
          );
          this.user_language_name = userLang ? userLang.name : "";
        });
    },
    changeLang(code) {
      const formData = new FormData();
      formData.append("default_language", code);
      axios.post(route("api.user.default.language"), formData).then(() => {
        window.location.reload();
      });
    },
  },
};
</script>

<style>
/* vendor bundles (keep) */
@import url("public/backend/assets/vendor/bootstrap/css/bootstrap.min.css");
@import url("public/backend/assets/vendor/bootstrap-icons/bootstrap-icons.css");
@import url("public/backend/assets/vendor/boxicons/css/boxicons.min.css");
@import url("public/backend/assets/vendor/remixicon/remixicon.css");
@import url("public/backend/assets/vendor/simple-datatables/style.css");
@import url("public/backend/assets/css/style.css");
@import url("public/backend/assets/css/custom.css");
@import "toastr";
@import "@vueform/multiselect/themes/default.css";
</style>

<style>
/* ===== Brand tokens ===== */
:root{
  --brand:#012970;           /* primary (your current theme) */
  --brand-ink:#0b1e4c;       /* darker text */
  --brand-soft:rgba(1,41,112,.14);
  --card:#ffffff;
  --shadow:0 10px 30px rgba(16,24,40,.08);
}

/* ===== Header ===== */
.app-header{
  background: linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,255,255,.86));
  backdrop-filter: saturate(160%) blur(6px);
  border-bottom: 1px solid var(--brand-soft);
  padding: .6rem .9rem;
  box-shadow: var(--shadow);
}
.icon-btn{
  border: 1px solid var(--brand-soft);
  background: var(--card);
  width: 42px; height: 42px;
  border-radius: 12px;
  display: grid; place-items:center;
  color: var(--brand-ink);
}
.logo-img{ height: 40px; }
.logo-text{
  font-weight: 800; letter-spacing: .2px; color: var(--brand-ink);
}
.globe-link{ color: var(--brand-ink); font-size: 1.05rem; }

/* Profile / language */
.avatar-circle{
  width: 34px; height: 34px; border-radius: 50%;
  background: var(--brand);
  display: grid; place-items:center;
  color: #fff;
}
.user-name{ color: var(--brand-ink); font-weight: 600; }
.lang-toggle{
  font-size: .92rem; font-weight: 700; color: var(--brand-ink);
}
.dropdown-menu.profile{
  border-radius: 14px;
  border: 1px solid var(--brand-soft);
  box-shadow: var(--shadow);
}
.dropdown-menu.profile .dropdown-item{
  padding: .55rem .9rem; border-radius: 10px;
}
.dropdown-menu.profile .dropdown-item:hover{
  background: rgba(1,41,112,.08);
  color: var(--brand-ink);
}
.languages .lang-active a{
  color:#fff !important; background: var(--brand) !important;
}

/* ===== Sidebar ===== */
.sidebar{
  background: var(--card);
  border-right: 1px solid var(--brand-soft);
  padding-top: 76px; /* under fixed header */
}
.sidebar-nav{
  padding: .75rem .75rem 1.25rem;
}
.sidebar-nav .nav-item{ margin-bottom: .25rem; }
.sidebar-nav .nav-link{
  display: flex; align-items: center; gap: .6rem;
  padding: .7rem .75rem;
  border-radius: 12px;
  color: var(--brand-ink);
  background: #fff;
  border: 1px solid transparent;
  transition: .15s ease;
  font-weight: 600;
}
.sidebar-nav .nav-link i{ color: var(--brand-ink); }
.sidebar-nav .nav-link:hover{
  border-color: var(--brand-soft);
  transform: translateY(-1px);
  box-shadow: var(--shadow);
}
.sidebar-nav .nav-link.active{
  background: rgba(1,41,112,.08);
  border-color: rgba(1,41,112,.22);
  color: var(--brand-ink);
}
.sidebar-nav .nav-link.with-caret .caret{ transition: transform .18s ease; }
.sidebar-nav .nav-link.active .caret{ transform: rotate(180deg); }

.sidebar-nav .nav-content{
  padding-left: 2.25rem;
  border-left: 2px dashed var(--brand-soft);
  margin: .35rem 0 .65rem .45rem;
}
.sidebar-nav .nav-content a{
  display: block;
  padding: .45rem .4rem;
  border-radius: 10px;
  color: var(--brand-ink);
  font-weight: 500;
}
.sidebar-nav .nav-content a:hover{ background: rgba(1,41,112,.06); }
.sidebar-nav .nav-content a.active{
  background: rgba(1,41,112,.12);
  color: var(--brand-ink);
  font-weight: 700;
}

/* ===== Footer ===== */
.footer{
  border-top: 1px solid var(--brand-soft);
  background: var(--card);
  color: var(--brand-ink);
}

/* ===== RTL font helpers (kept) ===== */
.c-jameel-noori { font-family: "Jameel Noori Nastaleeq", serif; font-size: 16px !important; }
.rtl-text { direction: rtl; text-align: right; font-family: "Jameel Noori Nastaleeq", serif; font-size: 16px !important; }
.rtl-text .nav ul { justify-content: flex-end !important; }

/* ===== Utilities / theme ===== */
.theme-text-color { color: var(--brand-ink) !important; font-weight: 700; }
.theme-bg-color   { background-color: var(--brand) !important; }
.text-primary     { color: var(--brand) !important; }

/* Multiselect tune */
.multiselect{
  --ms-border-color: var(--brand-soft);
  --ms-ring-color: rgba(1,41,112,.25);
  --ms-radius: 12px;
  --ms-option-bg-selected: var(--brand);
  --ms-option-color-selected: #fff;
  --ms-tag-bg: var(--brand);
  --ms-tag-color: #fff;
}

/* Small bits kept from your custom rules */
.section-title { text-align: left; padding-bottom: 5px; }
.section-title h5 { font-size: 22px; font-weight: bold; text-transform: uppercase; position: relative; color: var(--brand-ink); }

/* Toastr color alignment */
.toast-success { background-color: var(--brand) !important; }
</style>
