<template>
    <main id="main" class="main mb-3">
        <!-- Hero Section -->

        <section class="hero-section text-center text-white py-5">
            <div class="container">
                <h1 class="display-4 fw-bold">
                    {{ translate("New Student Enrollment") }}
                </h1>
                <p class="lead">
                    {{
                        translate(
                            "Providing quality Islamic education with modern learning techniques"
                        )
                    }}
                </p>
            </div>
        </section>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <section class="section mt-3 bg-whie">
                        <div class="">
                            <h1 class="display-4 p-3 theme-text-color">
                                {{ translate("Rule Regulations") }}
                            </h1>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card shadow-sm border-0">
                                        <div
                                            class="card-header bg-primary text-white"
                                        >
                                            <h5>
                                                {{
                                                    translate(
                                                        "Check Enrollment Status"
                                                    )
                                                }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-4 text-muted">
                                                {{
                                                    translate(
                                                        "Enter CNIC # to check your enrollment status."
                                                    )
                                                }}
                                            </p>

                                            <!-- CNIC Input -->
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    {{ translate("CNIC #") }}
                                                </label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="enrollCheckCnin"
                                                    placeholder="1234567890123"
                                                    :class="{
                                                        'is-invalid':
                                                            formErrors.enrollCheckCnin,
                                                    }"
                                                />
                                                <div
                                                    v-if="
                                                        formErrors.enrollCheckCnin
                                                    "
                                                    class="invalid-feedback"
                                                >
                                                    {{
                                                        formErrors
                                                            .enrollCheckCnin[0]
                                                    }}
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="mb-4">
                                                <button
                                                    class="btn btn-success w-100"
                                                    v-if="checkStatusBtn === 1"
                                                    @click="checkStatus"
                                                >
                                                    {{ translate("Check now") }}
                                                </button>
                                                <button
                                                    class="btn btn-secondary"
                                                    type="button"
                                                    disabled
                                                    v-else
                                                >
                                                    {{
                                                        translate("Checking...")
                                                    }}
                                                    <span
                                                        class="spinner-border spinner-border-sm ms-2"
                                                    ></span>
                                                </button>
                                            </div>

                                            <!-- Found -->
                                            <div
                                                v-if="admissionStatusDetails"
                                                class="alert alert-success border rounded p-3"
                                            >
                                                <h5 class="mb-3">
                                                    {{
                                                        translate(
                                                            "Enrollment Status Details"
                                                        )
                                                    }}
                                                </h5>
                                                <ul class="list-unstyled mb-0">
                                                    <li>
                                                        <strong
                                                            >{{
                                                                translate(
                                                                    "Name"
                                                                )
                                                            }}:</strong
                                                        >
                                                        {{
                                                            admissionStatusDetails.name
                                                        }}
                                                    </li>
                                                    <li>
                                                        <strong
                                                            >{{
                                                                translate(
                                                                    "CNIC"
                                                                )
                                                            }}:</strong
                                                        >
                                                        {{
                                                            admissionStatusDetails.cnic
                                                        }}
                                                    </li>
                                                    <li>
                                                        <strong
                                                            >{{
                                                                translate(
                                                                    "Father's Name"
                                                                )
                                                            }}:</strong
                                                        >
                                                        {{
                                                            admissionStatusDetails.father
                                                        }}
                                                    </li>
                                                    <li>
                                                        <strong
                                                            >{{
                                                                translate(
                                                                    "Applied For"
                                                                )
                                                            }}:</strong
                                                        >
                                                        {{
                                                            admissionStatusDetails.apply_for
                                                        }}
                                                    </li>
                                                    <li>
                                                        <strong
                                                            >{{
                                                                translate(
                                                                    "Status"
                                                                )
                                                            }}:</strong
                                                        >
                                                        {{
                                                            admissionStatusDetails.status ==
                                                            0
                                                                ? translate(
                                                                      "Under Review"
                                                                  )
                                                                : admissionStatusDetails.status ==
                                                                  1
                                                                ? translate(
                                                                      "Accepted"
                                                                  )
                                                                : admissionStatusDetails.status ==
                                                                  2
                                                                ? translate(
                                                                      "Pending"
                                                                  )
                                                                : admissionStatusDetails.status ==
                                                                  3
                                                                ? translate(
                                                                      "Rejected"
                                                                  )
                                                                : ""
                                                        }}
                                                    </li>
                                                </ul>
                                            </div>

                                            <!-- No Record -->
                                            <div
                                                v-else-if="
                                                    checkStatusBtn === 1 &&
                                                    noRecordFound
                                                "
                                                class="alert alert-warning mt-3"
                                            >
                                                {{
                                                    translate(
                                                        "No record found for the provided CNIC."
                                                    )
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="card shadow-sm border-0">
                                        <div
                                            class="card-header bg-primary text-white"
                                        >
                                            <h5>
                                                {{
                                                    translate("Course Duration")
                                                }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                {{
                                                    translate(
                                                        "Each course has a duration ranging from 6 months to 3 years, depending on the subject matter."
                                                    )
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="card shadow-sm border-0">
                                        <div
                                            class="card-header bg-primary text-white"
                                        >
                                            <h5>
                                                {{
                                                    translate(
                                                        "Course Requirements"
                                                    )
                                                }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                <li>
                                                    {{
                                                        translate(
                                                            "Basic understanding of Arabic (optional but recommended)"
                                                        )
                                                    }}
                                                </li>
                                                <li>
                                                    {{
                                                        translate(
                                                            "Commitment to daily learning and practice"
                                                        )
                                                    }}
                                                </li>
                                                <li>
                                                    {{
                                                        translate(
                                                            "Ability to read and write in Urdu or English"
                                                        )
                                                    }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="card shadow-sm border-0">
                                        <div
                                            class="card-header bg-primary text-white"
                                        >
                                            <h5>
                                                {{ translate("Madrassa Role") }}
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                {{
                                                    translate(
                                                        "Our institution provides a well-structured curriculum with experienced teachers and modern facilities to ensure a holistic Islamic education."
                                                    )
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-6">
                    <h1 class="display-4 p-3 mt-3 theme-text-color">
                        {{ translate("Enroll") }}
                    </h1>
                    
                        
                    <section class="section bg-white">
                        <div class="card shadow-sm border-0 shadow-lg">
                            <div class="card-body p-4">
                                <div class="row g-3">

                                    <div class="col-md-12">
                                        <label class="form-label">
                                            {{ translate("Have You Studied before Noumania?") }}
                                        </label>
                                        <Multiselect
                                            v-model="form.studiedBefore"
                                            :options="myOptions"
                                            :placeholder="translate('Please select')"
                                            :searchable="true"
                                            
                                            :multiple="true"
                                            :class="{ 'is-invalid': formErrors.studiedBefore }"
                                        />
                                        <div v-if="formErrors.studiedBefore" class="text-danger">
                                            {{ formErrors.studiedBefore[0] }}
                                        </div>
                                        </div>


                                        <div class="col-md-12" v-if="form.studiedBefore === 'Yes'">
                                        <label class="form-label">
                                            {{ translate("Registration Number") }}
                                        </label>

                                        <div class="input-group">
                                            <input 
                                            type="text" 
                                            id="regNo" 
                                            v-model="form.registrationNumber" 
                                            class="form-control" 
                                            :placeholder="translate('Enter Registration Number')"
                                            >
                                            <button 
                                            class="btn btn-primary" 
                                            type="button"
                                            @click="searchStudent"
                                            >
                                            {{translate('Search')}}
                                            </button>
                                        </div>

                                        <div v-if="formErrors.studiedBefore" class="text-danger">
                                            {{ translate(formErrors.studiedBefore[0]) }}
                                        </div>
                                        </div>

                                    <template v-if="form.studiedBefore !== 'Yes' || studentData">
                                    <!-- Apply For -->
                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Apply For")
                                        }}</label>
                                        <Multiselect
                                            v-model="form.apply_for"
                                            :options="filterOptions"
                                            :placeholder="
                                                translate('Select Course')
                                            "
                                            :searchable="true"
                                            :multiple="true"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.apply_for,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.apply_for"
                                            class="text-primary"
                                        >
                                            {{ formErrors.apply_for[0] }}
                                        </div>
                                    </div>

                                    <!-- Name -->
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Name")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.name"
                                            :class="{
                                                'is-invalid': formErrors.name,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.name"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.name[0]) }}
                                        </div>
                                    </div>

                                    <!-- Father's Name -->
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Fathers Name")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.father"
                                            :class="{
                                                'is-invalid': formErrors.father,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.father"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.father[0]) }}
                                        </div>
                                    </div>

                                    <!-- Registration Number  -->
                                      <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Registration Number")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.reg_no"
                                            :class="{
                                                'is-invalid': formErrors.reg_no,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.reg_no"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.reg_no[0]) }}
                                        </div>
                                    </div>

                                    <!-- CNIC -->
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("CNIC Number")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.cnic"
                                            :class="{
                                                'is-invalid': formErrors.cnic,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.cnic"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.cnic[0]) }}
                                        </div>
                                    </div>

                                    <!-- DOB -->
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Date of Birth")
                                        }}</label>
                                        <input
                                            type="date"
                                            class="form-control"
                                            v-model="form.dob"
                                            :class="{
                                                'is-invalid': formErrors.dob,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.dob"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.dob[0]) }}
                                        </div>
                                    </div>

                                    <!-- Country & Province Dropdowns -->
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Country")
                                        }}</label>

                                        <Multiselect
                                            v-model="form.country"
                                            :options="countryList"
                                            :placeholder="
                                                translate('Select country')
                                            "
                                            :searchable="true"
                                            :multiple="true"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.country,
                                            }"
                                        />
                                         <div
                                            v-if="formErrors.country"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.country[0]) }}
                                        </div>
                                    </div>

                                    <template v-if="form.country === 'Afghanistan'">
                                         <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Visa Number")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.visaNumber"
                                            :class="{
                                                'is-invalid': formErrors.dob,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.visaNumber"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.visaNumber[0]) }}
                                        </div>
                                    </div>
                                    </template>
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Province")
                                        }}</label>
                                        <Multiselect
                                            v-if="form.country == 'Pakistan'"
                                            v-model="form.province"
                                            :options="pakProvinceOptions"
                                            :placeholder="
                                                translate('Select province')
                                            "
                                            :searchable="true"
                                            :multiple="true"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.province,
                                            }"
                                        />
                                        <Multiselect
                                            v-if="form.country == 'Afghanistan'"
                                            v-model="form.province"
                                            :options="afgProvinceOptions"
                                            :placeholder="
                                                translate('Select province')
                                            "
                                            :searchable="true"
                                            :multiple="true"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.province,
                                            }"
                                        />
                                    </div>

                                    <!-- for District -->
                                    <template v-if="form.province">
  <div class="col-md-6">
    <label class="form-label">{{ translate("District") }}</label>
    <Multiselect
      v-model="form.district"
      :options="districtsByProvince[form.province] || []"
      :placeholder="translate('Select district')"
      :searchable="true"
      :class="{ 'is-invalid': formErrors.district }"
    />
  </div>
