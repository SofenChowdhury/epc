<!--<style>-->
<!--    .md-menu-content.md-select-menu {-->
<!--        width: auto;-->
<!--        max-width: none;-->
<!--        min-width: auto;-->
<!--    }-->
<!--</style>-->
<!--<template>-->
<!--    <div>-->
<!--        <form @submit.prevent="create">-->
<!--            <div class="row md-layout md-gutter">-->
<!--                <div class="col-md-3 md-layout-item">-->
<!--                    <label for="" class="col-form-label">Indent Title:</label>-->
<!--                    <input type="text" class="form-control p-2" value="" name="title" id=""/>-->
<!--                </div>-->

<!--                <div class="col-md-3 md-layout-item">-->
<!--                    <label for="voucher_no" class="col-form-label">Voucher No:</label>-->
<!--                    <input type="text" class="form-control p-2" required readonly value="" name="voucher_no" id="voucher_no" :value="form.voucher"/>-->
<!--                </div>-->

<!--                <div class="col-md-3">-->
<!--                    <label for="transaction_date" class="col-form-label">Indent date:</label>-->
<!--                    <md-datepicker v-model="form.date" autocomplete="off" required id="transaction_date" name="transaction_date" class="form-control pt-1 m-0" md-immediately/>-->
<!--                </div>-->

<!--            </div>-->

<!--            <div class="row">-->
<!--                <div class="form-group col-md-6">-->
<!--                    <label for="description" class="col-form-label">Indent Remark: </label>-->
<!--                    <textarea v-model="form.description" class="form-control" name="description" id="description"></textarea>-->
<!--                </div>-->
<!--            </div>-->

<!--            <div class="row">-->
<!--                <div class="col-md-12 table-responsive">-->
<!--                    <table class="table table-sm voucher-table">-->
<!--                        <thead>-->
<!--                        <tr class="table-info">-->
<!--                            <th scope="col" width="20%">Name of vendor/Paid to</th>-->
<!--                            <th scope="col"width="20%">Purpose of Payment</th>-->
<!--                            <th scope="col"width="20%">Project Exp Code</th>-->
<!--                            <th scope="col"width="15%">Amount</th>-->
<!--                            <th scope="col"width="15%">Remark</th>-->
<!--                            <th scope="col"width="10%">Action</th>-->
<!--                        </tr>-->
<!--                        </thead>-->
<!--                        <tbody>-->
<!--                        <tr class="table pb-0">-->
<!--                            <td class="pb-0">-->
<!--                                <div class="form-group">-->
<!--                                    <md-field>-->
<!--                                        <input type="text" class="form-control" placeholder="Name of vendor/Paid to" v-model="keywords0"/>-->
<!--                                    </md-field>-->
<!--                                </div>-->
<!--                            </td>-->
<!--                            <td class="pb-0">-->
<!--                                <div class="form-group">-->
<!--                                    <md-field>-->
<!--                                        <input type="text" class="form-control" placeholder="Purpose of Payment" v-model="keywords1"/>-->
<!--                                    </md-field>-->
<!--                                </div>-->
<!--                            </td>-->
<!--                            <td class="pb-0">-->
<!--                                <div class="form-group">-->
<!--                                    <md-field>-->
<!--                                        <input type="text" class="form-control" placeholder="Project Exp Code" v-model="keywords2"/>-->
<!--                                    </md-field>-->
<!--                                </div>-->
<!--                            </td>-->
<!--                            <td class="pb-0">-->
<!--                                <div class="form-group">-->
<!--                                    <md-field>-->
<!--                                        <input type="number" class="form-control" placeholder="Amount" v-model="keywords3"/>-->
<!--                                    </md-field>-->
<!--                                </div>-->
<!--                            </td>-->
<!--                            <td class="pb-0">-->
<!--                                <div class="form-group">-->
<!--                                    <md-field>-->
<!--                                        <input type="text" class="form-control" placeholder="Remark" v-model="keywords4"/>-->
<!--                                    </md-field>-->
<!--                                </div>-->
<!--                            </td>-->

<!--                            <td></td>-->
<!--                        </tr>-->

<!--                        <tr class="table pb-0" v-for="(field,index) in fields">-->
<!--                            <td class="pb-0">-->
<!--                                <div class="form-group">-->
<!--                                    <md-field>-->
<!--                                        <input value="" type="text" class="form-control" placeholder="Name of vendor/Paid to" v-model="keywords0"/>-->
<!--                                    </md-field>-->
<!--                                </div>-->
<!--                            </td>-->
<!--                            <td class="pb-0">-->
<!--                                <div class="form-group">-->
<!--                                    <md-field>-->
<!--                                        <input value="" type="text" class="form-control" placeholder="Purpose of Payment" v-model="keywords1"/>-->
<!--                                    </md-field>-->
<!--                                </div>-->
<!--                            </td>-->
<!--                            <td class="pb-0">-->
<!--                                <div class="form-group">-->
<!--                                    <md-field>-->
<!--                                        <input value="" type="text" class="form-control" placeholder="Project Exp Code" v-model="keywords2"/>-->
<!--                                    </md-field>-->
<!--                                </div>-->
<!--                            </td>-->
<!--                            <td class="pb-0">-->
<!--                                <div class="form-group">-->
<!--                                    <md-field>-->
<!--                                        <input value="0" type="number" class="form-control" placeholder="Amount" v-model="keywords3"/>-->
<!--                                    </md-field>-->
<!--                                </div>-->
<!--                            </td>-->
<!--                            <td class="pb-0">-->
<!--                                <div class="form-group">-->
<!--                                    <md-field>-->
<!--                                        <input value="" type="text" class="form-control" placeholder="Remark" v-model="keywords4"/>-->
<!--                                    </md-field>-->
<!--                                </div>-->
<!--                            </td>-->
<!--                            <td> <input type="button" @click="dataRemove(index), reduceAmount(field)" required class="btn btn-md btn-danger mt-3"  value="Delete" :disabled="disabledDelete(field)"/></td>-->
<!--                        </tr>-->
<!--                        </tbody>-->
<!--                        <tfoot>-->
<!--                        <tr>-->
<!--                            <td>-->
<!--                                <div class="row">-->
<!--                                    <input type="button" @click="newfield" class="btn btn-info mt-3" id="addrow" value="Add New Field" />-->
<!--                                </div>-->
<!--                            </td>-->

