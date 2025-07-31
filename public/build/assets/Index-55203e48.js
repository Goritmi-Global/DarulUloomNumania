import{_ as g,a as u,r as _,o as d,c,b as t,t as l,n as D,g as h,f as m,w as b,v as y,F as v,h as x}from"./app-58615c0d.js";import T from"./Master-301b5c6c.js";import{s as E}from"./multiselect-5e7a5c57.js";import"./jspdf.plugin.autotable-9a7d287e.js";import{Z as F}from"./vue-datepicker-dee599f9.js";import"./main-ae0ebc8a.js";import"./defineProperty-4d844dfb.js";const C={layout:T,components:{Multiselect:E,Datepicker:F},data(){return{filterBusinessType:"",businessTypesOptions:[],transactionEntries:[],selectedFilter:"Yearly",selectedMonth:1,selectedYear:2025,startDate:"",endDate:"",monthsOptions:[{value:1,label:"January"},{value:2,label:"February"},{value:3,label:"March"},{value:4,label:"April"},{value:5,label:"May"},{value:6,label:"June"},{value:7,label:"July"},{value:8,label:"August"},{value:9,label:"September"},{value:10,label:"October"},{value:11,label:"November"},{value:12,label:"December"}],yearsOptions:Array.from({length:2050-2020+1},(e,s)=>2020+s),totalIncome:0,totalExpense:0,totalBalance:0,existing_receipt_image:"",FilterErrors:"",serachingLoading:!1,pdfBtnLoader:!1,excelBtnLoader:!1,printBtnLoader:!1}},mounted(){this.fetchTransactionEntries(),this.pluckBussinessTypes()},methods:{fetchTransactionEntries(){if(this.serachingLoading=!0,this.FilterErrors="",this.selectedFilter==="Monthly"&&(!this.selectedMonth||!this.selectedYear)){this.FilterErrors="Please select both Month and Year for the Monthly filter.",this.serachingLoading=!1;return}if(this.selectedFilter==="Yearly"&&!this.selectedYear){this.FilterErrors="Please select a Year for the Yearly filter.",this.serachingLoading=!1;return}if(this.selectedFilter==="Custom"&&(!this.startDate||!this.endDate)){this.FilterErrors="Please select both Start Date and End Date for the Custom filter.",this.serachingLoading=!1;return}let e=new FormData;e.append("selectedFilter",this.selectedFilter),this.selectedMonth&&e.append("selectedMonth",this.selectedMonth),this.selectedYear&&e.append("selectedYear",this.selectedYear),this.startDate&&e.append("startDate",this.startDate),this.endDate&&e.append("endDate",this.endDate),this.filterBusinessType&&e.append("businessType",this.filterBusinessType),u.post(route("api.transaction.report.fetch"),e,{headers:{"Content-Type":"multipart/form-data"}}).then(s=>{this.serachingLoading=!1,this.transactionEntries=s.data.transactionEntries,this.totalIncome=s.data.totalIncome,this.totalExpense=s.data.totalExpense,this.totalBalance=s.data.totalBalance}).catch(s=>{this.serachingLoading=!1,console.error(s)})},printSlip(){let e=window.open("","_blank"),s="All Transactions List";this.selectedFilter==="Monthly"&&this.selectedMonth?s=`Transactions for ${this.monthsOptions.find(a=>a.value===this.selectedMonth).label} ${this.selectedYear}`:this.selectedFilter==="Yearly"&&this.selectedYear?s=`Transactions for the Year ${this.selectedYear}`:this.selectedFilter==="Custom"&&this.startDate&&this.endDate&&(s=`Transactions from ${this.formatDate(this.startDate)} to ${this.formatDate(this.endDate)}`);let r=new Date().toLocaleString("en-US",{day:"2-digit",month:"short",year:"numeric",hour:"2-digit",minute:"2-digit",hour12:!0});e.document.write(`
                <html>
                <head>
                    <title>Transaction Slip</title>
                    <style>
            .header {
                    text-align: center;
                    border-bottom: 2px solid #000;
                    padding-bottom: 10px;
                    margin-bottom: 20px;
                }
                .header img {
                    height: 100px;
                }

                .title {
                    font-size: 20px;
                    font-weight: bold;
                    margin-top: 10px;
                }
                body { font-family: Arial, sans-serif; }
                h2 { text-align: center; margin-bottom: 20px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                th, td { border: 1px solid black; padding: 8px; text-align: left;font-size: 9px; }
                th { background-color: #f2f2f2; }
                .footer { text-align: right; font-size: 9px; margin-top: 20px; }
                
            </style>
                </head>
                <body>
                    <div class="header">
                <img src="/images/logo.jpg" alt="Logo" />
                <div class="title">${s}</div>
            </div>
                   
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>${this.translate("Date")}</th>
                                <th>${this.translate("Income")}</th>
                                <th>${this.translate("Expense")}</th>
                                <th>${this.translate("Balance")}</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${this.transactionEntries.map((n,a)=>`
                                <tr>
                                    <td>${a+1}</td>
                                    <td>${n.date}</td>
                                    <td>${this.formatCurrency(n.income)}</td>
                                    <td>${this.formatCurrency(n.expense)}</td>
                                    <td>${this.formatCurrency(n.balance)}</td>
                                </tr>
                            `).join("")}
                        </tbody>
                        <tfoot>
                                <tr>
                                    <th colspan="2">
                                        ${this.translate("Total")}
                                    </th>
                                    <th>
                                        ${this.formatCurrency(this.totalIncome||0)}
                                    </th>
                                    <th>
                                        ${this.formatCurrency(this.totalExpense||0)}
                                    </th>
                                    <th>
                                        ${this.formatCurrency(this.totalBalance||0)}
                                    </th>
                                </tr>
                            </tfoot>
                    </table>
                    <div class="footer">${this.translate("Printed")}: ${r}</div>
                </body>
                </html>
            `),e.document.close(),e.onload=function(){e.print(),e.close()}},exportToExcel(){this.excelBtnLoader=!0;let e=new FormData;e.append("selectedFilter",this.selectedFilter),this.selectedMonth&&e.append("selectedMonth",this.selectedMonth),this.selectedYear&&e.append("selectedYear",this.selectedYear),this.startDate&&e.append("startDate",this.startDate),this.endDate&&e.append("endDate",this.endDate),this.filterBusinessType&&e.append("businessType",this.filterBusinessType),u.post(route("download-report-excel"),e,{headers:{"Content-Type":"multipart/form-data"},responseType:"blob"}).then(s=>{const r=document.createElement("a"),n=window.URL.createObjectURL(new Blob([s.data]));r.href=n,r.setAttribute("download","TransactionReport.xlsx"),document.body.appendChild(r),r.click(),document.body.removeChild(r),this.excelBtnLoader=!1}).catch(s=>{var r,n;this.excelBtnLoader=!1,toastr.error(((n=(r=s.response)==null?void 0:r.data)==null?void 0:n.message)||"Error generating Excel")})},exportToPDF(){this.pdfBtnLoader=!0;let e=new FormData;e.append("selectedFilter",this.selectedFilter),this.selectedMonth&&e.append("selectedMonth",this.selectedMonth),this.selectedYear&&e.append("selectedYear",this.selectedYear),this.startDate&&e.append("startDate",this.startDate),this.endDate&&e.append("endDate",this.endDate),this.filterBusinessType&&e.append("businessType",this.filterBusinessType),u.post(route("download-report-pdf"),e,{headers:{"Content-Type":"multipart/form-data"},responseType:"blob"}).then(s=>{const r=document.createElement("a"),n=window.URL.createObjectURL(new Blob([s.data]));r.href=n,r.setAttribute("download","TransactionReport.pdf"),document.body.appendChild(r),r.click(),document.body.removeChild(r),this.pdfBtnLoader=!1}).catch(s=>{var r,n;this.pdfBtnLoader=!1,toastr.error(((n=(r=s.response)==null?void 0:r.data)==null?void 0:n.message)||"Error generating PDF")})},formatCurrency(e){return new Intl.NumberFormat("en-PK",{minimumFractionDigits:0,maximumFractionDigits:0}).format(e)},formatDate(e){return new Date(e).toLocaleDateString("en-US",{day:"2-digit",month:"short",year:"numeric"})},pluckBussinessTypes(){u.get(route("api.business.types.pluck")).then(e=>{this.businessTypesOptions=e.data}).catch(e=>{console.error(e)})}}},B={id:"main",class:"main"},Y={class:"pagetitle d-flex justify-content-between"},M={class:"theme-text-color"},L={class:"breadcrumb"},w={class:"breadcrumb-item"},k={href:"/dashboard"},S={class:"breadcrumb-item"},V={class:"breadcrumb-item active"},I={class:"section"},O={class:"card"},U={class:"card-body"},A={class:"d-flex justify-content-end p-2"},P={key:0,class:"btn-group",role:"group"},R={class:"card card-body p-2"},N={class:"d-flex justify-content-between align-items-center c-filter col-12"},j={class:"d-flex align-items-center gap-2"},z={class:"col-auto"},J={key:0,class:"col-auto d-flex gap-2"},K={class:"col-auto"},Z={class:"col-auto"},W={key:1,class:"col-auto"},q={key:2,class:"col-auto d-flex gap-2"},G={class:"col-auto"},H=["disabled"],Q={key:0,class:"spinner-border spinner-border-sm",role:"status","aria-hidden":"true"},X={key:1},$={key:0,class:"text-danger"},ee={key:0,class:"table-responsive"},te={class:"table table-striped"},se={scope:"col"},ae={scope:"col"},le={scope:"col"},re={scope:"col"},oe={scope:"row"},ne={colspan:"2"},ie={key:1},de={class:"text-center text-danger"};function ce(e,s,r,n,a,i){const p=_("Multiselect");return d(),c("main",B,[t("div",Y,[t("div",null,[t("h1",M,l(e.translate("Reports")),1),t("nav",null,[t("ol",L,[t("li",w,[t("a",k,l(e.translate("Darul Oloom")),1)]),t("li",S,l(e.translate("Reports")),1),t("li",V,l(e.translate("Index")),1)])])])]),t("section",I,[t("div",O,[t("div",U,[t("h5",{class:D(["card-title theme-text-color",{"rtl-text":e.$page.props.default_language==="PK"||e.$page.props.default_language==="SA"}])},l(e.translate("All Transaction & Reports"))+" "+l(a.selectedFilter),3),t("div",A,[a.transactionEntries&&a.transactionEntries.length?(d(),c("div",P,[t("button",{class:"btn btn-secondary",title:"Print",onClick:s[0]||(s[0]=(...o)=>i.printSlip&&i.printSlip(...o))},s[8]||(s[8]=[t("i",{class:"bi bi-printer"},null,-1)]))])):h("",!0)]),t("div",R,[t("div",N,[t("div",j,[t("div",z,[m(p,{modelValue:a.selectedFilter,"onUpdate:modelValue":s[1]||(s[1]=o=>a.selectedFilter=o),options:["Monthly","Yearly","Custom"],searchable:!0,placeholder:e.translate("Filter By"),onClear:i.fetchTransactionEntries},null,8,["modelValue","placeholder","onClear"])]),a.selectedFilter==="Monthly"?(d(),c("div",J,[t("div",K,[m(p,{modelValue:a.selectedYear,"onUpdate:modelValue":s[2]||(s[2]=o=>a.selectedYear=o),options:a.yearsOptions,searchable:!0,onClear:i.fetchTransactionEntries,placeholder:"Select Year"},null,8,["modelValue","options","onClear"])]),t("div",Z,[m(p,{modelValue:a.selectedMonth,"onUpdate:modelValue":s[3]||(s[3]=o=>a.selectedMonth=o),options:a.monthsOptions,searchable:!0,onClear:i.fetchTransactionEntries,placeholder:"Select Month"},null,8,["modelValue","options","onClear"])])])):h("",!0),a.selectedFilter==="Yearly"?(d(),c("div",W,[m(p,{modelValue:a.selectedYear,"onUpdate:modelValue":s[4]||(s[4]=o=>a.selectedYear=o),options:a.yearsOptions,searchable:!0,onClear:i.fetchTransactionEntries,placeholder:"Select Year"},null,8,["modelValue","options","onClear"])])):h("",!0),a.selectedFilter==="Custom"?(d(),c("div",q,[b(t("input",{type:"date",class:"form-control",id:"date","onUpdate:modelValue":s[5]||(s[5]=o=>a.startDate=o),placeholder:"Start Date"},null,512),[[y,a.startDate]]),b(t("input",{type:"date",class:"form-control",id:"date","onUpdate:modelValue":s[6]||(s[6]=o=>a.endDate=o),placeholder:"End Date"},null,512),[[y,a.endDate]])])):h("",!0),t("div",G,[t("button",{onClick:s[7]||(s[7]=(...o)=>i.fetchTransactionEntries&&i.fetchTransactionEntries(...o)),class:"btn btn-success",disabled:a.serachingLoading},[a.serachingLoading?(d(),c("span",Q)):h("",!0),a.serachingLoading?h("",!0):(d(),c("span",X,"Search"))],8,H)])])]),a.FilterErrors?(d(),c("span",$,l(a.FilterErrors),1)):h("",!0)]),a.transactionEntries.length?(d(),c("div",ee,[t("table",te,[t("thead",null,[t("tr",null,[s[9]||(s[9]=t("th",{scope:"col"},"#",-1)),t("th",se,l(a.selectedFilter==="Yearly"?"Month":"Date"),1),t("th",ae,l(e.translate("Income")),1),t("th",le,l(e.translate("Expense")),1),t("th",re,l(e.translate("Balance")),1)])]),t("tbody",null,[(d(!0),c(v,null,x(a.transactionEntries,(o,f)=>(d(),c("tr",{key:f},[t("th",oe,l(f+1),1),t("td",null,l(o.date),1),t("td",null,l(i.formatCurrency(o.income||0)),1),t("td",null,l(i.formatCurrency(o.expense||0)),1),t("td",null,l(i.formatCurrency(o.balance||0)),1)]))),128))]),t("tfoot",null,[t("tr",null,[t("th",ne,l(e.translate("Total")),1),t("th",null,l(i.formatCurrency(a.totalIncome||0)),1),t("th",null,l(i.formatCurrency(a.totalExpense||0)),1),t("th",null,l(i.formatCurrency(a.totalBalance||0)),1)])])])])):(d(),c("div",ie,[t("p",de,l(e.translate("No data available.")),1)]))])])])])}const ge=g(C,[["render",ce],["__scopeId","data-v-3057f2d3"]]);export{ge as default};