</template>
                                    <!-- Phone & WhatsApp -->
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Phone Number")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.phone_number"
                                            placeholder="+92 300 1234567"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.phone_number,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.phone_number"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.phone_number[0]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("WhatsApp Number")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.whatsapp"
                                            placeholder="+92 300 1234567"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.whatsapp,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.whatsapp"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.whatsapp[0]) }}
                                        </div>
                                    </div>

                                    <!-- Guardian Info -->
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Guardians Name")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.guardian_name"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.guardian_name,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.guardian_name"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.guardian_name[0]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Guardians CNIC")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.guardian_cnic"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.guardian_cnic,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.guardian_cnic"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.guardian_cnic[0]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Guardians Mobile")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.guardian_mobile"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.guardian_mobile,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.guardian_mobile"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.guardian_mobile[0]) }}
                                        </div>
                                    </div>

                                    <div class="col-md-6" v-if="studentData">
                                        <label class="form-label">{{
                                            translate("Are You Hostelite?")
                                        }}</label>
                                        <select v-model="form.hostelite" id="hostelite" class="form-select">
                                            <option disabled value="">{{translate('Please select')}}</option>
                                            <option value="yes">Yes (ہاں)</option>
                                              <option value="no">No (نہیں)</option>
                                        </select>
                                        <div
                                            v-if="formErrors.hostelite"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.hostelite[0]) }}
                                        </div>
                                    </div>


                                      <div class="col-md-12" v-if="form.hostelite === 'yes'">
                                        <label class="form-label">{{
                                            translate("Hostel Name")
                                        }}</label>
                                       <input type="text" id="regNo" v-model="form.hostelName" class="form-control">
                                        <div
                                            v-if="formErrors.hostelName"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.hostelName[0]) }}
                                        </div>
                                    </div>

   <!-- Classes  -->
                                        <div class="col-md-6">
                                            <label class="form-label">{{
                                                translate("Class")
                                            }}</label>
                                            <Multiselect v-model="form.class_id" :options="classOptions"
                                                placeholder="Select Class" :searchable="true" />

                                            <div v-if="formErrors.class_id" class="text-danger">
                                                {{ formErrors.class_id[0] }}
                                            </div>
                                        </div>

                                    <!-- Academic Info -->
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Previous Madrasa Name")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.previous_madrasa"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.previous_madrasa,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.previous_madrasa"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.previous_madrasa[0]) }}
                                        </div>
                                    </div>
                                    <template v-if="form.apply_for !== 'متوسطا'">
                                    <div class="col-md-6">
                                        <label class="form-label">{{
                                            translate("Previous Class")
                                        }}</label>
                                        <Multiselect
                                            v-model="form.previous_class"
                                            :options="previousClassOptions"
                                            :placeholder="
                                                translate('Select Course')
                                            "
                                            :searchable="true"
                                            :multiple="true"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.previous_class,
                                            }"
                                        />

                                        <div
                                            v-if="formErrors.previous_class"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.previous_class[0]) }}
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-3">
                                        <label class="form-label">{{
                                            translate("Total Marks")
                                        }}</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="form.total_marks"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.total_marks,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.total_marks"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.total_marks[0]) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">{{
                                            translate("Obtained Marks")
                                        }}</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="form.obtained_marks"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.obtained_marks,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.obtained_marks"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.obtained_marks[0]) }}
                                        </div>
                                    </div>
  </template>
                                    
                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Secular Education")
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.primary_education"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.primary_education,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.primary_education"
                                            class="text-danger"
                                        >
                                            {{
                                                translate(formErrors.primary_education[0])
                                            }}
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate(
                                                "Additional Qualifications"
                                            )
                                        }}</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="form.additional_ability"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.additional_ability,
                                            }"
                                        />
                                        <div
                                            v-if="formErrors.additional_ability"
                                            class="text-danger"
                                        >
                                            {{
                                                translate(formErrors.additional_ability[0])
                                            }}
                                        </div>
                                    </div>

                                    <!-- Addresses -->
                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Permanent Address")
                                        }}</label>
                                        <textarea
                                            class="form-control"
                                            rows="2"
                                            v-model="form.permanent_address"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.permanent_address,
                                            }"
                                        ></textarea>

                                        <div
                                            v-if="formErrors.permanent_address"
                                            class="text-danger"
                                        >
                                            {{
                                                translate(formErrors.permanent_address[0])
                                            }}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">{{
                                            translate("Current Address")
                                        }}</label>
                                        <textarea
                                            class="form-control"
                                            rows="2"
                                            v-model="form.current_address"
                                            :class="{
                                                'is-invalid':
                                                    formErrors.current_address,
                                            }"
                                        ></textarea>
                                        <div
                                            v-if="formErrors.current_address"
                                            class="text-danger"
                                        >
                                            {{ translate(formErrors.current_address[0]) }}
                                        </div>
                                    </div>
                                 <div class="row mt-3">
  <!-- Upload Image -->
  <div class="col-md-3">
    <div class="c-files">
      <span class="col-form-label mt-1">{{translate('Upload Image')}}</span>
      <br />
      <Cropper
        @croppedImg="croppedImgSubmit"
        accept=".jpg,.jpeg,.png"
      />
      <br />
      <ImageZooming
        v-if="form.image"
        :file="form.image"
        :width="100"
      />
      <ImageZooming
        v-else
        :file="existing_image ?? '/images/default.jpg'"
        :width="100"
      />
    </div>
    <div class="invalid-feedback animated fadeIn" v-if="formErrors.image">
      {{ formErrors.image[0] }}
    </div>
  </div>

  <!-- CNIC Front -->
  <div class="col-md-3">
    <div class="c-files">
      <span class="col-form-label mt-1">{{translate('CNIC Front')}}</span>
      <br />
      <Cropper
        @croppedImg="cropCNICFront"
        accept=".jpg,.jpeg,.png"
      />
      <br />
      <ImageZooming
        v-if="form.cnic_front"
        :file="form.cnic_front"
        :width="100"
      />
      <ImageZooming
        v-else
        :file="existing_cnic_front ?? '/images/default.jpg'"
        :width="100"
      />
    </div>
    <div class="invalid-feedback animated fadeIn" v-if="formErrors.cnic_front">
      {{ formErrors.cnic_front[0] }}
    </div>
  </div>

  <!-- CNIC Back -->
  <div class="col-md-3">
    <div class="c-files">
      <span class="col-form-label mt-1">{{translate('CNIC Back')}}</span>
      <br />
      <Cropper
        @croppedImg="cropCNICBack"
        accept=".jpg,.jpeg,.png"
      />
      <br />
      <ImageZooming
        v-if="form.cnic_back"
        :file="form.cnic_back"
        :width="100"
      />
      <ImageZooming
        v-else
        :file="existing_cnic_back ?? '/images/default.jpg'"
        :width="100"
      />
    </div>
    <div class="invalid-feedback animated fadeIn" v-if="formErrors.cnic_back">
      {{ formErrors.cnic_back[0] }}
    </div>
  </div>

  <!-- Payment Receipt -->
  <div class="col-md-3">
    <div class="c-files">
      <span class="col-form-label mt-1">{{translate('Payment Image')}}</span>
      <br />
      <Cropper
        @croppedImg="cropReceipt"
        accept=".jpg,.jpeg,.png"
      />
      <br />
      <ImageZooming
        v-if="form.payment_receipt"
        :file="form.payment_receipt"
        :width="100"
      />
      <ImageZooming
        v-else
        :file="existing_payment_receipt ?? '/images/default.jpg'"
        :width="100"
      />
    </div>
    <div class="invalid-feedback animated fadeIn" v-if="formErrors.payment_receipt">
      {{ formErrors.payment_receipt[0] }}
    </div>
  </div>
