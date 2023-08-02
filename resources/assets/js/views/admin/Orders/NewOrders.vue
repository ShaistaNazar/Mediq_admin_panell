<template>
  <div class="main-content">
    <div class="page-header">
      <h3 class="page-title">Orders</h3>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link to="/dashboard">
            <a>Home</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">
          <router-link to="/Orders">
            <a>Orders</a>
          </router-link>
        </li>
        <li class="breadcrumb-item active">New Order</li>
      </ol>
      <div class="page-actions new-order">
        <a
        class="btn-signin"
        v-on:click="$refs.popupOrderDetails.open()"
      >View Order Details</a>
      <a class="btn-signin" v-on:click="removeOrder()">Remove Order</a>
      </div>

      <!-- <a class="btn-signin" v-on:click="isHiddenMeds = !isHiddenMeds">Order Medicine</a>
       <a class="btn-signin" v-on:click="isHiddenEqui = !isHiddenEqui">Order Equipment</a>
        <a class="btn-signin" v-on:click="isHiddenTest = !isHiddenTest">Order Tests</a>
      <a class="btn-signin" v-on:click="isHiddenServ = !isHiddenServ">Order Services</a>-->
      <!-- <a
        class="btn-signin float-right"
        v-on:click="$refs.popupOrderDetails.open()"
      >View Order Details</a>
      <a class="btn-signin float-right" v-on:click="removeOrder()">Remove Order</a> -->

      <tabs class="tabs-default"   :options="{ useUrlFragment: false }">
        <tab id="medicines" name="Medicine">
          <div class="row">
            <div class="col-sm-12 hide">
              <div class="card border">
                <div class="card-header cardClr">
                  <h6>Medicine</h6>
                </div>
                <div class="card-body">
                  <form v-on:submit.prevent="submit" ref="dropdownMed">
                    <div
                      v-for="(OneForm, index) in form.MedsForm"
                      :key="index"
                      v-bind:value="OneForm"
                    >
                      <div class="row" v-if="index == checkMedIndex">
                        <div class="form-group col-md-4">
                          <label for="inputEmail">Select Category</label>
                          <select
                            required
                            id="inputRole"
                            class="form-control"
                            placeholder="Select Category"
                            v-model="selectedcategory"
                            v-model.trim="OneForm.selectedcategory"
                          >
                            <option value>Select Category</option>
                            <option
                              v-for="(OneMedicine, idX) in category"
                              :key="idX"
                              v-bind:value="OneMedicine.id"
                            >{{OneMedicine.category_name}}</option>
                          </select>
                        </div>

                        <div class="form-group col-md-4">
                          <label for="inputEmail">Select Medicine</label>
                          <select
                            required
                            id="inputRole"
                            class="form-control"
                            placeholder="Select Medicine"
                            v-model.trim="OneForm.selectedMedicine"
                          >
                            <option value>Select Medicine</option>
                            <option
                              v-for="(OneMedicine, idY) in medicine"
                              :key="idY"
                              v-bind:value="OneMedicine"
                            >{{OneMedicine.medicine_name}} - | Price - {{OneMedicine.price}}</option>
                          </select>
                        </div>

                        <div class="form-group col-md-2">
                          <label for="inputEmail">Quantity</label>
                          <input
                            id="inputEmail"
                            type="number"
                            min="0"
                            class="form-control"
                            placeholder="Quantity"
                            v-model.trim="OneForm.quantity"
                            v-on:click="CountTotalAmount()"
                          />
                          <!-- <div v-if="$v.form.MedsForm.quantity.$error">
                    <span v-if="!$v.form.MedsForm.quantity.required" class="help-block help-block-error">
                      Field is required
                    </span>
                          </div>-->
                        </div>
                        <div class="col-md-2">
                          <label for="inputEmail">Add More Medicine</label>
                          <button
                            type="button"
                            v-on:click="addNewApartmentMeds"
                            class="btn btn-block btn-success"
                          >Add +</button>
                        </div>
                        <!-- <div class="col-md-2" v-if="index != 0">
                        <label for="inputEmail">Remove Medicine</label>
                        <button
                          type="button"
                          v-on:click="removeApartmentMeds(index)"
                          class="btn btn-block btn-success"
                        >Remove -</button>
                        </div>-->
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div></div>
          </div>
        </tab>

        <tab id="miscellaneous_med" name="Miscellaneous Medicines">
          <div class="row">
            <div class="col-sm-12 hide">
              <div class="card border">
                <div class="card-header cardClr">
                  <h6>Miscellaneous Medicines</h6>
                </div>
                <div class="card-body">
                  <form v-on:submit.prevent="submit" ref="dropdownMed">
                    <div class="form-group col-md-6">
                      <label for="miscellaneous_med">Select Medicine</label>
                      <!-- <v-select v-model="searchEquipment"  :options="selectOptions"></v-select> -->
                      <template>
                        <!-- <div class="form-row"> -->
                        <multiselect
                          v-model="form.miscellaneousMedForm.selectedMedicine"
                          :options="selectMedOptions"
                          tag-placeholder="Add this as new tag"
                          placeholder="Search or add a tag"
                          label="name"
                          track-by="name"
                          :multiple="true"
                          :taggable="true"
                        ></multiselect>
                        <!-- </div> -->
                      </template>
                      <div class="order-equip">
                        <button
                          type="button"
                          v-on:click="equipAdd()"
                          @click="miscellaneousMedAdd = true"
                          class="btn btn-success"
                        >Add +</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </tab>

        <tab id="tests" name="Lab Tests">
          <div class="row">
            <div class="col-sm-12 hide">
              <div class="card border">
                <div class="card-header cardClr">
                  <h6>Lab Tests</h6>
                </div>
                <div class="card-body">
                  <form v-on:submit.prevent="submit" ref="dropdownMed">
                    <div v-for="(OneForm, index) in form.TestsForm" :key="index">
                      <!-- <div class="form-group col-md-2">
                        <label for="packageImage">Upload Prescription</label>
                        <input
                          type="file"
                          class="form-control"
                          id="packageImage"
                          ref="file"
                          name="packageImage"
                        />
                      </div>-->
                      <div class="row" v-if="index == checkTestIndex">
                        <div class="form-group col-md-2">
                          <label for="inputEmail">Select Lab</label>
                          <select
                            required
                            id="inputRole"
                            class="form-control"
                            placeholder="Select Lab Test"
                            v-model="selectedLab"
                            v-model.trim="OneForm.selectedOneLab"
                          >
                            <option disabled value>Categories</option>
                            <option
                              v-for="(OneLab, index) in labs"
                              :key="index"
                              v-bind:value="OneLab"
                            >{{OneLab.lab_name}}</option>
                          </select>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="inputEmail">Select Category</label>
                          <select
                            required
                            id="inputRole"
                            class="form-control"
                            placeholder="Select City"
                            v-model="selectedTestCat"
                            v-model.trim="OneForm.selectedTestCat"
                          >
                            <option disabled value>Categories</option>
                            <option
                              v-for="(OneCat, OneCatIndex) in testsCats"
                              :key="OneCatIndex"
                              v-bind:value="OneCat.id"
                            >{{OneCat.test_category.category_name}}</option>
                          </select>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="inputEmail">Select Test</label>
                          <select
                            required
                            id="inputRole"
                            class="form-control"
                            placeholder="Select City"
                            v-model.trim="OneForm.selectedTest"
                          >
                            <option disabled value>Test</option>
                            <option
                              v-for="(OneTest, OneTestIndex) in tests"
                              :key="OneTestIndex"
                              v-bind:value="OneTest"
                            >{{OneTest.test_name}}- | Price -{{OneTest.price}}</option>
                          </select>
                        </div>
                        <div class="form-group col-md-2">
                          <label for="inputEmail">Quantity</label>

                          <input
                            id="inputEmail"
                            type="number"
                            min="0"
                            class="form-control"
                            placeholder="Quantity"
                            v-model.trim="OneForm.quantity"
                            v-on:click="CountTotalAmount()"
                          />
                        </div>

                        <div class="col-md-2">
                          <label for="inputEmail">Add More Tests</label>
                          <button
                            type="button"
                            v-on:click="addNewApartmentTests"
                            class="btn btn-block btn-success"
                          >Add +</button>
                        </div>
                        <!-- <div class="col-md-2">
                        <label for="inputEmail">Remove Medicine</label>
                        <button
                          type="button"
                          v-on:click="removeApartmentTests(index)"
                          class="btn btn-block btn-success"
                        >Remove -</button>
                        </div>-->
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </tab>

        <!-- <tab id="services" name="Order Services">
          <div class="row">
            <div class="col-sm-12 hide">
              <div class="card border">
                <div class="card-header cardClr">
                  <h6>Services Order</h6>
                </div>
                <div class="card-body">
                  <form v-on:submit.prevent="submit" ref="dropdownMed">
                    <div class="row" v-for="(OneForm, index) in form.ServicesForm" :key="index">
                      <div class="form-group col-md-2" style="width:50%">
                        <label style="width:100%">Date</label>
                        <date-picker
                          v-model.trim="OneForm.NeedDate"
                          lang="en"
                          format="YYYY-MM-DD"
                        ></date-picker>
                      </div>

                      <div class="form-group col-md-2" style="width:50%">
                        <label style="width:100%">Required Time (From)</label>
                        <date-picker
                          v-model.trim="OneForm.fromTime"
                          lang="en"
                          type="time"
                          format="HH:mm:ss"
                          placeholder="Select Time"
                        ></date-picker>
                      </div>
                      <div class="form-group col-md-2" style="width:50%">
                        <label style="width:100%">Required Time (Till)</label>
                        <date-picker
                          v-model.trim="OneForm.toTime"
                          lang="en"
                          type="time"
                          format="HH:mm:ss"
                          placeholder="Select Time"
                        ></date-picker>
                      </div>

                      <div class="form-group col-md-2">
                        <label for="inputEmail">Select Service</label>
                        <select
                          required
                          id="inputRole"
                          class="form-control"
                          placeholder="Select City"
                          @change="differentServices(OneForm.selectedSerCat,index)"
                          v-model.trim="OneForm.selectedSerCat"
                        >
                          <option disabled value>Categories</option>
                          <option
                            v-for="(OneLab, Onelab) in servicesCat"
                            :key="Onelab"
                            v-bind:value="OneLab"
                          >{{OneLab.service_name}}</option>
                        </select>
                      </div>

                      <div class="form-group col-md-2">
                        <label for="inputEmail">Select Service Provider</label>
                        <select
                          required
                          id="inputRole"
                          class="form-control"
                          placeholder="Select City"
                          v-model.trim="OneForm.selectedSer"
                        >
                          <option disabled value>Service Providers</option>
                          <option
                            v-for="(OneCat, OneCatIndex) in services"
                            :key="OneCatIndex"
                            v-bind:value="OneCat"
                          >{{OneCat.providers_data.service_name}} | {{OneCat.full_name}}</option>
                        </select>
                      </div>

                      <div class="col-md-2" v-if="index == 0">
                        <label for="inputEmail">Add More Tests</label>
                        <button
                          type="button"
                          v-on:click="addNewApartmentService"
                          class="btn btn-block btn-success"
                        >Add +</button>
                      </div>
                      <div class="col-md-2" v-if="index != 0">
                        <label for="inputEmail">Remove Medicine</label>
                        <button
                          type="button"
                          v-on:click="removeApartmentService(index)"
                          class="btn btn-block btn-success"
                        >Remove -</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </tab>-->

        <tab id="equipment" name="Equipment">
          <div class="row">
            <div class="col-sm-12 hide">
              <div class="card border">
                <div class="card-header cardClr">
                  <h6>Equipments</h6>
                </div>
                <div class="card-body">
                  <form v-on:submit.prevent="submit" ref="dropdownMed">
                    <div class="form-group col-md-6">
                      <label for="inputEmail">Select Equipment</label>
                      <!-- <v-select v-model="searchEquipment"  :options="selectOptions"></v-select> -->
                      <template>
                        <!-- <div class="form-row"> -->
                        <multiselect
                          v-model="form.EquipmentForm.selectedEquipmets"
                          :options="selectOptions"
                          tag-placeholder="Add this as new tag"
                          placeholder="Search or add a tag"
                          label="name"
                          track-by="name"
                          :multiple="true"
                          :taggable="true"
                        ></multiselect>
                        <!-- </div> -->
                      </template>
                      <div class="order-equip">
                        <button
                          type="button"
                          v-on:click="equipAdd()"
                          @click="EquipAdd = true"
                          class="btn btn-success"
                        >Add +</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </tab>

        <tab id="address" name="Order's Address">
          <div class="row">
            <div class="col-sm-12 hide">
              <div class="card border">
                <!-- <div class="card-header cardClr">
                  <h6>Order's Address</h6>
                </div>-->

                <div class="row">
                  <div class="col-md-6 hide">
                    <div class="card border">
                      <div class="card-header cardClr">
                        <h6>Shipping Address</h6>
                      </div>

                      <div class="col-md-12">
                        <div class="card">
                          <div class="card-body">
                            <h5 class="text-bold">Shipping Details</h5>
                            <form autocomplete="off" v-on:submit.prevent="submit">
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="shippingaddress">Address*</label>
                                  <input
                                    id="shippingaddress"
                                    :class="{ 'is-invalid': $v.form.shippingHome_address.$error}"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter Address"
                                    v-model.trim="form.shippingHome_address"
                                    @input="$v.form.shippingHome_address.$touch()"
                                  />
                                  <div
                    v-if="$v.form.shippingHome_address.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.shippingHome_address.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.shippingHome_address.minLength"
                      class="help-block help-block-error"
                    >Address must have at least {{ $v.form.shippingHome_address.$params.minLength.min }} letters.</span>
                  </div>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="shippingphone">Phone* <small>Format: 923001234567</small></label>
                                  <input
                                    id="shippingphone"
                                    :class="{ 'is-invalid': $v.form.shippingPhone.$error}"
                                    type="tel"
                                    class="form-control"
                                    aria-describedby="phoneHelp"
                                    placeholder="Enter Phone"
                                    v-model.trim="form.shippingPhone"
                                    @input="$v.form.shippingPhone.$touch()"
                                  />
                                   <div
                    v-if="$v.form.shippingPhone.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.shippingPhone.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.shippingPhone.maxLength"
                      class="help-block help-block-error"
                    >Phone must have at least {{ $v.form.shippingPhone.$params.maxLength.max }} letters.</span>
                  </div>
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="shippingcity">City*</label>
                                  <!-- <input
                        id="shippingcity"
                        type="text"
                        class="form-control"
                        placeholder="Enter City"
                        v-model.trim="form.shippingCity"
                                  >-->
                                  <select
                                    required
                                    id="inputRole"
                                    class="form-control"
                                    placeholder="Select City"
                                    v-model.trim="form.shippingCity"
                                  >
                                    <option value>Select City</option>
                                    <option
                                      v-for="(city, idCity) in cities"
                                      :key="idCity"
                                      v-bind:value="city.city_name"
                                    >{{city.city_name}}</option>
                                  </select>
                                </div>
                                <!-- <div class="form-group col-md-6">
                      <label for="shippingprovince"> Province</label>
                      <input
                        id="shippingprovince"
                        type="text"
                        class="form-control"
                        aria-describedby="phoneHelp"
                        placeholder="Enter Province"
                        v-model.trim="form.shippingProvince"
                      >
                                </div>-->
                                <div class="form-group col-md-6">
                                  <label for="shippingprovince">Province*</label>
                                  <select
                                    placeholder="Enter Province"
                                    id="shippingprovince"
                                    class="form-control"
                                    required
                                    v-model="form.shippingProvince"
                                  >
                                    <option value>Enter Province</option>
                                    <option
                                      v-for="option in options"
                                      v-bind:key="option.name"
                                    >{{ option.name }}</option>
                                  </select>
                                </div>
                              </div>

                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="shippingfirstname">First Name*</label>
                                  <input
                                    id="shippingfirstname"
                                    :class="{ 'is-invalid': $v.form.shippingFirstName.$error }"
                                    type="text"
                                    onkeypress="return (event.charCode > 64 && 
	event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"
                                    class="form-control"
                                    aria-describedby="phoneHelp"
                                    placeholder="Enter First Name"
                                    v-model.trim="form.shippingFirstName"
                                    @input="$v.form.shippingFirstName.$touch()"
                                  />
                                  <div
                    v-if="$v.form.shippingFirstName.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.shippingFirstName.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.shippingFirstName.minLength"
                      class="help-block help-block-error"
                    >First Name must have at least {{ $v.form.shippingFirstName.$params.minLength.min }} letters.</span>
                    <span
                      v-if="!$v.form.shippingFirstName.maxLength"
                      class="help-block help-block-error"
                    >First Name should not exceed {{ $v.form.shippingFirstName.$params.maxLength.max }} letters.</span>
                  </div>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="shippinglastname">Last Name*</label>
                                  <input
                                    id="shippinglastname"
                                    :class="{ 'is-invalid': $v.form.shippingLastName.$error }"
                                    type="text"
                                    onkeypress="return (event.charCode > 64 && 
	event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"
                                    class="form-control"
                                    aria-describedby="phoneHelp"
                                    placeholder="Enter Last Name"
                                    v-model.trim="form.shippingLastName"
                                    @input="$v.form.shippingLastName.$touch()"
                                  />
                                  <div
                    v-if="$v.form.shippingLastName.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.shippingLastName.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.shippingLastName.minLength"
                      class="help-block help-block-error"
                    >Last Name must have at least {{ $v.form.shippingLastName.$params.minLength.min }} letters.</span>
                    <span
                      v-if="!$v.form.shippingLastName.maxLength"
                      class="help-block help-block-error"
                    >Last Name should not exceed {{ $v.form.shippingLastName.$params.maxLength.max }} letters.</span>
                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- </div> -->

                  <!-- <div class="row"> -->
                  <div class="col-md-6 hide">
                    <div class="card border">
                      <div class="card-header cardClr">
                        <h6>Billing Address</h6>
                      </div>

                      <div class="col-md-12">
                        <div class="card">
                          <div class="card-body">
                            <h5 class="text-bold">Billing Details</h5>
                            <form v-on:submit.prevent="submit">
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="billingaddress">Address*</label>
                                  <input
                                    id="billingaddress"
                                    :class="{ 'is-invalid': $v.form.billingHome_address.$error }"
                                    type="text"
                                    class="form-control"
                                    placeholder="Enter Address"
                                    v-model.trim="form.billingHome_address"
                                    @input="$v.form.billingHome_address.$touch()"
                                  />
                                  <div
                    v-if="$v.form.billingHome_address.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.billingHome_address.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.billingHome_address.minLength"
                      class="help-block help-block-error"
                    >Address must have at least {{ $v.form.billingHome_address.$params.minLength.min }} letters.
                    </span>
                   
                  </div>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="billingphone">Phone* <small>Format: 923001234567</small></label>
                                  <input
                                    id="billingphone"
                                    :class="{ 'is-invalid': $v.form.billingPhone.$error }"
                                    type="tel"
                                    class="form-control"
                                    aria-describedby="phoneHelp"
                                    placeholder="Enter Phone"
                                    v-model.trim="form.billingPhone"
                                    @input="$v.form.billingPhone.$touch()"
                                  />
                                  <div
                    v-if="$v.form.billingPhone.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.billingPhone.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.billingPhone.maxLength"
                      class="help-block help-block-error"
                    >Phone must have at least {{ $v.form.billingPhone.$params.maxLength.max }} numbers.
                    </span>
                   
                  </div>
                                </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="billingcity">City*</label>
                                  <!-- <input
                        id="billingcity"
                        type="text"
                        class="form-control"
                        placeholder="Enter City"
                        v-model.trim="form.billingCity"
                                  >-->
                                  <select
                                    required
                                    id="inputRole"
                                    class="form-control"
                                    placeholder="Select City"
                                    v-model.trim="form.billingCity"
                                  >
                                    <option value>Select City</option>
                                    <option
                                      v-for="(city, idCity) in cities"
                                      :key="idCity"
                                      v-bind:value="city.city_name"
                                    >{{city.city_name}}</option>
                                  </select>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="billingprovince">Province*</label>
                                  <!-- <input
                        id="billingprovince"
                        type="text"
                        class="form-control"
                        aria-describedby="phoneHelp"
                        placeholder="Enter Province"
                        v-model.trim="form.billingProvince"
                                  >-->
                                  <select
                                    placeholder="Enter Province"
                                    id="shippingprovince"
                                    class="form-control"
                                    required
                                    v-model="form.billingProvince"
                                  >
                                    <option value>Enter Province</option>
                                    <option
                                      v-for="option in options"
                                      v-bind:key="option.name"
                                    >{{ option.name }}</option>
                                  </select>
                                </div>
                              </div>

                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="billing firstname">First Name*</label>
                                  <input
                                    id="billing firstname"
                                    :class="{ 'is-invalid': $v.form.billingFirstName.$error }"
                                    type="text"
                                    onkeypress="return (event.charCode > 64 && 
	event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"
                                    class="form-control"
                                    aria-describedby="phoneHelp"
                                    placeholder="Enter First Name"
                                    v-model.trim="form.billingFirstName"
                                    @input="$v.form.billingFirstName.$touch()"
                                  />
                                   <div
                    v-if="$v.form.billingFirstName.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.billingFirstName.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.billingFirstName.minLength"
                      class="help-block help-block-error"
                    >First Name must have at least {{ $v.form.billingFirstName.$params.minLength.min }} letters.</span>
                    <span
                      v-if="!$v.form.billingFirstName.maxLength"
                      class="help-block help-block-error"
                    >First Name should not exceed {{ $v.form.billingFirstName.$params.maxLength.max }} letters.</span>
                  </div>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for="billinglastname">Last Name*</label>
                                  <input
                                    id="billinglastname"
                                    :class="{ 'is-invalid': $v.form.billingLastName.$error }"
                                    type="text"
                                    onkeypress="return (event.charCode > 64 && 
	event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)"
                                    class="form-control"
                                    aria-describedby="phoneHelp"
                                    placeholder="Enter Last Name"
                                    v-model.trim="form.billingLastName"
                                    @input="$v.form.billingLastName.$touch()"
                                  />

                                  <div
                    v-if="$v.form.billingLastName.$error"
                    class="is-invalid"
                  >
                    <span
                      v-if="!$v.form.billingLastName.required"
                      class="help-block help-block-error"
                    >Field is required</span>
                    <span
                      v-if="!$v.form.billingLastName.minLength"
                      class="help-block help-block-error"
                    >Last Name must have at least {{ $v.form.billingLastName.$params.minLength.min }} letters.</span>
                    <span
                      v-if="!$v.form.billingLastName.maxLength"
                      class="help-block help-block-error"
                    >Last Name should not exceed {{ $v.form.billingLastName.$params.maxLength.max }} letters.</span>
                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-9"></div>
                  <div class="col-md-3">
                    <!-- <button
                    type="submit"
                    class="btn btn-success"
                    :disabled="$v.$invalid"
                    >Submit</button>-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </tab>
      </tabs>
    </div>
    <div class="row">
      <div class="col-md-3">
        
      </div>
       <div class="col-md-6 prescription-pic" v-if="prescrip_id">
         <h3>Prescription</h3>
      <a
        href="#"
        @click="$refs.prescription_info.open(),prescriptionModel(Prescription_pic)"
        v-b-popover.hover="'Open Priscription'"
      >
        <img
          @error="onImageLoadFailure($event)"
          width="100%"
          :src="mImagelink + Prescription_pic"
        />
      </a>
    </div>
    <div class="col-md-3">
        
      </div>
    </div>
   
    <sweet-modal  ref="prescription_info" modal-theme="dark" overlay-theme="dark" width="70%">
              <div class="card-body prescription">
                <img @error="onImageLoadFailure($event)" height="500" :src="mImagelink + Prescription"/>

              </div>
   </sweet-modal>

    <sweet-modal ref="popupCity" modal-theme="dark" overlay-theme="dark">
      <div class="card-header">
        <div class="card-actions" />
      </div>
      <div class="card-body">
        <template slot-scope>
          <div class="form-group col-md-12">
            <label for="inputEmail">Select City</label>
            <select
              required
              id="inputRole"
              class="form-control"
              placeholder="Select City"
              v-model.trim="selectedCity"
            >
              <option value>Select City</option>
              <option
                v-for="(city, idCity) in cities"
                :key="idCity"
                v-bind:value="city.id"
              >{{city.city_name}}</option>
            </select>
          </div>
        </template>
      </div>
    </sweet-modal>

    

    <sweet-modal
      ref="popupOrderDetails"
      modal-theme="dark"
      width="100%"
      overlay-theme="dark"
      class="popupWidth"
    >
      <div class="card-header">
        <div class="card-actions" />
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-sm-12 tableWidth" v-if="form.MedsForm[0].quantity != ''">
            <b class="text-center headDesign">Medicine Ordered</b>
            <table class="table table-striped table-bordered col-sm-6 float-left" title="Medicines">
              <tbody v-for="(OneMed, OneMedId) in form.MedsForm" :key="OneMedId">
                <!-- <tr>
                  <td>
                    <div>
                      <b>Medicine Name</b>
                    </div>
                  </td>
                  <td>
                    <div>
                      <b>Medicine Price</b>
                    </div>
                  </td>
                  <td>
                    <div>
                      <b>Medicine Quantity</b>
                    </div>
                  </td>
                  <td>
                    <div>
                      <b>Medicine Brand</b>
                    </div>
                  </td>
                </tr>-->
                <tr class="row" v-if="OneMed.selectedMedicine.medicine_name && OneMed.quantity != 0">
                  <!-- <td class="col-md-3">
                    <div v-if="form">
                      <b>Brand: {{OneMed.selectedMedicine.brand}}</b>
                    </div>
                  </td> -->
                  <td class="col-md-6">
                    <div v-if="form">
                      <b>Name: {{OneMed.selectedMedicine.medicine_name}}</b>
                    </div>
                    <!-- <div v-else>No Medicine Ordered</div> -->
                  </td>

                  <td class="col-md-2">
                    <!-- <div v-if="form"> -->
                    <input
                      v-if="OneMed.quantity"
                      id="inputEmail"
                      type="number"
                      min="0"
                      class="col-md-6"
                      placeholder="quantity"
                      v-model.trim="OneMed.quantity"
                      v-on:click="CountTotalAmount()"
                    />
                  </td>
                  <td class="col-md-2">
                    <div v-if="form">
                      <b>{{OneMed.quantity * OneMed.selectedMedicine.price}}</b>
                    </div>
                    <!-- <div v-else>No Medicine Ordered</div> -->
                  </td>
                  <!-- <b>{{OneMed.quantity}}</b> -->
                  <!-- </div> -->
                  <td class="col-md-2" v-if="form.MedsForm" v-on:click="CountTotalAmount()">
                    <i
                      class="icon-fa icon-fa-trash"
                      v-on:click="checkMedIndex--"
                      @click="$delete(form.MedsForm, OneMedId)"
                    />
                  </td>

                  <!-- <i @click="$delete(items, key)">remove</i> -->
                </tr>
              </tbody>
            </table>
          </div>
          <!-- <div class="col-sm-12 tableWidth text-center" v-else>No Medicines Ordered</div> -->

          <div class="col-sm-12 tableWidth" v-if="form.TestsForm[0].selectedTest != ''">
            <b class="text-center headDesign">Tests Ordered</b>
            <table class="table table-striped table-bordered col-sm-6 float-right">
              <tbody v-for="(OneTest, OneTestId) in form.TestsForm" :key="OneTestId">
                <!-- <tr  v-if="OneTest != ''">
                  <td>
                    <div>
                      <b>Test Name</b>
                    </div>
                  </td>
                  <td>
                    <div>
                      <b>Test Price</b>
                    </div>
                  </td>
                  <td>
                    <div>
                      <b>Selected Labortary</b>
                    </div>
                  </td>
                </tr>-->
                <tr class="row" v-if="OneTest.selectedOneLab.lab_name && OneTest.quantity!=0">
                  <td class="col-md-3">
                    <div v-if="OneTest.selectedOneLab.lab_name">
                      <b>Lab: {{OneTest.selectedOneLab.lab_name}}</b>
                    </div>
                  </td>
                  <td class="col-md-3">
                    <div v-if="OneTest.selectedTest.test_name">
                      <b>Name: {{OneTest.selectedTest.test_name}}</b>
                    </div>
                  </td>
                  <td class="col-md-2">
                    <input
                      v-if="OneTest.quantity"
                      id="inputEmail"
                      type="number"
                      min="0"
                      class="col-md-6"
                      placeholder="quantity"
                      v-model.trim="OneTest.quantity"
                      v-on:click="CountTotalAmount()"
                    />
                  </td>

                  <td class="col-md-2">
                    <div v-if="OneTest.quantity">
                      <b>{{OneTest.quantity * OneTest.selectedTest.price}}</b>
                    </div>
                  </td>
                  <td class="col-md-2" v-if="OneTest" v-on:click="CountTotalAmount()">
                    <i
                      class="icon-fa icon-fa-trash"
                      v-on:click="checkTestIndex--"
                      @click="$delete(form.TestsForm, OneTestId)"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- <div class="col-sm-12 tableWidth text-center" v-else>No Tests Ordered</div> -->
        </div>

        <div class="row">
          <div v-if="miscellaneousMedAdd == true" class="col-sm-12 tableWidth">
            <b class="text-center headDesign">Miscellaneous Medicine Ordered</b>
            <table class="table table-striped table-bordered col-sm-6 float-right">
              <tbody
                v-for="(OneMM, OnemMId) in form.miscellaneousMedForm.selectedMedicine"
                :key="OnemMId"
              >
                <tr class="row">
                  
                  <td class="col-md-6">
                    <div v-if="form">
                      <b>Name: {{OneMM.name}}</b>
                    </div>
                  </td>
                  <td class="col-md-2">
                    <input
                      id="inputEmail"
                      type="number"
                      min="0"
                      class="col-md-6"
                      placeholder="quantity"
                      v-model.trim="OneMM.quantity"
                      v-on:click="CountTotalAmount()"
                    />
                  </td>
                  <td class="col-md-2">
                    <div v-if="form">
                      <b>{{OneMM.price * OneMM.quantity}}</b>
                    </div>
                  </td>
                  <td class="col-md-2" v-if="form.EquipmentForm.selectedEquipmets">
                    <i
                      class="icon-fa icon-fa-trash"
                      @click="$delete(form.miscellaneousMedForm.selectedMedicine, OnemMId)"
                      v-on:click="CountTotalAmount()"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="row">
          <div v-if="EquipAdd == true" class="col-sm-12 tableWidth">
            <b class="text-center headDesign">Equipments Ordered</b>
            <table class="table table-striped table-bordered col-sm-6 float-right">
              <tbody
                v-for="(OneEqu, OneEquId) in form.EquipmentForm.selectedEquipmets"
                :key="OneEquId"
              >
                <!-- <tr  v-if="OneTest != ''">
                  <td>
                    <div>
                      <b>Test Name</b>
                    </div>
                  </td>
                  <td>
                    <div>
                      <b>Test Price</b>
                    </div>
                  </td>
                  <td>
                    <div>
                      <b>Selected Labortary</b>
                    </div>
                  </td>
                </tr>-->
                <tr class="row" style="width: 100%; margin-left: 0px;">
                  <td class="col-md-3">
                    <div v-if="form">
                      <b>Brand: {{OneEqu.brand}}</b>
                    </div>
                  </td>
                  <td class="col-md-3">
                    <div v-if="form">
                      <b>Name: {{OneEqu.name}}</b>
                    </div>
                  </td>
                  <td class="col-md-2">
                    <input
                      id="inputEmail"
                      type="number"
                      min="0"
                      class="col-md-6"
                      placeholder="quantity"
                      v-model.trim="OneEqu.quantity"
                      v-on:click="CountTotalAmount()"
                    />
                  </td>
                  <td class="col-md-2">
                    <div v-if="form">
                      <b>{{OneEqu.price * OneEqu.quantity}}</b>
                    </div>
                  </td>
                  <!-- <td>
                    <div v-if="OneService.selectedSer">
                       <b>{{OneService.selectedSer.full_name}}</b>
                    </div>
                  </td>
                  <td>
                    <div v-if="OneService.selectedSer">
                       <b>{{OneService.selectedSer.phone}}</b>
                    </div>
                  </td>
                    <td>
                    <div v-if="OneService">
                      <b>{{OneService.fromTime | formatterTime}}</b>
                    </div>
                  </td>
                   <td>
                    <div v-if="form">
                       <b>{{OneService.toTime | formatterTime}}</b>
                    </div>
                  </td>
                  <td>
                    <div v-if="form">
                      <b>{{OneService.NeedDate | dateOnly}}</b>
                    </div>
                  </td>-->
                  <td class="col-md-2" v-if="form.EquipmentForm.selectedEquipmets">
                    <i
                      class="icon-fa icon-fa-trash"
                      @click="$delete(form.EquipmentForm.selectedEquipmets, OneEquId)"
                      v-on:click="CountTotalAmount()"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- <div class="col-sm-12 tableWidth text-center" v-else>No Tests Ordered</div> -->
        </div>
        <div class="row">
          <div class="col-md-4">
            <table
              v-if="form.shippingHome_address != ''"
              class="table table-striped table-bordered"
            >
              <div class="row" style="width: 100%; margin-left: 0px;">
                <tbody class="full-wid col-md-6" style="text-align:left;">
                  <tr>
                    <td class="full-w">
                      <h6>Shipping Details</h6>
                    </td>
                  </tr>
                  <tr>
                    <td class="full-w">
                      <b>Name:</b>

                      {{form.shippingFirstName}} {{form.shippingLastName}}
                    </td>
                  </tr>
                  <tr>
                    <td class="full-w">
                      <b>Phone:</b>

                      {{form.shippingPhone}}
                    </td>
                  </tr>
                  <tr>
                    <td class="full-w">
                      <b>Province</b>

                      : {{form.shippingProvince}}
                    </td>
                  </tr>

                  <tr>
                    <td class="full-w">
                      <b>City:</b>

                      {{form.shippingCity}}
                    </td>
                  </tr>
                  <tr>
                    <td class="full-w">
                      <b>Address:</b>

                      {{form.shippingHome_address}}
                    </td>
                  </tr>
                </tbody>
                <tbody class="full-wid col-md-6" style="text-align:left;">
                  <tr>
                    <td class="full-w">
                      <h6>Billing Details</h6>
                    </td>
                  </tr>
                  <tr>
                    <td class="full-w">
                      <b>Name:</b>

                      {{form.billingFirstName}} {{form.billingLastName}}
                    </td>
                  </tr>
                  <tr>
                    <td class="full-w">
                      <b>Phone:</b>

                      {{form.billingPhone}}
                    </td>
                  </tr>
                  <tr>
                    <td class="full-w">
                      <b>Province:</b>

                      {{form.billingProvince}}
                    </td>
                  </tr>

                  <tr>
                    <td class="full-w">
                      <b>City:</b>

                      {{form.billingCity}}
                    </td>
                  </tr>
                  <tr>
                    <td class="full-w">
                      <b>Address:</b>

                      {{form.billingHome_address}}
                    </td>
                  </tr>
                </tbody>
              </div>
            </table>
          </div>
          <div class="col-md-2" style="text-align:right;">
            <b v-if="form.TotalAmount != 0">Total:</b>
          </div>
          <div class="col-md-2">
            <div v-if="form.TotalAmount != 0">{{this.form.TotalAmount}}</div>
            <span class="shipment-charges" v-if="form.TotalAmount <= 1500 ">(Rs 200 shipping charges)</span>
          </div>
          <div class="col-md-2">
            <button
              v-if="(form.EquipmentForm.selectedEquipmets || form.MedsForm.length >= 2 || form.TestsForm.length >= 2)"
              class="btn btn-info"
              v-on:click="CountTotalAmount()"
              @click="$refs.totalAmount.open()"
            >Check Total Amount</button>
            <!-- <sweet-button  v-if="(form.EquipmentForm.selectedEquipmets || form.MedsForm.length >= 2 || form.TestsForm.length >= 2)" slot="button"  v-on:click="CountTotalAmount()" @click="$refs.total_mount.open()">Open Child Modal</sweet-button> -->
          </div>
          <div class="col-md-2" v-if="form.billingCity != null">
            <button
              v-if="(form.EquipmentForm.selectedEquipmets || form.MedsForm.length >= 2 || form.TestsForm.length >= 2)"
              :disabled="$v.$invalid"
              class="btn btn-success"
              @click="submitOrder()"
            >Submit Order</button>
          </div>
          <div v-else>Complete Shipping & Billing details to proceed the order</div>
        </div>
      </div>
      <sweet-modal ref="totalAmount" modal-theme="dark" overlay-theme="dark" width="30%">
        <div class="card-header">
        <b>Your total Amount is:</b>
         Rs
        <b>{{this.form.TotalAmount}}</b>
        </div>
      </sweet-modal>
    </sweet-modal>
  </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<script type="text/babel">