<!--                            <td>-->
<!--                                <input type="submit" class="btn btn-info mt-3"  value="Save Indent"/>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        </tfoot>-->
<!--                    </table>-->
<!--                </div>-->
<!--            </div>-->
<!--        </form>-->
<!--        <div>{{auth}}</div>-->
<!--    </div>-->
<!--</template>-->
<!--<script>-->
<!--    export default {-->
<!--        props:['user-id'],-->

<!--        data() {-->
<!--            return {-->
<!--                categories: {},-->
<!--                projects: {},-->
<!--                fields: [],-->
<!--                keywords: '',-->
<!--                debit_sum:0,-->
<!--                credit_sum:0,-->

<!--                form:{-->
<!--                    voucher: 0,-->
<!--                    allDebit: 0,-->
<!--                    allCredit: 0,-->
<!--                    type1:0,-->
<!--                    type2:0,-->
<!--                    date: new Date().toISOString().slice(0,10),-->
<!--                    // date: new Date().toISOString().substr(0, 10),-->
<!--                    description:'',-->
<!--                    auth_id: 0,-->
<!--                    debit1: 0,-->
<!--                    credit1: 0,-->
<!--                    debit2: 0,-->
<!--                    credit2: 0,-->
<!--                },-->
<!--            };-->
<!--        },-->
<!--        created() {-->
<!--            this.getCOAs();-->
<!--            axios.get("/epc/api/transaction/project").then(res => (this.projects = res.data.data))-->
<!--                .catch(error => (this.errors = error.response.data.errors));-->
<!--            axios.get("/epc/api/transaction/voucher").then(res => (this.form.voucher = res.data))-->
<!--                .catch(error => (this.errors = error.response.data.errors));-->
<!--        },-->
<!--        watch: {-->
<!--            keywords(before, after){-->
<!--                this.getCOAs();-->
<!--            }-->
<!--        },-->
<!--        methods: {-->
<!--            getCOAs(){-->
<!--                axios.get("/epc/api/transaction/category", {params: {keywords: this.keywords}}).then(res => (this.categories = res.data.data))-->
<!--                    .catch(error => (this.errors = error.response.data.errors));-->
<!--            },-->
<!--            create() {-->
<!--                axios-->
<!--                    .post("/epc/api/add_transactions",{-->
<!--                        form:this.form,-->
<!--                        fields: this.fields,-->
<!--                    }).then(function(response){-->
<!--                    window.location = response.data.redirect;-->
<!--                }).catch(function (error) {-->
<!--                    console.log(error);-->
<!--                });-->
<!--            },-->
<!--            newfield() {-->
<!--                this.fields.push({-->
<!--                    debit: 0,-->
<!--                    credit: 0,-->
<!--                    type: 0,-->
<!--                });-->
<!--            },-->

<!--            dataRemove(index) {-->
<!--                Vue.delete(this.fields, index);-->
<!--            },-->
<!--            disabledDelete(field) {-->
<!--                // if (field.debit != 0 || field.credit != 0) {-->
<!--                //     return true;-->
<!--                // }-->
<!--            },-->
<!--        },-->
<!--        computed: {-->
<!--            // submitdisabled() {-->
<!--                // if (this.form.allDebit == 0 && this.form.allCredit == 0) {-->
<!--                //     return true;-->
<!--                // } else if (this.form.allDebit == this.form.allCredit) {-->
<!--                //     return false;-->
<!--                // } else {-->
<!--                //     return false;-->
<!--                // }-->
<!--            // },-->
<!--            // disabledDebit1() {-->
<!--            //     if (this.form.credit1 != 0) {-->
<!--            //         return true;-->
<!--            //     }-->
<!--            // },-->
<!--            // disabledCredit1() {-->
<!--            //     if (this.form.debit1 != 0) {-->
<!--            //         return true;-->
<!--            //     }-->
<!--            // },-->
<!--            // disabledDebit2() {-->
<!--            //     if (this.form.credit2 != 0) {-->
<!--            //         return true;-->
<!--            //     }-->
<!--            // },-->
<!--            // disabledCredit2() {-->
<!--            //     if (this.form.debit2 != 0) {-->
<!--            //         return true;-->
<!--            //     }-->
<!--            // },-->
<!--            // allDebits() {-->
<!--            //     this.debit_sum =parseFloat(this.form.debit1)+parseFloat(this.form.debit2);-->
<!--            //     return this.form.allDebit = (this.fields.reduce((acc, item) => acc + parseFloat(item.debit), 0))+ this.debit_sum;-->
<!--            // },-->
<!--            // allCredits() {-->
<!--            //     this.credit_sum=parseFloat(this.form.credit1)+parseFloat(this.form.credit2);-->
<!--            //     return this.form.allCredit = (this.fields.reduce((acc, item) => acc + parseFloat(item.credit), 0))+this.credit_sum;-->
<!--            // },-->
<!--            auth(){-->
<!--                this.form.auth_id= this.userId;-->
<!--            },-->
<!--        },-->
<!--    };-->
<!--</script>-->