</div>



                                    <!-- Submit -->
                                    <div class="mt-4">
                                        <button
                                            type="submit"
                                            class="btn btn-success px-4 w-100"
                                            v-if="formStatus === 1"
                                            @click="submit"
                                        >
                                            {{ translate("Enroll Now") }}
                                        </button>
                                        <button
                                            class="btn btn-secondary px-4"
                                            type="button"
                                            disabled
                                            v-else
                                        >
                                            {{ translate("Processing...") }}
                                            <span
                                                class="spinner-border spinner-border-sm"
                                            ></span>
                                        </button>
                                    </div>
                                    </template>
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </section>
                    
                </div>
            </div>
        </div>

        <!-- Success Modal -->
        <div v-if="showModal" class="modal fade show d-block">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            {{ translate("Application Successful") }}
                        </h5>
                        <button
                            type="button"
                            class="btn btn-sm btn-danger"
                            @click="hideModal()"
                        >
                            X
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="text-primary">
                            <strong
                                >{{ translate("Dear ") }}

                                {{ currentStudent }},</strong
                            >
                        </p>
                        <p>
                            {{
                                translate(
                                    "You have successfully applied for the course of "
                                )
                            }}
                            <br />
                            <strong class="text-primary">
                                {{ currentCourse }}</strong
                            >
                        </p>
                        <p>
                            {{
                                translate(
                                    "The administration will contact you soon."
                                )
                            }}
                        </p>
                        <p>
                            {{ translate("For any queries, contact us at:") }}
                        </p>
                        <p>
                            <strong class="text-primary"> 091650861</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="modal-backdrop fade show"></div>
    </main>