import { required, sameAs, minLength, maxLength, between } from "vuelidate/lib/validators"
import { TableComponent, TableColumn } from "vue-table-component"
import Vue from "vue";
import { SweetModal, SweetModalTab } from "sweet-modal-vue";
import BootstrapVue from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import Ls from "../../../services/ls";
import DatePicker from "vue2-datepicker";
import { imageLink,mobileImageLink } from "../../../helpers/constants";
import Multiselect from "vue-multiselect";
import { Tabs, Tab } from "vue-tabs-component";
import moment from "moment";

Vue.use(BootstrapVue);
Vue.use(moment);

export default {
  components: {
    DatePicker,
    TableComponent,
    TableColumn,
    SweetModal,
    SweetModalTab,
    Multiselect,
    tabs: Tabs,
    tab: Tab
  },
  data() {
    return {
      options: [
        { name: "Punjab", value: "A" },
        // { name: "KPK", value: "B" },
        // { name: "Sindh", value: "C" },
        // { name: "Balochistan", value: "D" }
      ],
      EquipAdd: false,
      miscellaneousMedAdd: false,
      OneIndex: [],
      OneDate: "",
      OneService: "",
      checkMedIndex: 0,
      checkTestIndex: 0,
      lab: "",
      equipmentPopup: "",
      imagelink: imageLink,   
      mImagelink: mobileImageLink,
      // searchEquipment: "",
      cities: "",
      Prescription: "",
      prescrip_id: "",
      Prescription_pic: "",
      tests: "",
      labs: "",
      medicine: "",
      services: "",
      equipments: [],
      miscellaneous_medicine: [],
      servicesCat: "",
      selectedCity: "",
      selectedSerCat: "",
      selectedSer: "",
      selectedEquipment: "",
      category: "",
      testsCats: "",
      Testcategory: "",
      selectedcategory: "",
      selectedOneLab: "",
      selectedLab: "",
      selectedTestCat: "",
      form: {
        billingCity: "",
        billingHome_address: "",
        billingProvince: "",
        billingPhone: "",
        billingFirstName: "",
        billingLastName: "",
        shippingPhone: "",
        shippingFirstName: "",
        shippingHome_address: "",
        shippingCity: "",
        shippingProvince: "",
        shippingLastName: "",
        shipping_id: 0,
        billing_id: 0,
        user_id: 1,
        MedsForm: [
          {
            selectedMedicine: "",
            selectedcategory: "",
            quantity: ""
          }
        ],
        TestsForm: [
          {
            selectedPrescription: "",
            selectedTestCat: "",
            selectedOneLab: "",
            selectedTest: "",
            quantity: ""
          }
        ],
        EquipmentForm: [
          {
            selectedEquipmets: ""
          }
        ],
        miscellaneousMedForm: [
          {
            selectedMedicine: ""
          }
        ],
        TotalAmount: 0
      },
      Read: "",
      Write: "",
      Delete: "",
      orders: [],
      EquipmentsDrop: [],
      miscellaneousMedicineDrop: [],
    };
  },
  validations: {
    form: {
      billingHome_address: {
        required,
        minLength: minLength(4)
      },
      billingPhone: {
        required,
        minLength: minLength(4),
        maxLength: maxLength(12)
      },
      billingFirstName: {
        required,
        minLength: minLength(4),
        maxLength: maxLength(15)
      },
      billingLastName: {
        required,
        minLength: minLength(4),
        maxLength: maxLength(15)
      },
      shippingFirstName: {
        required,
        minLength: minLength(4),
        maxLength: maxLength(15)
      },
      shippingHome_address: {
        required,
        minLength: minLength(4)
      },
      shippingLastName: {
        required,
        minLength: minLength(4),
        maxLength: maxLength(15)
      },
      shippingPhone: {
        required,
        maxLength: maxLength(12)
      }
    }
  },
  filters: {
    formatterTime: function(value) {
      return moment(value).format("HH : mm : ss");
    },
    dateOnly: function(value) {
      return moment(value).format("Do MMM YYYY");
    }
  },
  watch: {
    selectedcategory: function(val) {
      this.loadMedicineCategory();
    },
    selectedLab: function(val) {
      this.LoadgetTestsCats();
    },
    selectedTestCat: function(val) {
      this.LoadgetTests();
    },
    selectedSerCat: function(val) {
      this.LoadAllServices();
    }
    // searchEquipment: function(val) {
    //   this.$refs.allUsers.refresh();
    //   this.getEquipments(1);
    //   this.$refs.popupEquipment.open();
    //   this.searchEquipment = "";
    // }
  },
  mounted() {
    this.Read = Ls.get("auth.permissionsRead");
    this.Write = Ls.get("auth.permissionsWrite");
    this.Delete = Ls.get("auth.permissionsDelete");
    this.$refs.popupCity.open();
    this.getMedicines();
    this.getCities();
    this.MedicineCategory();
    this.testCatDropdown();
    this.getLaboratories();
    this.getServicesCat();
    this.getEquipmentsDrop(); 
    this.getMiscellaneousMedicineDrop(); 
    this.getPrescriptionPic();
    this.getUser();
  },
  computed: {
    selectOptions() {
      this.equipments.forEach((key, value) => {
        // console.log(this.equipments);
        this.EquipmentsDrop.push({
          name: key.equipment_name,
          quantity: "1",
          price: key.price,
          brand: key.brand,
          id: key.id
        });
      });

      return this.EquipmentsDrop;
    },
    selectMedOptions() {
      this.miscellaneous_medicine.forEach((key, value) => {
        // console.log(this.equipments);
        this.miscellaneousMedicineDrop.push({
          name: key.medicine_name,
          quantity: "1",
          price: key.price,
          id: key.id
        });
      });

      return this.miscellaneousMedicineDrop;
    }
  },
  methods: {
    async addEquipment(id) {
      form.EquipmentForm.id = id;
      this.form.EquipmentForm.push({
        id: "",
        equipPrice: "",
        equipName: "",
        equipBrand: ""
      });
    },
    async getMedicines() {
      try {
        const response = await axios.get(`/api/admin/medicines/dropdown/get`);
        this.medicine = response.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async MedicineCategory() {
      try {
        const response = await axios.get(
          `/api/admin/medicineCategory/MedicineCategory`
        );
        this.category = response.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async loadMedicineCategory() {
      try {
        const response = await axios.get(
          `/api/admin/medicineCategory/MedicineOfCategory/${this.selectedcategory}`
        );
        this.medicine = response.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async LoadgetTests() {
      try {
        const response = await axios.get(
          `/api/admin/Tests/dropdownTests/get/${this.selectedTestCat}`
        );
        this.tests = response.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async LoadgetTestsCats() {
      try {
        const response = await axios.get(
          `/api/admin/Tests/dropdown/get/${this.selectedLab.id}`
        );
        this.testsCats = response.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async getCities() {
      try {
        const response = await axios.get(`/api/admin/cities/getCitiesToShow`);
        this.cities = response.data;
        // console.log(this.cities)
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async testCatDropdown() {
      try {
        const response = await axios.get(`/api/admin/TestsCategory/get`);
        this.form.Testcategory = response.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async getLaboratories() {
      try {
        const response = await axios.get(
          `/api/admin/Laboratories/dropdown/get/`
        );
        this.labs = response.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async getServicesCat() {
      try {
        const response = await axios.get(`/api/admin/Services/Dropdown/get`);
        this.servicesCat = response.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },

    async LoadAllServices(thisService, index) {
      this.OneService = thisService;
      // this.OneDate = this.form.ServicesForm;
      try {
        const response = await axios.get(
          `/api/admin/providers/dropdownOfProv/get`,
          {
            params: {
              date: this.form.ServicesForm[index].NeedDate,
              fromTime: this.form.ServicesForm[index].fromTime,
              toTime: this.form.ServicesForm[index].toTime,
              service: this.form.ServicesForm[index].selectedSerCat.id
            }
          }
        );
        this.services = response.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async getEquipmentsDrop() {
      try {
        const response = await axios.get(`/api/admin/Equipments/dropdown/get`);
        this.equipments = response.data.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async getMiscellaneousMedicineDrop() {
      try {
        const response = await axios.get(`/api/admin/medicines/miscelleneousdropdown/get`);
        // console.log(response.data)
        this.miscellaneous_medicine = response.data;
      } catch (error) {
        if (error) {
          window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    
    equipmentDropD(index) {
      // console.log(OneEquipment);
      // this.form.EquipmentForm[index].equipName = OneEquipment;
      // console.log(this.form.EquipmentForm[index]);
      // console.log(this.form.EquipmentForm[index]);
      // console.log("---");

      this.OneIndex[index] = JSON.parse(
        JSON.stringify(this.form.EquipmentForm[index])
      );
      // console.log(this.OneIndex[index]);
      // console.log("---");

      this.OneIndex[index] = this.form.EquipmentForm[index];
      // console.log(this.OneIndex[index]);
      // console.log("---");
      // this.OneIndex = JSON.parse(JSON.stringify(this.form.EquipmentForm[index]));
      // console.log(this.OneIndex);
      // console.log(this.form.EquipmentForm[index].searchEquipment.index);
      // console.log(this.form.EquipmentForm[index]);
      // console.log(this.form.EquipmentForm[index].value.searchEquipment);
      // console.log(this.form.EquipmentForm[index].searchEquipment);
      // console.log(index);

      this.$refs.allUsers.refresh();
      // this.OneIndex = index;
      this.getEquipments(1);
      this.$refs.popupEquipment.open();
      // this.EquipmentForm[index].searchEquipment = "";
    },
    removeOrder() {},
    addNewApartmentMeds: function() {
      window.toastr["success"]("Medicine added successfully", "Success");
      this.form.MedsForm.push({
        selectedMedicine: "",
        selectedcategory: "",
        quantity: ""
      });
      this.checkMedIndex++;
    },
    removeApartmentMeds(index) {
      this.form.MedsForm.splice(this.form.MedsForm.indexOf(index), 1);
    },
    addNewApartmentTests: function() {
      window.toastr["success"]("Lab Test added successfully", "Success");
      this.form.TestsForm.push({
        selectedPrescription: "",
        selectedTestcat: "",
        selectedOneLab: "",
        selectedTest: ""
      });
      this.checkTestIndex++;
    },
    removeApartmentTests(index) {
      this.form.TestsForm.splice(this.form.ServicesForm.indexOf(index), 1);
    },
    addNewApartmentService: function() {
      this.form.ServicesForm.push({
        fromTime: "",
        toTime: "",
        datesRange: "",
        NeedDate: "",
        selectedSerCat: "",
        selectedSer: ""
      });
    },
    differentLabs(thisLab) {
      this.LoadgetTestsCats(thisLab);
    },
    differentServices(thisService, index) {
      this.LoadAllServices(thisService, index);
    },
    // removeApartmentService(index) {
    //   this.form.ServicesForm.splice(this.form.ServicesForm.indexOf(index),1);
    // },
    // serviceProDate(date){
    //     this.form.ServicesForm.NeedDate = date;
    // }
    // serviceProDate(date){
    //     this.form.ServicesForm.NeedDate = date;
    // }

    // formatter(value, rowProperties) {
    //   return moment(value).format("Do MMM YYYY");
    // },
    // Formatter(value, rowProperties) {alert(value)
    //   return this.$moment(time).format(' mm:ss');
    // },
    async equipAdd() {
      this.CountTotalAmount();
      window.toastr["success"]("added successfully", "Success");
    },
    async CountTotalAmount() {
      // console.log(this.form.EquipmentForm.selectedEquipmets)
      var EquipmentTotalPrice = 0,
        MedicineTotalPrice = 0,
        TestsTotalPrice = 0,
        miscellaneousMedTotalPrice = 0
      // console.log(this.form.EquipmentForm.selectedEquipmets)
      if (this.form.EquipmentForm.selectedEquipmets != undefined) {
        this.form.EquipmentForm.selectedEquipmets.forEach(function(obj) {
          EquipmentTotalPrice += obj["price"] * obj["quantity"];
        });
      }
      if (this.form.miscellaneousMedForm.selectedMedicine != undefined) {
        this.form.miscellaneousMedForm.selectedMedicine.forEach(function(obj) {
          miscellaneousMedTotalPrice += obj["price"] * obj["quantity"];
        });
      }
      this.form.MedsForm.forEach(function(obj) {
        if (obj["selectedMedicine"] != "") {
          MedicineTotalPrice +=
            obj["selectedMedicine"]["price"] * obj["quantity"];
        }
      });
      this.form.TestsForm.forEach(function(obj) {
        if (obj["selectedTest"] != "") {
          TestsTotalPrice += obj["selectedTest"]["price"] * obj["quantity"];
        }
      });
      this.form.TotalAmount =
        EquipmentTotalPrice + MedicineTotalPrice + TestsTotalPrice + miscellaneousMedTotalPrice;
        if(this.form.TotalAmount <= 1500 && this.form.TotalAmount != 0){
            this.form.TotalAmount = this.form.TotalAmount + 200;
        }
      // this.$refs.totalAmount.open()
    },
    async submitOrder() {
      this.$v.form.$touch()
      if (this.$v.form.$error) return
      // console.log(this.form.EquipmentForm.selectedEquipmets)
      // console.log(this.form.MedsForm)
      this.CountTotalAmount();
      try {
        let response = await window.axios.post("/api/admin/orders/newOrder", {
          data: this.form,
          prescription_id: this.prescrip_id,
          equipdata: this.form.EquipmentForm.selectedEquipmets,
          miscellaneousMedicinedata: this.form.miscellaneousMedForm.selectedMedicine

        });
        window.toastr["success"](
          response.data.ResponseHeader.ResponseMessage,
          "Success"
        );
        if(this.prescrip_id){
          this.changeStatus();
        this.$router.push("/prescriptions");
        }
        else{
        // location.reload();

        }
      } catch (error) {
        if (error) {
          window.toastr["error"](
            response.data.ResponseHeader.ResponseMessage,
            "Error"
          );
        }
      }
    },
    async getPrescriptionPic(){
      try {
        this.prescrip_id = this.$route.params.OrdersId;
        if(this.prescrip_id){
          const response = await axios.get(
          `/api/admin/users/userprescription?prescrip_id=${this.prescrip_id}`
        );
        this.Prescription_pic = response.data.prescription_path

        }
      } catch (error) {
        if (error) {
          // window.toastr["error"]("There was an error", "Error");
        }
      }

    },
    onImageLoadFailure (event) {
        event.target.src = this.imagelink + 'prescriptions/prescription_icon.png';     
    },
    prescriptionModel(Prescription) {
      this.Prescription = Prescription;
    },
    async getUser() {
      try {
        let userId = this.$route.params.UserId;
        if(userId){
          const response = await axios.get(`/api/admin/users/edit/${userId}`);
        // this.form.full_name = response.data[0].full_name;
        // this.form.phone = response.data[0].phone;
        this.form.user_id = response.data[0].id;
        this.form.shipping_id = response.data[0].shipping_id;
        this.form.billing_id = response.data[0].billing_id;
        if(response.data[0].billing != null){
          this.form.billingCity = response.data[0].billing.city;
        this.form.billingHome_address = response.data[0].billing.home_address;
        this.form.billingProvince = response.data[0].billing.province;
        this.form.billingPhone = response.data[0].billing.phone;
        this.form.billingFirstName = response.data[0].billing.first_name;
        this.form.billingLastName = response.data[0].billing.last_name;

        }
        if(response.data[0].shipping != null){
          this.form.shippingCity = response.data[0].shipping.city;
        this.form.shippingHome_address = response.data[0].shipping.home_address;
        this.form.shippingProvince = response.data[0].shipping.province;
        this.form.shippingPhone = response.data[0].shipping.phone;
        this.form.shippingFirstName = response.data[0].shipping.first_name;
        this.form.shippingLastName = response.data[0].shipping.last_name;

        }

        }
      } catch (error) {
        if (error) {
          // window.toastr["error"]("There was an error", "Error");
        }
      }
    },
    async changeStatus(){
      try {
        let response = await window.axios.post(`/api/admin/users/userprescriptionUpdate/${this.prescrip_id}`);
        window.toastr["success"](
          response.data.ResponseHeader.ResponseMessage,
          "Success"
        );
      } catch (error) {
        if (error) {
          window.toastr["error"](
            response.data.ResponseHeader.ResponseMessage,
            "Error"
          );
        }
      }

    }
  }
};
</script>
