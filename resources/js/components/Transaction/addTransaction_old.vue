<style>
    .md-menu-content.md-select-menu {
        width: auto;
        max-width: none;
        min-width: auto;
    }
    .md-select-menu{
        margin-left: 21% !important;
    }
</style>
<template>
    <div>
        <form @submit.prevent="create">
            <div class="row md-layout md-gutter">
                <div class="col-md-3">
                    <label for="transaction_date" class="col-form-label">Transaction date:</label>
                    <md-datepicker v-model="form.date" autocomplete="off" required id="transaction_date" name="transaction_date" class="form-control pt-1 m-0" md-immediately/>
                    <!--                    <input type="text" v-model="form.date" class="form-control datepicker" autocomplete="off" required id="transaction_date" name="transaction_date"/>-->
                </div>
                <div class="col-md-3 md-layout-item">
                    <label for="voucher_no" class="col-form-label">Voucher No:</label>
                    <input type="text" class="form-control p-2" required readonly value="" name="voucher_no" id="voucher_no" :value="form.voucher"/>
                </div>
                <!--                <div class="col-md-3 md-layout-item">-->
                <!--                    <label class="col-form-label">Select project (optional)</label>-->
                <!--                    <md-field style="margin: 0; padding: 0; min-height: 37px;">-->
                <!--                        <md-select v-model="form.project" class="form-control col-sm-12" name="project" id="project" style="padding: 0; height: 37px;">-->
                <!--                            <md-option disabled selected value="">Choose your Project</md-option>-->
                <!--                            <md-option v-for="project in projects" :value="project.id" style="padding-left: 2px;">{{project.name}}</md-option>-->
                <!--                        </md-select>-->
                <!--                    </md-field>-->
                <!--                </div>-->
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="description" class="col-form-label">Description: </label>
                    <textarea v-model="form.description" class="form-control" name="description" id="description"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="table table-sm voucher-table">
                        <thead>
                        <tr class="table-info">
                            <th scope="col" width="35%">Account</th>
                            <th scope="col">Debit</th>
                            <th scope="col">Credit</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr class="table pb-0">
                            <td class="pb-0">
                                <div class="form-group coa_category">
                                    <md-field>
                                        <md-select v-model="form.type1" name="Account" class="form-control" :searchable="true">
                                            <v-input placeholder="Search by name..." v-model="search" @input="searchAccounts" />
                                            <md-button style="width: 93%;text-align: left;font-size: 12px;" value="all" ng-click="fnSelectAllRoute()">{{routeToggleText}}</md-button>
                                            <md-optgroup class="form-control" v-for="category in categories" :label="category.category_name">
                                                <md-optgroup v-for="header in category.coa_header" :label="header.header_name">
                                                    <md-option v-for="coa in header.coa" :value="coa.id" v-if="coa.child == null">{{coa.coa_reference_no}} . {{coa.coa_name}}</md-option>
                                                    <md-optgroup v-for="coa_p in header.coa" :label="coa_p.coa_name" v-if="coa_p.child != null">
                                                        <md-option v-for="child in coa_p.coa_child" :value="child.id">{{child.coa_reference_no}} . {{child.coa_name}}</md-option>
                                                    </md-optgroup>
                                                </md-optgroup>
                                            </md-optgroup>
                                        </md-select>
                                    </md-field>
                                </div>
                            </td>
                            <td>
                                <input type="number" step="0.01" value="0" required class="form-control debit-input input-debit0 mt-3 p-2" v-model="form.debit1" name="debit0" :disabled="disabledDebit1"/>
                            </td>
                            <td>
                                <input type="number" step="0.01" value="0" required class="form-control credit-input input-credit0 mt-3 p-2" v-model="form.credit1" name="credit0" :disabled="disabledCredit1" />
                            </td>
                            <td></td>
                        </tr>
                        <tr class="table pb-0">
                            <td class="pb-0">
                                <div class="form-group coa_category">
                                    <md-field>
                                        <md-select v-model="form.type2" name="Account" class="form-control" searchable="Search here..">
                                            <md-optgroup class="form-control" v-for="category in categories" :label="category.category_name">
                                                <md-optgroup v-for="header in category.coa_header" :label="header.header_name">
                                                    <md-option v-for="coa in header.coa" v-model="coa.id" v-if="coa.child == null">{{coa.coa_reference_no}} . {{coa.coa_name}}</md-option>
                                                    <md-optgroup v-for="coa_p in header.coa" :label="coa_p.coa_name" v-if="coa_p.child != null">
                                                        <md-option v-for="child in coa_p.coa_child" v-model="child.id">{{child.coa_reference_no}} . {{child.coa_name}}</md-option>
                                                    </md-optgroup>
                                                </md-optgroup>
                                            </md-optgroup>
                                        </md-select>
                                    </md-field>
                                </div>
                            </td>
                            <td>
                                <div class="form-group mt-2">
                                    <input type="number" step="0.01"  value="0" required class="form-control debit-input input-debit0 mt-3 p-2" v-model="form.debit2" name="debit0" :disabled="disabledDebit2" />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="number" step="0.01" value="0" required class="form-control credit-input input-credit0 mt-3 p-2" v-model="form.credit2" name="credit0" :disabled="disabledCredit2"/>
                                </div>
                            </td>
                            <td></td>
                        </tr>

                        <tr class="table pb-0" v-for="(field,index) in fields">
                            <td class="pb-0">
                                <div class="form-group coa_category">
                                    <md-field>
                                        <md-select v-model="field.type" name="Account" class="form-control" searchable="Search here..">
                                            <md-optgroup class="form-control" v-for="category in categories" :label="category.category_name">
                                                <md-optgroup v-for="header in category.coa_header" :label="header.header_name">
                                                    <md-option v-for="coa in header.coa" :value="coa.id" v-if="coa.child == null">{{coa.coa_reference_no}} . {{coa.coa_name}}</md-option>
                                                    <md-optgroup v-for="coa_p in header.coa" :label="coa_p.coa_name" v-if="coa_p.child != null">
                                                        <md-option v-for="child in coa_p.coa_child" :value="child.id">{{child.coa_reference_no}} . {{child.coa_name}}</md-option>
                                                    </md-optgroup>
                                                </md-optgroup>
                                            </md-optgroup>
                                        </md-select>
                                    </md-field>
                                </div>
                            </td>
                            <td>
                                <input type="number" step="0.01" value="0" required class="form-control debit-input input-debit0 mt-3 p-2" v-model="field.debit" name="debit0" :disabled="disabledDebit(field)" />
                            </td>
                            <td>
                                <input type="number" step="0.01" value="0" required class="form-control credit-input input-credit0 mt-3 p-2" v-model="field.credit" name="credit0" :disabled="disabledCredit(field)"/>
                            </td>
                            <td> <input type="button" @click="dataRemove(index);reduceAmount(field)" required class="btn btn-md btn-danger mt-3"  value="Delete" :disabled="disabledDelete(field)"/></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td>
                                <div class="row">
                                    <input type="button" @click="newfield" class="btn btn-info mt-3" id="addrow" value="Add new" />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label >Total Debit:</label>
                                    <input type="text" readonly class="form-control debit-total inline-input mt-3" v-model="allDebits"  disabled name="total_debit"/>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label >Total Credit:</label>
                                    <input type="text" readonly class="form-control credit-total inline-input mt-3" v-model="allCredits" disabled name="total_credit"/>
                                </div>
                            </td>
                            <td>
                                <input type="submit" class="btn btn-info mt-3" value="Save" :disabled="submitdisabled" />
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </form>
        <div>{{auth}}</div>
    </div>