</template>

<script>
import axios from "axios";
import Master from "../Layout/MasterFront.vue";
import Multiselect from "@vueform/multiselect";
import { usePage } from "@inertiajs/vue3";

export default {
    layout: Master,
    components: {
        Multiselect,
    },
    
    created(){
        this.fetchClasses();
    },

   data() {
    return {
        enrollCheckCnin: "",
        admissionStatusDetails: null,
        formErrors: {},
        checkStatusBtn: 1,
        noRecordFound: false,
        currentStudent: "",
        currentCourse: "",
        students: [],
        filterOptions: [
            "تَخَصُّص فِی الفِقْہِ ایک سال",
            "تَخَصُّص فِی الفِقْہِ دو سال",
            "تحصُّص فِي اللُّغَاتِ",
            "دورہ حدیث",
            "درجہ سابعہ",
            "درجہ سادسہ",
            "درجہ خامسہ",
            "درجہ رابعہ",
            "درجہ ثالثہ",
            "درجہ ثانیہ",
            "درجہ اولیٰ",
            "متوسطا",
        ],
       myOptions: [
    { label: "Yes (ہاں)", value: "Yes" },
    { label: "No (نہیں)", value: "No" },
],

        previousClassOptions: [
            "دورہ حدیث",
            "درجہ سابعہ",
            "درجہ سادسہ",
            "درجہ خامسہ",
            "درجہ رابعہ",
            "درجہ ثالثہ",
            "درجہ ثانیہ",
            "درجہ اولیٰ",
            "متوسطا",
        ],

        form: {
            id: "",
            apply_for: this.course,
            name: "",
            father: "",
            dob: "",
            cnic: "",
            country: "Pakistan",
            province: "",
            district: "",
            hostelite: "",
            class_id: "",
            hostelName: "",
            studiedBefore: "",
            registrationNumber: "",
            current_address: "",
            permanent_address: "",
            phone_number: "",
            whatsapp_number: "",
            reg_no: "",
            image: null,
            cnic_front: null,
            cnic_back: null,
            payment_receipt: null,
            // Guardian Info
            guardian_name: "",
            guardian_cnic: "",
            guardian_phone: "",
            visaNumber: "",
            // Academic Info
            desired_class: "",
            previous_madrasa: "",
            previous_class: "",
            total_marks: "",
            obtained_marks: "",
            primary_education: "",
            additional_ability: "",
        },
         classOptions: [],

        studentData: null,

        // ✅ FIXED: just properties, not const
        countryList: [
            { label: "Pakistan (پاکستان)", value: "Pakistan" },
            { label: "Afghanistan (افغانستان)", value: "Afghanistan" },
        ],

        districtsByProvince: {
            "Punjab": [
                { label: "Lahore (لاہور)", value: "Lahore" },
                { label: "Faisalabad (فیصل آباد)", value: "Faisalabad" },
                { label: "Rawalpindi (راولپنڈی)", value: "Rawalpindi" },
                { label: "Multan (ملتان)", value: "Multan" },
                { label: "Gujranwala (گوجرانوالہ)", value: "Gujranwala" }
            ],
            "Sindh": [
                { label: "Karachi (کراچی)", value: "Karachi" },
                { label: "Hyderabad (حیدرآباد)", value: "Hyderabad" },
                { label: "Sukkur (سکھر)", value: "Sukkur" },
                { label: "Larkana (لاڑکانہ)", value: "Larkana" },
                { label: "Nawabshah (نوابشاہ)", value: "Nawabshah" }
            ],
            "Khyber Pakhtunkhwa": [
                { label: "Peshawar (پشاور)", value: "Peshawar" },
                { label: "Mardan (مردان)", value: "Mardan" },
                { label: "Abbottabad (ایبٹ آباد)", value: "Abbottabad" },
                { label: "Swat (سوات)", value: "Swat" },
                { label: "Kohat (کوہاٹ)", value: "Kohat" }
            ],
            "Balochistan": [
                { label: "Quetta (کوئٹہ)", value: "Quetta" },
                { label: "Gwadar (گوادر)", value: "Gwadar" },
                { label: "Turbat (تربت)", value: "Turbat" },
                { label: "Khuzdar (خضدار)", value: "Khuzdar" },
                { label: "Sibi (سبی)", value: "Sibi" }
            ],
            "Gilgit-Baltistan": [
                { label: "Gilgit (گلگت)", value: "Gilgit" },
                { label: "Skardu (سکردو)", value: "Skardu" },
                { label: "Hunza (ہنزہ)", value: "Hunza" },
                { label: "Ghizer (غذر)", value: "Ghizer" },
                { label: "Diamer (دیامر)", value: "Diamer" }
            ],
            "Azad Jammu and Kashmir": [
                { label: "Muzaffarabad (مظفرآباد)", value: "Muzaffarabad" },
                { label: "Mirpur (میرپور)", value: "Mirpur" },
                { label: "Kotli (کوٹلی)", value: "Kotli" },
                { label: "Rawalakot (راولا کوٹ)", value: "Rawalakot" },
                { label: "Bagh (باغ)", value: "Bagh" }
            ],
            "Kabul": [
                { label: "Kabul City (کابل شہر)", value: "Kabul City" },
                { label: "Paghman (پغمان)", value: "Paghman" },
                { label: "Deh Sabz (ده سبز)", value: "Deh Sabz" }
            ],
            "Kandahar": [
                { label: "Kandahar City (قندہار شہر)", value: "Kandahar City" },
                { label: "Spin Boldak (سپین بولدک)", value: "Spin Boldak" }
            ],
            "Herat": [
                { label: "Herat City (ہرات شہر)", value: "Herat City" },
                { label: "Shindand (شین ڈنڈ)", value: "Shindand" }
            ],
            "Badakhshan": [
                { label: "Arghanj Khwāh (ارغنج خواہ)", value: "Arghanj Khwāh" },
                { label: "Argō (آرگو)", value: "Argō" },
                { label: "Bahārak (بہارک)", value: "Bahārak" },
                { label: "Darāyim (درایم)", value: "Darāyim" },
                { label: "Darwāz-e Bālā (درواز بالا)", value: "Darwāz-e Bālā" },
                { label: "Darwāz-e Pāyīn (درواز پائین)", value: "Darwāz-e Pāyīn" },
                { label: "Fayzābād (فیض آباد)", value: "Fayzābād" },
                { label: "Ishkāshim (اشکاشم)", value: "Ishkāshim" },
                { label: "Kishm (کشم)", value: "Kishm" },
                { label: "Kuran wa Munjan (کران و منجان)", value: "Kuran wa Munjan" },
                { label: "Shahr-e Bāmiyān (شہر بامیان)", value: "Shahr-e Bāmiyān" },
                { label: "Shahrak (شہراک)", value: "Shahrak" },
                { label: "Shibar (شیبر)", value: "Shibar" },
                { label: "Tashkurgan (تاشقرغان)", value: "Tashkurgan" },
                { label: "Yawan (یاوان)", value: "Yawan" }
            ],
            "Badghis": [
                { label: "Ab Kamari (اب کمری)", value: "Ab Kamari" },
                { label: "Ghormach (غورماچ)", value: "Ghormach" },
                { label: "Jawand (جوند)", value: "Jawand" },
                { label: "Muqur (مقر)", value: "Muqur" },
                { label: "Bala Murghab (بالا مرغاب)", value: "Bala Murghab" },
                { label: "Qadis (قادس)", value: "Qadis" },
                { label: "Qala-e Naw (قلعہ نو)", value: "Qala-e Naw" }
            ],
            "Baghlan": [
                { label: "Baghlan-e Jadid (بغلان جدید)", value: "Baghlan-e Jadid" },
                { label: "Baghlan-e Markazi (بغلان مرکزی)", value: "Baghlan-e Markazi" },
                { label: "Dahana-i-Ghori (دہنہ غوری)", value: "Dahana-i-Ghori" },
                { label: "Dushi (دوشی)", value: "Dushi" },
                { label: "Khenjan (خنجان)", value: "Khenjan" },
                { label: "Pul-i-Khumri (پل خمری)", value: "Pul-i-Khumri" },
                { label: "Tala wa Barfak (تلا و برفک)", value: "Tala wa Barfak" },
                { label: "Khinjan (خنجان)", value: "Khinjan" },
                { label: "Nahrin (نہرین)", value: "Nahrin" }
            ],
        },

        pakProvinceOptions: [
            { label: "Punjab (پنجاب)", value: "Punjab" },
            { label: "Sindh (سندھ)", value: "Sindh" },
            { label: "Khyber Pakhtunkhwa (خیبر پختونخوا)", value: "Khyber Pakhtunkhwa" },
            { label: "Balochistan (بلوچستان)", value: "Balochistan" },
            { label: "Gilgit-Baltistan (گلگت بلتستان)", value: "Gilgit-Baltistan" },
            { label: "Azad Jammu and Kashmir (آزاد جموں و کشمیر)", value: "Azad Jammu and Kashmir" },
        ],

        afgProvinceOptions: [
            { label: "Badakhshan (بدخشان)", value: "Badakhshan" },
            { label: "Badghis (بادغیس)", value: "Badghis" },
            { label: "Baghlan (بغلان)", value: "Baghlan" },
            { label: "Balkh (بلخ)", value: "Balkh" },
            { label: "Bamyan (بامیان)", value: "Bamyan" },
            { label: "Daykundi (دایکندی)", value: "Daykundi" },
            { label: "Farah (فراہ)", value: "Farah" },
            { label: "Faryab (فاریاب)", value: "Faryab" },
            { label: "Ghazni (غزنی)", value: "Ghazni" },
            { label: "Ghor (غور)", value: "Ghor" },
            { label: "Helmand (ہلمند)", value: "Helmand" },
            { label: "Herat (ہرات)", value: "Herat" },
            { label: "Jowzjan (جوزجان)", value: "Jowzjan" },
            { label: "Kabul (کابل)", value: "Kabul" },
            { label: "Kandahar (قندھار)", value: "Kandahar" },
            { label: "Kapisa (کاپیسا)", value: "Kapisa" },
            { label: "Khost (خوست)", value: "Khost" },
            { label: "Kunar (کنڑ)", value: "Kunar" },
            { label: "Kunduz (کندز)", value: "Kunduz" },
            { label: "Laghman (لغمان)", value: "Laghman" },
            { label: "Logar (لوگر)", value: "Logar" },
            { label: "Nangarhar (ننگرہار)", value: "Nangarhar" },
            { label: "Nimroz (نیمروز)", value: "Nimroz" },
            { label: "Nuristan (نورستان)", value: "Nuristan" },
            { label: "Paktia (پکتیا)", value: "Paktia" },
            { label: "Paktika (پکتیکا)", value: "Paktika" },
            { label: "Panjshir (پنجشیر)", value: "Panjshir" },
            { label: "Parwan (پروان)", value: "Parwan" },
            { label: "Samangan (سمنگان)", value: "Samangan" },
            { label: "Sar-e Pol (سر پل)", value: "Sar-e Pol" },
            { label: "Takhar (تخار)", value: "Takhar" },
            { label: "Urozgan (اروزگان)", value: "Urozgan" },
            { label: "Wardak (وردک)", value: "Wardak" },
            { label: "Zabul (زابل)", value: "Zabul" },
        ],

        formStatus: 1,
    };
},

    methods: {

  async searchStudent() {
    if (!this.form.registrationNumber) {
        alert("Please enter a registration number.");
        return;
    }

    this.studentData = null; // clear old result first

    try {
        const response = await axios.get(`/api/students/${this.form.registrationNumber}`);
        this.studentData = response.data;
      
        this.form.apply_for = this.studentData.apply_for || ''
        this.form.reg_no = this.studentData.reg_no || ''
        this.form.name = this.studentData.name || '';
        this.form.father = this.studentData.father || '';
        this.form.cnic = this.studentData.cnic || '';
        this.form.cnic_back = this.studentData.cnic_back || '';
        this.form.cnic_front = this.studentData.cnic_front || '';
        this.form.dob = this.studentData.dob || '';
        this.form.country = this.studentData.country || '';
        this.form.province = this.studentData.province || '';
        this.form.district = this.studentData.district || '';
        this.form.phone_number = this.studentData.phone_number || '';
        this.form.whatsapp = this.studentData.whatsapp || '';
        this.form.guardian_name = this.studentData.guardian_name || '';
        this.form.guardian_cnic = this.studentData.guardian_cnic || '';
        this.form.guardian_mobile = this.studentData.guardian_mobile || '';
        this.form.hostelite = this.studentData.hostelite || '';
        this.form.hostelName = this.studentData.hostelName || '';
        this.form.previous_madrasa = this.studentData.previous_madrasa || '';
        this.form.previous_class = this.studentData.previous_class || [];
        this.form.total_marks = this.studentData.total_marks || '';
        this.form.obtained_marks = this.studentData.obtained_marks || '';
        this.form.primary_education = this.studentData.primary_education || '';
        this.form.additional_ability = this.studentData.additional_ability || '';
        this.form.permanent_address = this.studentData.permanent_address || '';
        this.form.current_address = this.studentData.current_address || '';
        this.form.image = this.studentData.image || '';
        this.form.cnic_front = this.studentData.cnic_front || '';
        this.form.cnic_back = this.studentData.cnic_back || '';
        this.form.payment_receipt = this.studentData.payment_receipt || '';
        this.form.studiedBefore = this.studentData.studiedBefore || '';

    } catch (error) {
        if (error.response && error.response.status === 404) {
            alert("No student found with this registration number.");
        } else {
            console.error("Error fetching student:", error);
            alert("Something went wrong. Please try again.");
        }
    }
}

,

 fetchClasses() {
            axios.get(route("api.classes.list"))
                .then((res) => {
                    console.log('Hello');
                    this.classOptions = res.data;
                })
                .catch((err) => console.error(err));
        },

        hideModal() {
            this.showModal = false;
            this.clearForm();
            this.formStatus = 1;
            this.formErrors = {};
            this.admissionStatusDetails = null;
            this.enrollCheckCnin = "";
            this.noRecordFound = false;
        },
        checkStatus() {
            this.admissionStatusDetails = null;
            this.formErrors = {};

            const cnic = this.enrollCheckCnin?.trim();
            if (!cnic) {
                this.formErrors.enrollCheckCnin = [
                    this.translate("CNIC field is required."),
                ];
                return;
            }

            this.checkStatusBtn = 0;

            axios
                .get(route("api.enroll.status.check", cnic))
                .then((res) => {
                    const data = res?.data;

                    if (data && Object.keys(data).length > 0) {
                        this.admissionStatusDetails = data;
                        this.noRecordFound = false;
                    } else {
                        this.admissionStatusDetails = null;
                        this.noRecordFound = true;
                    }

                    this.checkStatusBtn = 1;
                })
                .catch((err) => {
                    this.checkStatusBtn = 1;
                    this.noRecordFound = false;
                    console.error(
                        "Error fetching student admission status:",
                        err
                    );
                });
        },

        submit() {
            this.currentStudent = this.form.name;
            this.currentCourse = this.form.apply_for;
            this.formStatus = 0;

            const formData = new FormData();
            for (let key in this.form) {
                if (this.form[key] !== null) {
                    formData.append(key, this.form[key]);
                }
            }

            axios
                .post(route("api.student.store"), formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                })
                .then(() => {
                    this.formStatus = 1;
                    this.clearForm();
                    toastr.success(
                        this.translate("Student enrolled successfully.")
                    );
                    this.showModal = true;
                })
                .catch((error) => {
                    this.formStatus = 1;
                    if (error.response?.data?.errors) {
                        this.formErrors = error.response.data.errors;
                        let errorMessages = Object.values(this.formErrors)
                            .flat()
                            .join("<br>");
                        toastr.error(
                            this.translate("Some fields required data")
                        );
                    } else {
                        toastr.error(
                            this.translate("An unexpected error occurred.")
                        );
                    }
                });
        },

         croppedImgSubmit(img) {
        this.form.image = img; // Profile image
    },
    cropCNICFront(img) {
        this.form.cnic_front = img; // CNIC front image
    },
    cropCNICBack(img) {
        this.form.cnic_back = img; // CNIC back image
    },
    cropReceipt(img){
        this.form.payment_receipt = img;
    },  
        clearForm() {
            this.form = {
                id: "",
                apply_for: "",
                name: "",
                father: "",
                dob: "",
                cnic: "",
                country: "",
                province: "",
                current_address: "",
                permanent_address: "",
                phone_number: "",
                whatsapp_number: "",

                guardian_name: "",
                guardian_cnic: "",
                guardian_phone: "",

                desired_class: "",
                previous_madrasa: "",
                previous_class: "",
                total_marks: "",
                obtained_marks: "",
                primary_education: "",
                additional_ability: "",
            };
            this.formErrors = {};
        },
    },

    mounted() {
        const queryString = usePage().url.split("?")[1];
        const courseParam = queryString
            ? new URLSearchParams(queryString).get("course")
            : "";
        if (courseParam) {
            this.form.apply_for = decodeURIComponent(courseParam);
        }
    },
};
</script>
<style>
/* General Styles */
.hero-section,
.admission-section {
    margin-top: 70px;
    background-color: var(--primary-color);
}
.section {
    display: flex;
    justify-content: center;
    align-items: center;
}
.card {
    max-width: 800px;
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
}
.card-header {
    font-size: 20px;
    font-weight: bold;
}
.btn-success {
    font-size: 16px;
    padding: 10px 20px;
}
.is-invalid {
    border-color: red;
}

.card {
    max-width: 800px;
    width: 100%;
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%; /* Ensure equal height */
}

.card-body {
    flex: 1; /* Allow content to fill evenly */
}
.card {
    transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
}

.card:hover {
    opacity: 1;
    transform: translateY(-5px);
}
.hero-section {
    background: linear-gradient(120deg, #023f86, #035bb8);
    color: white;
    margin-top: 60px;
}
.theme-text-color {
    color: #023f86;
}


</style>
