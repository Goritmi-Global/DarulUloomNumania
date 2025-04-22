import{_ as w,a as u,r as y,o as l,c as a,b as o,t as i,e as v,n as m,g as c,f as h,w as _,v as b,F as C,h as F}from"./app-f05de1f7.js";import V from"./Master-e2c62fec.js";import{s as I}from"./multiselect-29487b10.js";import"./jspdf.plugin.autotable-85484191.js";import{Z as M}from"./vue-datepicker-a22e338b.js";import"./main-ae0ebc8a.js";import{m as E}from"./moment-hijri-0a5af13a.js";import"./defineProperty-4d844dfb.js";const L={layout:V,created(){this.process_type="Income"},components:{Multiselect:I,Datepicker:M},data(){return{today:this.getPakistanDate(),transactionEntries:[],selectedFilter:"",selectedMonth:String(new Date().getMonth()+1).padStart(2,"0"),selectedYear:String(new Date().getFullYear()),startDate:"",endDate:"",filterTransactionType:"",months:["January","February","March","April","May","June","July","August","September","October","November","December"],years:Array.from({length:10},(s,e)=>new Date().getFullYear()-e),transactionEntries:[],form:{id:"",cash_in:"",cash_out:"",date:"",islamic_date:"",ref_no:"",method:"",remarks:"",expense_type:"",income_type:"",process_type:"",receipt_image:"",person:"",business_type:"",received_from:"",received_by:""},formErrors:[],formStatus:1,isCashInReadonly:!1,isCashOutReadonly:!1,ExpenseTypesOptions:[],IncomeTypesOptions:[],methodTypesOpions:["Bank","Cash"],processTypeOptions:[{label:"Expense (خرچ)",value:"Expense"},{label:"Income (آمدنی)",value:"Income"}],monthsOptions:[{value:1,label:"January"},{value:2,label:"February"},{value:3,label:"March"},{value:4,label:"April"},{value:5,label:"May"},{value:6,label:"June"},{value:7,label:"July"},{value:8,label:"August"},{value:9,label:"September"},{value:10,label:"October"},{value:11,label:"November"},{value:12,label:"December"}],personsOptions:[],yearsOptions:Array.from({length:2050-2020+1},(s,e)=>2020+e),existing_receipt_image:"",FilterErrors:"",serachingLoading:!1,pdfBtnLoader:!1,excelBtnLoader:!1,printBtnLoader:!1}},mounted(){this.fetchTransactionEntries(),this.pluckPersons()},methods:{getPakistanDate(){let e=new Intl.DateTimeFormat("en-CA",{timeZone:"Asia/Karachi",year:"numeric",month:"2-digit",day:"2-digit"}).formatToParts(new Date),d=e.find(n=>n.type==="year").value,p=e.find(n=>n.type==="month").value,t=e.find(n=>n.type==="day").value;return`${d}-${p}-${t}`},clearProcessType(){this.form.cash_in="",this.form.cash_out=""},fetchTransactionEntries(){if(this.serachingLoading=!0,this.FilterErrors="",this.selectedFilter==="Monthly"&&(!this.selectedMonth||!this.selectedYear)){this.FilterErrors=this.translate("Please select both Month and Year for the Monthly filter."),this.serachingLoading=!1;return}if(this.selectedFilter==="Yearly"&&!this.selectedYear){this.FilterErrors=this.translate("Please select a Year for the Yearly filter."),this.serachingLoading=!1;return}if(this.selectedFilter==="Custom"&&(!this.startDate||!this.endDate)){this.FilterErrors=this.translate("Please select both Start Date and End Date for the Custom filter."),this.serachingLoading=!1;return}let s=new FormData;s.append("selectedFilter",this.selectedFilter),this.selectedMonth&&s.append("selectedMonth",this.selectedMonth),this.selectedYear&&s.append("selectedYear",this.selectedYear),this.startDate&&s.append("startDate",this.startDate),this.endDate&&s.append("endDate",this.endDate),this.filterTransactionType&&s.append("transaction_type",this.filterTransactionType),u.post(route("api.transaction.fetch"),s,{headers:{"Content-Type":"multipart/form-data"}}).then(e=>{this.serachingLoading=!1,this.transactionEntries=e.data}).catch(e=>{this.serachingLoading=!1,toastr.error(e.response.data.message)})},calculateBalance(s){let e=0;for(let d=0;d<=s;d++){const p=this.transactionEntries[d],t=parseFloat(p.cash_in)||0,n=parseFloat(p.cash_out)||0;e+=t,e-=n}return this.formatCurrency(e)},submit(){this.form.date&&(this.form.date=E(this.form.date).format("YYYY/MM/DD"));let s=new FormData;const e=d=>(d??"").toString().trim()===""?"":d;s.append("id",e(this.form.id)),s.append("cash_in",e(this.form.cash_in)),s.append("cash_out",e(this.form.cash_out)),s.append("date",e(this.form.date)),s.append("islamic_date",e(this.form.islamic_date)),s.append("ref_no",e(this.form.ref_no)),s.append("method",e(this.form.method)),s.append("remarks",e(this.form.remarks)),s.append("person",e(this.form.person)),s.append("expense_type",e(this.form.expense_type)),s.append("income_type",e(this.form.income_type)),s.append("process_type",e(this.form.process_type)),s.append("received_from",e(this.form.received_from)),s.append("received_by",e(this.form.received_by)),this.form.receipt_image&&s.append("receipt_image",this.form.receipt_image),u.post(route("api.transaction.store"),s,{headers:{"Content-Type":"multipart/form-data"}}).then(d=>{var p;this.formStatus=1,this.fetchTransactionEntries(),toastr.success(this.translate("Transaction entry saved successfully.")),(p=this.$refs.closeModal)==null||p.click(),this.printSingleSlip(d.data.transaction)}).catch(d=>{this.formStatus=1,toastr.error(d.response.data.message),this.formErrors=d.response.data.errors})},printSingleSlip(s){const e=window.open("","_blank"),d=new Date().toLocaleString("en-US",{day:"2-digit",month:"2-digit",year:"numeric",hour:"2-digit",minute:"2-digit",second:"2-digit",hour12:!0}),p=this.translate("Jamia Darul Uloom Noumania Utmanzai");e.document.write(`
    <html>
    <head>
        <title>Transaction Slip</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                padding: 20px;
                line-height: 1.6;
                color: #000;
            }

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

            .section {
                margin-bottom: 15px;
            }

            .section-title {
                font-weight: bold;
                margin-bottom: 5px;
                border-bottom: 1px dashed #000;
            }

            .field-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 5px;
            }

            .field-label {
                width: 35%;
                font-weight: bold;
            }

            .field-value {
                width: 60%;
                text-align: left;
            }

            .footer {
                margin-top: 30px;
                text-align: right;
                font-size: 12px;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <img src="/images/logo.jpg" alt="Logo" />
            <div class="title">${p}</div>
        </div>

        <div class="section">
            <div class="field-row">
                <div class="field-label">Date:</div>
                <div class="field-value">${s.transaction_date}</div>
            </div>
            <div class="field-row">
                <div class="field-label">Islamic Date:</div>
                <div class="field-value">${s.islamic_date}</div>
            </div>
            <div class="field-row">
                <div class="field-label">Receipt No:</div>
                <div class="field-value">${s.ref_no}</div>
            </div>
            <div class="field-row">
                <div class="field-label">Received From:</div>
                <div class="field-value">${s.received_from}</div>
            </div>
            <div class="field-row">
                <div class="field-label">Received By:</div>
                <div class="field-value">${s.received_by}</div>
            </div>
            <div class="field-row">
                <div class="field-label">Method:</div>
                <div class="field-value">${s.method}</div>
            </div>
            
            <div class="field-row">
                <div class="field-label">Cash In:</div>
                <div class="field-value">${this.formatCurrency(s.cash_in)??0}</div>
            </div>
            <div class="field-row">
                <div class="field-label">Cash Out:</div>
                <div class="field-value">${this.formatCurrency(s.cash_out)??0}</div>
            </div>
            <div class="field-row">
                <div class="field-label">Description:</div>
                <div class="field-value">${s.remarks}</div>
            </div>
        </div>

        <div class="footer">Printed on: ${d}</div>
    </body>
    </html>
    `),e.document.close(),e.onload=function(){e.print(),e.close()}},formatCurrency(s){return new Intl.NumberFormat("en-PK",{minimumFractionDigits:0,maximumFractionDigits:0}).format(s)},clearFields(){this.form={id:"",remarks:"",cash_in:"",cash_out:"",date:"",receipt_image:""},this.existing_receipt_image="",this.formErrors=[]},showEntry(s){u.get(route("api.transaction.show",s)).then(e=>{e.data.process_type==="Income"&&this.pluckIncomeTypes(),e.data.process_type==="Expense"&&this.pluckExpenseTypes(),this.form={id:e.data.id,cash_in:parseInt(e.data.cash_in),cash_out:e.data.cash_out,date:e.data.transaction_date,islamic_date:e.data.islamic_date,ref_no:e.data.ref_no,method:e.data.method,received_from:e.data.received_from,received_by:e.data.received_by,remarks:e.data.remarks,expense_type:e.data.expense_type||"",income_type:e.data.income_type||"",process_type:e.data.process_type||"",person:e.data.person||""},this.existing_receipt_image=e.data.receipt_image}).catch(e=>{toastr.error(e.response.data.message),this.formErrors=e.response.data.errors})},deleteThis(s){u.delete(route("api.transaction.delete",s)).then(()=>{this.fetchTransactionEntries(),toastr.success("Transaction entry deleted successfully.")}).catch(e=>{console.error(e)})},pluckExpIncTypes(s){s=="Income"&&this.pluckIncomeTypes(),s=="Expense"&&this.pluckExpenseTypes()},pluckIncomeTypes(){u.get(route("api.income.pluck")).then(s=>{this.IncomeTypesOptions=s.data}).catch(s=>{console.error("Error fetching income types:",s)})},pluckExpenseTypes(){u.get(route("api.expense.pluck")).then(s=>{this.ExpenseTypesOptions=s.data}).catch(s=>{console.error("Error fetching expense types:",s)})},pluckPersons(){u.get(route("api.persons.pluck")).then(s=>{this.personsOptions=s.data}).catch(s=>{console.error(s)})},exportToExcel(){this.excelBtnLoader=!0;let s=new FormData;s.append("selectedFilter",this.selectedFilter),this.selectedMonth&&s.append("selectedMonth",this.selectedMonth),this.selectedYear&&s.append("selectedYear",this.selectedYear),this.startDate&&s.append("startDate",this.startDate),this.endDate&&s.append("endDate",this.endDate),this.filterTransactionType&&s.append("transaction_type",this.filterTransactionType),u.post(route("download-excel"),s,{headers:{"Content-Type":"multipart/form-data"},responseType:"blob"}).then(e=>{this.excelBtnLoader=!1;const d=window.URL.createObjectURL(new Blob([e.data])),p=document.createElement("a");p.href=d,p.download="transaction_report.xlsx",document.body.appendChild(p),p.click(),document.body.removeChild(p)}).catch(e=>{var d,p;this.excelBtnLoader=!1,toastr.error(((p=(d=e.response)==null?void 0:d.data)==null?void 0:p.message)||"Error generating Excel")})},exportToPDF(){this.pdfBtnLoader=!0;let s=new FormData;s.append("selectedFilter",this.selectedFilter),this.selectedMonth&&s.append("selectedMonth",this.selectedMonth),this.selectedYear&&s.append("selectedYear",this.selectedYear),this.startDate&&s.append("startDate",this.startDate),this.endDate&&s.append("endDate",this.endDate),this.filterTransactionType&&s.append("transaction_type",this.filterTransactionType),u.post(route("download-pdf"),s,{headers:{"Content-Type":"multipart/form-data"},responseType:"blob"}).then(e=>{const d=document.createElement("a"),p=window.URL.createObjectURL(new Blob([e.data]));d.href=p,d.setAttribute("download","TransactionReport.pdf"),document.body.appendChild(d),d.click(),document.body.removeChild(d),this.pdfBtnLoader=!1}).catch(e=>{var d,p;this.pdfBtnLoader=!1,toastr.error(((p=(d=e.response)==null?void 0:d.data)==null?void 0:p.message)||"Error generating PDF")})},formatDate(s){return new Date(s).toLocaleDateString("en-US",{day:"2-digit",month:"short",year:"numeric"})},warning(){toastr.warning("This feature is not added yet! Working in progress.")},croppedImgPassToForm(s){this.form.receipt_image=s},setAltImg(s){s.target.src="/images/default.jpg"},printSlip(){let s=window.open("","_blank");const e=t=>new Date(2025,t-1,1).toLocaleString("en-US",{month:"long"});let d=new Date().toLocaleString("en-US",{day:"2-digit",month:"short",year:"numeric",hour:"2-digit",minute:"2-digit",hour12:!0}),p="All Transactions List";this.selectedFilter==="Monthly"?p=`Transactions for ${e(this.selectedMonth)} ${this.selectedYear}`:this.selectedFilter==="Yearly"&&this.selectedYear?p=`Transactions for the Year ${this.selectedYear}`:this.selectedFilter==="Custom"&&this.startDate&&this.endDate&&(p=`Transactions from ${this.formatDate(this.startDate)} to ${this.formatDate(this.endDate)}`),s.document.write(`
        <html>
        <head>
          
            <style>
                body { font-family: Arial, sans-serif; }
                h2 { text-align: center; margin-bottom: 20px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                th, td { border: 1px solid black; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .footer { text-align: right; font-size: 12px; margin-top: 20px; }
            </style>
        </head>
        <body>
            <h2>${p}</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Islamic date</th>
                        <th>Receipt No</th>
                 
                        <th>Descriptions</th>
                        <th>Method</th>
                        <th>Type</th>
                        <th>Cash In</th>
                        <th>Cash Out</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    ${this.transactionEntries.map((t,n)=>`
                        <tr>
                            <td>${n+1}</td>
                            <td>${t.transaction_date}</td>
                            <td>${t.islamic_date}</td>
                            <td>${t.ref_no}</td>
                  
                            <td>${t.remarks}</td>
                            <td>${t.method}</td>
                            <td>${t.income_type??t.expense_type}</td>
                            <td>${this.formatCurrency(t.cash_in)??0}</td>
                            <td>${this.formatCurrency(t.cash_out)??0}</td>
                            <td>${this.calculateBalance(n)}</td>
                        </tr>
                    `).join("")}
                </tbody>
            </table>
            <div class="footer">Printed: ${d}</div>
        </body>
        </html>
    `),s.document.close(),s.onload=function(){s.print(),s.close()}},editTransaction(s){this.$refs.openTransactionModal.click(),this.clearFields()},convertToHijri(s){this.form.islamic_date=s?E(s).format("iYYYY/iM/iD"):""}}},Y={id:"main",class:"main"},S={class:"pagetitle d-flex justify-content-between"},B={class:"theme-text-color"},O={class:"breadcrumb"},U={class:"breadcrumb-item"},P={href:"/dashboard"},R={class:"breadcrumb-item"},A={class:"breadcrumb-item active"},j={class:"section"},N={class:"card"},J={class:"card-body"},z={class:"d-flex justify-content-end p-2"},Z={key:0,class:"btn-group",role:"group"},K=["disabled"],W={key:0,class:"spinner-border spinner-border-sm",role:"status","aria-hidden":"true"},H={key:1},q=["disabled"],G={key:0,class:"spinner-border spinner-border-sm",role:"status","aria-hidden":"true"},Q={key:1},X={class:"card card-body p-2"},$={class:"d-flex justify-content-between align-items-center c-filter"},ee={class:"d-flex align-items-center gap-2"},te={class:"col-auto"},se={key:0,class:"col-auto d-flex gap-2"},oe={class:"col-auto"},re={class:"col-auto"},ie={key:1,class:"col-auto"},le={key:2,class:"col-auto d-flex gap-2"},ae=["placeholder"],ne={class:"col-auto"},de={class:"col-auto"},ce=["disabled"],pe={key:0,class:"spinner-border spinner-border-sm",role:"status","aria-hidden":"true"},me={key:1},he={key:0,class:"text-danger"},fe={class:"table-responsive"},ue={class:"table table-striped"},_e={scope:"col"},be={scope:"col"},ye={scope:"col"},ve={scope:"col"},ge={scope:"col"},ke={scope:"col"},Ee={scope:"col"},Te={scope:"col"},De={scope:"col"},xe={scope:"col"},we={scope:"col"},Ce={scope:"col"},Fe={scope:"col"},Ve={scope:"row"},Ie={class:"btn-group"},Me=["onClick"],Le={class:"modal fade",id:"transactionmodal",tabindex:"-1","aria-labelledby":"exampleModalLabel","aria-hidden":"true"},Ye={class:"modal-dialog modal-xl"},Se={class:"modal-content"},Be={class:"modal-header"},Oe={key:0,class:"modal-title text-primary"},Ue={key:1,class:"modal-title text-primary"},Pe={class:"modal-body"},Re={class:"card card-body p-3"},Ae={class:"row g-3"},je={class:"col-12 col-md-12 mb-3"},Ne={key:0,class:"invalid-feedback animated fadeIn"},Je={key:0,class:"col-12 col-md-6"},ze={key:0,class:"invalid-feedback animated fadeIn"},Ze={key:1,class:"col-12 col-md-6"},Ke={key:0,class:"invalid-feedback animated fadeIn"},We={key:2,class:"col-12 col-md-6"},He={key:0,class:"invalid-feedback animated fadeIn"},qe={key:3,class:"col-md-6 col-12"},Ge={for:"cash_in"},Qe={key:0,class:"invalid-feedback"},Xe={key:4,class:"col-md-6 col-12"},$e={for:"cash_out"},et={key:0,class:"invalid-feedback"},tt={class:"col-md-6 col-12"},st={for:"remarks"},ot={key:0,class:"invalid-feedback"},rt={class:"col-12 col-md-6"},it={key:0,class:"invalid-feedback animated fadeIn"},lt={class:"col-12 col-md-6"},at={for:"date",class:"form-label"},nt={key:0,class:"invalid-feedback"},dt={class:"col-12 col-md-6"},ct={for:"islamic_date",class:"form-label"},pt={key:0,class:"invalid-feedback"},mt={class:"col-md-6 col-12"},ht={for:"type"},ft={key:0,class:"invalid-feedback"},ut={class:"col-md-6 col-12"},_t={for:"type"},bt={key:0,class:"invalid-feedback"},yt={class:"col-md-6 col-12"},vt={for:"type"},gt={key:0,class:"invalid-feedback"},kt={class:"col-md-6 col-12"},Et={for:"receipt_image"},Tt=["src"],Dt=["src"],xt={key:2,src:"/images/default.jpg",width:100},wt={key:3,class:"invalid-feedback"},Ct={class:"mt-3"},Ft={key:1,class:"btn btn-success",type:"button",disabled:""},Vt={hidden:"","data-bs-toggle":"modal","data-bs-target":"#customermodal",ref:"closeModal"};function It(s,e,d,p,t,n){const f=y("Multiselect"),T=y("ImageZooming"),D=y("DeleteModal"),g=y("Datepicker"),x=y("CropperOffCanvas");return l(),a("main",Y,[o("div",S,[o("div",null,[o("h1",B,i(s.translate("Transaction")),1),o("nav",null,[o("ol",O,[o("li",U,[o("a",P,i(s.translate("Darul Oloom"))+"m",1)]),o("li",R,i(s.translate("Transaction")),1),o("li",A,i(s.translate("Index")),1)])])]),o("div",null,[o("button",{class:"btn btn-success mt-3","data-bs-toggle":"modal",ref:"openTransactionModal","data-bs-target":"#transactionmodal",onClick:e[0]||(e[0]=(...r)=>n.clearFields&&n.clearFields(...r))},[e[27]||(e[27]=o("i",{class:"bi bi-plus-lg"},null,-1)),v(" "+i(s.translate("New Transaction")),1)],512)])]),o("section",j,[o("div",N,[o("div",J,[o("h5",{class:m(["card-title theme-text-color",{"rtl-text":s.$page.props.default_language==="PK"||s.$page.props.default_language==="SA"}])},i(s.translate("All Transaction Entries")),3),o("div",z,[t.transactionEntries&&t.transactionEntries.length?(l(),a("div",Z,[o("button",{class:"btn btn-primary",title:"Download as Excel",onClick:e[1]||(e[1]=(...r)=>n.exportToExcel&&n.exportToExcel(...r)),disabled:t.excelBtnLoader},[t.excelBtnLoader?(l(),a("span",W)):c("",!0),t.excelBtnLoader?c("",!0):(l(),a("span",H,e[28]||(e[28]=[o("i",{class:"bi bi-file-earmark-excel"},null,-1)])))],8,K),o("button",{class:"btn btn-danger",title:"Download as PDF",onClick:e[2]||(e[2]=(...r)=>n.exportToPDF&&n.exportToPDF(...r)),disabled:t.pdfBtnLoader},[t.pdfBtnLoader?(l(),a("span",G)):c("",!0),t.pdfBtnLoader?c("",!0):(l(),a("span",Q,e[29]||(e[29]=[o("i",{class:"bi bi-file-earmark-pdf"},null,-1)])))],8,q),o("button",{class:"btn btn-secondary",title:"Print",onClick:e[3]||(e[3]=(...r)=>n.printSlip&&n.printSlip(...r))},e[30]||(e[30]=[o("i",{class:"bi bi-printer"},null,-1)]))])):c("",!0)]),o("div",X,[o("div",$,[o("div",ee,[o("div",te,[h(f,{modelValue:t.selectedFilter,"onUpdate:modelValue":e[4]||(e[4]=r=>t.selectedFilter=r),options:["Monthly","Yearly","Custom"],searchable:!0,placeholder:s.translate("Filter By"),onClear:n.fetchTransactionEntries},null,8,["modelValue","placeholder","onClear"])]),t.selectedFilter==="Monthly"?(l(),a("div",se,[o("div",oe,[h(f,{modelValue:t.selectedYear,"onUpdate:modelValue":e[5]||(e[5]=r=>t.selectedYear=r),options:t.yearsOptions,searchable:!0,onClear:n.fetchTransactionEntries,placeholder:s.translate("Select Year")},null,8,["modelValue","options","onClear","placeholder"])]),o("div",re,[h(f,{modelValue:t.selectedMonth,"onUpdate:modelValue":e[6]||(e[6]=r=>t.selectedMonth=r),options:t.monthsOptions,searchable:!0,onClear:n.fetchTransactionEntries,placeholder:s.translate("Select Month")},null,8,["modelValue","options","onClear","placeholder"])])])):c("",!0),t.selectedFilter==="Yearly"?(l(),a("div",ie,[h(f,{modelValue:t.selectedYear,"onUpdate:modelValue":e[7]||(e[7]=r=>t.selectedYear=r),options:t.yearsOptions,searchable:!0,onClear:n.fetchTransactionEntries,placeholder:"Select Year"},null,8,["modelValue","options","onClear"])])):c("",!0),t.selectedFilter==="Custom"?(l(),a("div",le,[_(o("input",{type:"date",class:m(["form-control",{"invalid-bg":t.formErrors.startDate}]),id:"date","onUpdate:modelValue":e[8]||(e[8]=r=>t.startDate=r),placeholder:"Start Date"},null,2),[[b,t.startDate]]),_(o("input",{type:"date",class:m(["form-control",{"invalid-bg":t.formErrors.endDate}]),id:"date","onUpdate:modelValue":e[9]||(e[9]=r=>t.endDate=r),placeholder:s.translate("End Date")},null,10,ae),[[b,t.endDate]])])):c("",!0),o("div",ne,[h(f,{modelValue:t.filterTransactionType,"onUpdate:modelValue":e[10]||(e[10]=r=>t.filterTransactionType=r),options:t.processTypeOptions,placeholder:s.translate("Filter By Type"),searchable:!0,onClear:n.fetchTransactionEntries},null,8,["modelValue","options","placeholder","onClear"])]),o("div",de,[o("button",{onClick:e[11]||(e[11]=(...r)=>n.fetchTransactionEntries&&n.fetchTransactionEntries(...r)),class:"btn btn-success",disabled:t.serachingLoading},[t.serachingLoading?(l(),a("span",pe)):c("",!0),t.serachingLoading?c("",!0):(l(),a("span",me,i(s.translate("Search")),1))],8,ce)])])]),t.FilterErrors?(l(),a("span",he,i(t.FilterErrors),1)):c("",!0)]),o("div",fe,[o("table",ue,[o("thead",null,[o("tr",null,[e[31]||(e[31]=o("th",{scope:"col"},"#",-1)),o("th",_e,i(s.translate("Date")),1),o("th",be,i(s.translate("Islamic date")),1),o("th",ye,i(s.translate("Reciept No")),1),o("th",ve,i(s.translate("Descriptions")),1),o("th",ge,i(s.translate("Method")),1),o("th",ke,i(s.translate("Type")),1),o("th",Ee,i(s.translate("Received From")),1),o("th",Te,i(s.translate("Received By")),1),o("th",De,i(s.translate("Cash In")),1),o("th",xe,i(s.translate("Cash Out")),1),o("th",we,i(s.translate("Balance")),1),o("th",Ce,i(s.translate("Reciept")),1),o("th",Fe,i(s.translate("Action")),1)])]),o("tbody",null,[(l(!0),a(C,null,F(t.transactionEntries,(r,k)=>(l(),a("tr",{key:r.id},[o("th",Ve,i(k+1),1),o("td",null,i(r.transaction_date),1),o("td",null,i(r.islamic_date),1),o("td",null,i(r.ref_no),1),o("td",null,i(r.remarks),1),o("td",null,i(r.method),1),o("td",null,i(r.income_type??r.expense_type),1),o("td",null,i(r.received_from),1),o("td",null,i(r.received_by),1),o("td",null,i(n.formatCurrency(r.cash_in)??0),1),o("td",null,i(n.formatCurrency(r.cash_out)??0),1),o("td",null,i(n.calculateBalance(k)),1),o("td",null,[h(T,{file:r.receipt_image??"/images/default.jpg",width:100},null,8,["file"])]),o("td",null,[o("div",Ie,[o("button",{class:"btn btn-sm fs-6",title:"Edit","data-bs-toggle":"modal","data-bs-target":"#transactionmodal",onClick:Mt=>{n.showEntry(r.id),n.clearFields()}},e[32]||(e[32]=[o("i",{class:"bi bi-pencil"},null,-1)]),8,Me),h(D,{deleteId:r.id,onDeleteThis:n.deleteThis},null,8,["deleteId","onDeleteThis"])])])]))),128))])])])])]),o("div",Le,[o("div",Ye,[o("div",Se,[o("div",Be,[t.form.id?(l(),a("h5",Oe,[v(i(t.form.remarks)+" - "+i(t.form.method)+" ",1),o("small",null,"("+i(t.form.date)+")",1)])):(l(),a("h5",Ue,i(s.translate("New Transaction Entry")),1)),e[33]||(e[33]=o("button",{type:"button",class:"btn-close","data-bs-dismiss":"modal","aria-label":"Close"},null,-1))]),o("div",Pe,[o("div",Re,[o("div",Ae,[o("div",je,[o("label",null,i(s.translate("Process Type")),1),h(f,{modelValue:t.form.process_type,"onUpdate:modelValue":e[12]||(e[12]=r=>t.form.process_type=r),options:t.processTypeOptions,searchable:!0,onSelect:e[13]||(e[13]=r=>(n.pluckExpIncTypes(t.form.process_type),n.clearProcessType())),class:m({"invalid-bg":t.formErrors.process_type})},null,8,["modelValue","options","class"]),t.formErrors.process_type?(l(),a("div",Ne,i(t.formErrors.process_type[0]),1)):c("",!0)]),t.form.process_type=="Income"?(l(),a("div",Je,[o("label",null,i(s.translate("Income Type")),1),h(f,{modelValue:t.form.income_type,"onUpdate:modelValue":e[14]||(e[14]=r=>t.form.income_type=r),options:t.IncomeTypesOptions,searchable:!0,class:m({"invalid-bg":t.formErrors.income_type})},null,8,["modelValue","options","class"]),t.formErrors.income_type?(l(),a("div",ze,i(t.formErrors.income_type[0]),1)):c("",!0)])):c("",!0),t.form.process_type=="Expense"?(l(),a("div",Ze,[o("label",null,i(s.translate("Expense Type")),1),h(f,{modelValue:t.form.expense_type,"onUpdate:modelValue":e[15]||(e[15]=r=>t.form.expense_type=r),options:t.ExpenseTypesOptions,searchable:!0,class:m({"invalid-bg":t.formErrors.expense_type})},null,8,["modelValue","options","class"]),t.formErrors.expense_type?(l(),a("div",Ke,i(t.formErrors.expense_type[0]),1)):c("",!0)])):c("",!0),t.form.process_type=="Borrow"||t.form.process_type=="Lend"?(l(),a("div",We,[e[34]||(e[34]=o("label",null,i("Select person"),-1)),h(f,{modelValue:t.form.person,"onUpdate:modelValue":e[16]||(e[16]=r=>t.form.person=r),options:t.personsOptions,searchable:!0,class:m({"invalid-bg":t.formErrors.person})},null,8,["modelValue","options","class"]),t.formErrors.person?(l(),a("div",He,i(t.formErrors.person[0]),1)):c("",!0)])):c("",!0),t.form.process_type=="Income"||t.form.process_type=="Borrow"?(l(),a("div",qe,[o("label",Ge,i(s.translate("Cash In")),1),_(o("input",{type:"text",class:m(["form-control",{"invalid-bg":t.formErrors.cash_in}]),id:"cash_in","onUpdate:modelValue":e[17]||(e[17]=r=>t.form.cash_in=r)},null,2),[[b,t.form.cash_in]]),t.formErrors.cash_in?(l(),a("div",Qe,i(t.formErrors.cash_in[0]),1)):c("",!0)])):c("",!0),t.form.process_type=="Expense"||t.form.process_type=="Lend"?(l(),a("div",Xe,[o("label",$e,i(s.translate("Cash Out")),1),_(o("input",{type:"text",class:m(["form-control",{"invalid-bg":t.formErrors.cash_out}]),id:"cash_out","onUpdate:modelValue":e[18]||(e[18]=r=>t.form.cash_out=r)},null,2),[[b,t.form.cash_out]]),t.formErrors.cash_out?(l(),a("div",et,i(t.formErrors.cash_out[0]),1)):c("",!0)])):c("",!0),o("div",tt,[o("label",st,i(s.translate("Description")),1),_(o("input",{type:"text",class:m(["form-control",{"invalid-bg":t.formErrors.remarks}]),id:"remarks","onUpdate:modelValue":e[19]||(e[19]=r=>t.form.remarks=r)},null,2),[[b,t.form.remarks]]),t.formErrors.remarks?(l(),a("div",ot,i(t.formErrors.remarks[0]),1)):c("",!0)]),o("div",rt,[o("label",null,i(s.translate("Payment Method")),1),h(f,{modelValue:t.form.method,"onUpdate:modelValue":e[20]||(e[20]=r=>t.form.method=r),options:t.methodTypesOpions,searchable:!0,class:m({"invalid-bg":t.formErrors.method})},null,8,["modelValue","options","class"]),t.formErrors.method?(l(),a("div",it,i(t.formErrors.method[0]),1)):c("",!0)]),o("div",lt,[o("label",at,i(s.translate("English Date")),1),h(g,{autoApply:"","enable-time-picker":!1,class:m({"invalid-bg":t.formErrors.date}),modelValue:t.form.date,"onUpdate:modelValue":[e[21]||(e[21]=r=>t.form.date=r),n.convertToHijri]},null,8,["class","modelValue","onUpdate:modelValue"]),t.formErrors.date?(l(),a("div",nt,i(t.formErrors.date[0]),1)):c("",!0)]),o("div",dt,[o("label",ct,i(s.translate("Islamic Date")),1),h(g,{modelValue:t.form.islamic_date,"onUpdate:modelValue":e[22]||(e[22]=r=>t.form.islamic_date=r),"enable-time-picker":!1,autoApply:"",disabled:!0,"input-props":{readonly:!0}},null,8,["modelValue"]),t.formErrors.islamic_date?(l(),a("div",pt,i(t.formErrors.islamic_date[0]),1)):c("",!0)]),o("div",mt,[o("label",ht,i(s.translate("Received from")),1),_(o("input",{type:"text",class:m(["form-control",{"invalid-bg":t.formErrors.received_from}]),id:"type","onUpdate:modelValue":e[23]||(e[23]=r=>t.form.received_from=r)},null,2),[[b,t.form.received_from]]),t.formErrors.received_from?(l(),a("div",ft,i(t.formErrors.received_from[0]),1)):c("",!0)]),o("div",ut,[o("label",_t,i(s.translate("Received By")),1),_(o("input",{type:"text",class:m(["form-control",{"invalid-bg":t.formErrors.received_by}]),id:"type","onUpdate:modelValue":e[24]||(e[24]=r=>t.form.received_by=r)},null,2),[[b,t.form.received_by]]),t.formErrors.received_by?(l(),a("div",bt,i(t.formErrors.received_by[0]),1)):c("",!0)]),o("div",yt,[o("label",vt,i(s.translate("Reciept No")),1),_(o("input",{type:"text",class:m(["form-control",{"invalid-bg":t.formErrors.ref_no}]),id:"type","onUpdate:modelValue":e[25]||(e[25]=r=>t.form.ref_no=r)},null,2),[[b,t.form.ref_no]]),t.formErrors.ref_no?(l(),a("div",gt,i(t.formErrors.ref_no[0]),1)):c("",!0)]),o("div",kt,[o("label",Et,i(s.translate("Receipt image")),1),e[35]||(e[35]=o("br",null,null,-1)),h(x,{onCroppedImg:n.croppedImgPassToForm,accept:".jpg,.jpeg,.png"},null,8,["onCroppedImg"]),e[36]||(e[36]=o("br",null,null,-1)),t.form.receipt_image?(l(),a("img",{key:0,src:t.form.receipt_image??"/images/default.jpg",width:100},null,8,Tt)):t.existing_receipt_image?(l(),a("img",{key:1,src:t.existing_receipt_image??"/images/default.jpg",width:100},null,8,Dt)):(l(),a("img",xt)),t.formErrors.receipt_image?(l(),a("div",wt,i(t.formErrors.receipt_image[0]),1)):c("",!0)]),o("div",Ct,[t.formStatus==1?(l(),a("button",{key:0,type:"submit",class:"btn btn-success",onClick:e[26]||(e[26]=(...r)=>n.submit&&n.submit(...r))}," Save ")):(l(),a("button",Ft,e[37]||(e[37]=[v(" Saving "),o("span",{class:"spinner-border spinner-border-sm"},null,-1)])))])])])])])]),o("button",Vt,null,512)])])])}const At=w(L,[["render",It],["__scopeId","data-v-1100d5f2"]]);export{At as default};