</template>
<script>
    function toLower(text) {
        return text.toString().toLowerCase()
    }
    function searchAccount(items, term) {
        if (term) {
            return items.filter(function(ieetem) {
                return toLower(ieetem.coa_name).includes(toLower(term))
            })
        }
        return items
    }
    export default {
        props:['user-id'],

        data() {
            return {
                categories: {},
                projects: {},
                fields: [],
                search: '',
                searched: [],
                debit_sum:0,
                credit_sum:0,

                form:{
                    voucher: 0,
                    allDebit: 0,
                    allCredit: 0,
                    type1:0,
                    type2:0,
                    date: new Date().toISOString().slice(0,10),
                    // date: new Date().toISOString().substr(0, 10),
                    description:'',
                    auth_id: 0,
                    debit1: 0,
                    credit1: 0,
                    debit2: 0,
                    credit2: 0,
                },
            };
        },
        created() {
            axios.get("/epc/api/transaction/category").then(res => (this.categories = res.data.data))
                .catch(error => (this.errors = error.response.data.errors));
            axios.get("/epc/api/transaction/project").then(res => (this.projects = res.data.data))
                .catch(error => (this.errors = error.response.data.errors));
            axios.get("/epc/api/transaction/voucher").then(res => (this.form.voucher = res.data))
                .catch(error => (this.errors = error.response.data.errors));
        },
        methods: {
            create() {
                axios
                    .post("/epc/api/add_transactions",{
                        form:this.form,
                        fields: this.fields,
                    }).then(function(response){
                    window.location = response.data.redirect;
                }).catch(function (error) {
                    console.log(error);
                });
            },
            newfield() {
                this.fields.push({
                    debit: 0,
                    credit: 0,
                    type: 0,
                });
            },

            dataRemove(index) {
                Vue.delete(this.fields, index);
            },
            disabledDebit(field) {
                if (field.credit != 0) {
                    return true;
                }
            },
            disabledCredit(field) {
                if (field.debit != 0) {
                    return true;
                }
            },
            disabledDelete(field) {
                if (field.debit != 0 || field.credit != 0) {
                    return true;
                }
            },
            reduceAmount(field) {
                this.form.allDebit = this.form.allDebit - field.debit;
                this.form.allCredit = this.form.allCredit - field.credit;
            },
            searchAccounts: function searchAccounts() {
                this.searched = searchAccount(this.form.type1, this.search)
            },
        },
        computed: {
            submitdisabled() {
                if (this.form.allDebit == 0 && this.form.allCredit == 0) {
                    return true;
                } else if (this.form.allDebit == this.form.allCredit) {
                    return false;
                } else {
                    return true;
                }
            },
            disabledDebit1() {
                if (this.form.credit1 != 0) {
                    return true;
                }
            },
            disabledCredit1() {
                if (this.form.debit1 != 0) {
                    return true;
                }
            },
            disabledDebit2() {
                if (this.form.credit2 != 0) {
                    return true;
                }
            },
            disabledCredit2() {
                if (this.form.debit2 != 0) {
                    return true;
                }
            },
            allDebits() {
                this.debit_sum =parseFloat(this.form.debit1)+parseFloat(this.form.debit2);
                return this.form.allDebit = (this.fields.reduce((acc, item) => acc + parseFloat(item.debit), 0))+ this.debit_sum;
            },
            allCredits() {
                this.credit_sum=parseFloat(this.form.credit1)+parseFloat(this.form.credit2);
                return this.form.allCredit = (this.fields.reduce((acc, item) => acc + parseFloat(item.credit), 0))+this.credit_sum;
            },
            auth(){
                this.form.auth_id= this.userId;
            },
        },
    };
</script>
